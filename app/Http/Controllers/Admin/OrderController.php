<?php
namespace App\Http\Controllers\Admin;
  
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseTime;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Role;
use App\Models\Student;
use App\Models\SysLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends Controller
{
    //列表
    public function index(){

        return view('admin.order.index');
    }

    public function getData(Request $request)
    {
        $keywords = $request->get('keywords');
        $starttime = $request->get('starttime');
        $endtime = $request->get('endtime');

        $list = Order::with(['student','created_info']);
        if ($keywords){
            $list->where(function($query)use($keywords){
                $query->where('pay_name','like',"%{$keywords}%")->orWhere('order_by', 'like', "%{$keywords}%");
            });
        }
        if ($starttime){
            $list->where('order_at','>=',$starttime);
        }
        if ($endtime){
            $list->where('order_at','<=',$endtime);
        }
        $list  = $list->paginate($request->get('limit',10))->toArray();

        foreach ($list['data'] as &$item) {
            $item['status_name'] = $item['status']==1?'正常':'<span style="color:red">退款</span>';
            if ($item['student']){
                $item['student_name'] = $item['student']['name'];
            }
            $item['created_by_name'] = $item['created_info']['name'];
            $item['style'] = $item['status']==-1?'display:none':'';
        }
        // 获取状态分组
        $data=array(
            'code'=>0,
            'msg'=>'',
            'data'=>$list['data'],
            'count'=>$list['total']
        );
        return response()->json($data);

    }

    // 新增
    public function add()
    {
        $student = Student::query()->get()->toArray();
        return view('admin.order.add',compact('student'));
    }

    public function save(Request $request)
    {
        $data = $request->all();
        $data['identifier'] = $this->getIdent();
        $adminUser = $request->user()->toArray();
        $data['created_by'] = $adminUser['id'];
        $res = Order::create($data);
        if ($res){
            $this->addSysLog([
                'user_id' => $adminUser['id'],
                'username' => $adminUser['name'],
                'module' => SysLog::manage_order,
                'page' => '收款管理',
                'type' => SysLog::add,
                'content' => '收款管理新增：'.$res->id,
            ]);
            return redirect()->to(route('admin.order'))->with(['status'=>'添加成功']);
        }else{
            return Redirect::back()->withErrors(['更新失败,请重试'])->withInput();
        }
    }

    private function getIdent()
    {
        $Str = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $rangtr1 = $Str[rand(0,25)];
        $rangtr2 = $Str[rand(0,25)];
        $rangtime = date("Ymd",time());
        $rangnum = rand(00,99);
        $identifier = 'SK-'.$rangtime.$rangtr1.$rangtr2.$rangnum;
        return $identifier;
    }

    //编辑
    public function edit($id){

        $info = Order::query()->find($id);
        if (!$info){
            return redirect()->to(route('admin.course'))->withErrors('未找到收款信息');
        }
        $student = Student::query()->get()->toArray();
        return view('admin.order.edit', compact('info','student'));
    }

    public function update(Request $request,$id)
    {
        $info = Order::query()->find($id);

        $data = $request->all();

        if ($info->update($data)){
            $adminUser = $request->user()->toArray();
            $this->addSysLog([
                'user_id' => $adminUser['id'],
                'username' => $adminUser['name'],
                'module' => SysLog::manage_order,
                'page' => '收款管理',
                'type' => SysLog::edit,
                'content' => '收款管理编辑：'.$id,
            ]);
            return redirect(route('admin.order'))->with(['status'=>'更新成功']);
        }
        return Redirect::back()->withErrors(['更新失败,请重试'])->withInput();

    } 

    //查看
    public function show(Request $request,$id)
    {
        $info = Order::with(['student','created_info'])->find($id);
        return view('admin.order.show',compact('info'));
    }

    //退款
    public function refund(Request $request)
    {
        $id = $request->get('id');
        $info = Order::query()->find($id);
        $info->status = -1;
        if ($info->update()){
            if ($info->student_id){
                $student = Student::query()->find($info->student_id);
                $student->status = '退费';
                $student->update();
            }
            $adminUser = $request->user()->toArray();
            $this->addSysLog([
                'user_id' => $adminUser['id'],
                'username' => $adminUser['name'],
                'module' => SysLog::manage_order,
                'page' => '收款管理',
                'type' => SysLog::refund,
                'content' => '收款管理退款：'.$id,
            ]);
            $data=array(
                'code'=>0,
                'msg'=>'退款成功'
            );
            return response()->json($data);
        }else{
            $data=array(
                'code'=>-1,
                'msg'=>'退款失败，请重试'
            );
        }
    }

    //导出
    public function export(Request $request)
    {
        $param = $request->get('param');
        $param = json_decode($param,true);
        $keywords = $param['keywords'];
        $starttime = $param['starttime'];
        $endtime = $param['endtime'];
        $list = Order::with(['student','created_info']);
        if ($keywords){
            $list->where(function($query)use($keywords){
                $query->where('pay_name','like',"%{$keywords}%")->orWhere('order_by', 'like', "%{$keywords}%");
            });
        }
        if ($starttime){
            $list->where('order_at','>=',$starttime);
        }
        if ($endtime){
            $list->where('order_at','<=',$endtime);
        }
        $list  = $list->get();

        ini_set('memory_limit','500M');
        set_time_limit(0);//设置超时限制为0分钟

        $cellData[0]=['收款编号','付款人','付款时间','付款金额','付款方式','流水号','状态','关联学员','创建人','创建时间'];

        foreach ($list as &$v)
        {
            $cellData[] = [
                $v->identifier,
                $v->pay_name,
                $v->order_at,
                $v->amount,
                $v->way,
                $v->flow,
                $v->status==1?'正常':'退款',
                $v->student->name,
                $v->created_info->name,
                $v->created_at
            ];
        }
        // sys_log表
        $adminUser = $request->user()->toArray();
        $this->addSysLog([
            'user_id' => $adminUser['id'],
            'username' => $adminUser['name'],
            'module' => SysLog::manage_order,
            'page' => '收款管理',
            'type' => SysLog::export,
            'content' => '收款管理导出',
        ]);


        Excel::create('收款信息',function($excel) use ($cellData){
            $excel->sheet('order', function($sheet) use ($cellData){
                $sheet->rows($cellData);
            });
        })->export('xlsx');
    }
}