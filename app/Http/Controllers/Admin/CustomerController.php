<?php
namespace App\Http\Controllers\Admin;
  
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Student;
use App\Models\SysLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Redirect;

class CustomerController extends Controller
{
    //列表
    public function index(){
        
        return view('admin.customer.index');
    }
    public function getData(Request $request)
    {

        $list=DB::table('customer');
        $keywords = $request->get('keywords');
        $type = $request->get('type');
        if(!empty($keywords)){
            $list->where(function($query)use($keywords){
                $query->where('child_name','like',"%{$keywords}%")->orWhere('parent_name', 'like', "%{$keywords}%")->orWhere('phone', 'like', "%{$keywords}%");
            });
        }
        if (isset($type)){
            $list->where('type',$type);
        }
        $list->leftJoin('sys_users','sys_users.id','=','customer.responer');
        $list->select('customer.*','sys_users.name');
        $list  = $list->paginate($request->get('limit',10))->toArray();
        // 获取状态分组
        $data=array(
            'code'=>0,
            'msg'=>'',
            'data'=>$list['data'],
            'count'=>$list['total']
        );
        return response()->json($data);

    }

    public function getSeachModel($param)
    {
        if(!is_array($param)){
            return false;
        }
        $model = DB::table('customer as c');
        if ($param['keywords']){
            $keywords = $param['keywords'];
            $model->where(function($query)use($keywords){
                $query->where('child_name','like',"%{$keywords}%")->orWhere('parent_name', 'like', "%{$keywords}%")->orWhere('phone', 'like', "%{$keywords}%");
            });
        }
        $model->leftJoin(DB::Raw('sys_users as u'),'u.id','=','c.responer');
        $model->leftJoin(DB::Raw('sys_users as su'),'su.id','=','c.created_by');
        $model->select('c.*','u.name as responer_name','su.name as created_name');

        return $model;

    }

    public function export(Request $request)
    {
        $param = $request->get('param');

        $param = json_decode($param,true);

        $model = $this->getSeachModel($param);
        $res = $model->get()->toArray();;

        ini_set('memory_limit','500M');
        set_time_limit(0);//设置超时限制为0分钟
        $status_array = config('customer.status_hidden');

        $cellData[0]=['信息编号','孩子姓名','家长姓名','孩子性别','孩子年龄','孩子生日','电话','手机号','兼职编号','信息渠道','渠道详情',
            '孩子小区','孩子学校','信息状态','状态说明','收集日期','详情说明','客户类型','下次回访日期',
            '描述','负责人','创建人','创建时间','更新时间','收集地址','销售描述'];

        foreach ($res as &$v)
        {
            $sex = $v->child_sex==1?'男':($v->child_sex==2?'女':'未知');
            $cellData[] = [
                $v->identifier,
                $v->child_name,
                $v->parent_name,
                $sex,
                $v->child_age,
                $v->child_birthday,
                $v->mobile,
                $v->phone,
                $v->part_number,
                $v->channel,
                $v->channel_detail,
                $v->child_area,
                $v->child_school,
                $status_array[$v->status_hidden],
                $v->status_describe,
                $v->collect_at,
                $v->explain,
                $v->customer_type,
                $v->visit_at,
                $v->describe_source,
                $v->responer_name,
                $v->created_name,
                $v->created_at,
                $v->updated_at,
                $v->collect_area,
                $v->describe_sales
            ];
        }

        // sys_log表
        $adminUser = $request->user()->toArray();
        $this->addSysLog([
            'user_id' => $adminUser['id'],
            'username' => $adminUser['name'],
            'module' => SysLog::manage_customer,
            'page' => '信息列表',
            'type' => SysLog::export,
            'content' => '信息列表列表导出',
        ]);


        Excel::create('信息列表',function($excel) use ($cellData){
            $excel->sheet('customer', function($sheet) use ($cellData){
                $sheet->rows($cellData);
            });
        })->export('xlsx');

    }

    // 新增
    public function add()
    {
        $status_array = config('customer.status_hidden');
        $customer_type = config('customer.customer_type');
        $channel = config('customer.channel');
        $user = DB::table('sys_users')->get()->toArray();
        $ids = array_column($user,'id');
        $name = array_column($user,'name');
        $users = array_combine($ids,$name);

        return view('admin.customer.add',compact(status_array,customer_type,channel,users));
    }

    public function save(Request $request)
    {
        $data = $request->all();
        unset($data['_token']);
        $data['identifier'] = $this->getIdent();
        $data['created_by'] = Auth::id();
        $res = Customer::create($data);
        if ($res){
            $adminUser = $request->user()->toArray();
            $this->addSysLog([
                'user_id' => $adminUser['id'],
                'username' => $adminUser['name'],
                'module' => SysLog::manage_customer,
                'page' => '信息列表',
                'type' => SysLog::add,
                'content' => '信息列表新增：'.$res->id,
            ]);
            return redirect()->to(route('admin.customer'))->with(['status'=>'添加成功']);
        }else{
            return redirect()->to(route('admin.customer'))->withErrors(['status'=>'系统错误']);
        }
    }

    private function getIdent()
    {
        $Str = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $rangtr = $Str[rand(0,25)].$Str[rand(0,25)];
        $rangtime = date("ymd",time());
        $rangnum = rand(1000,9999);
        $identifier = $rangtr.$rangtime.$rangnum;
        return $identifier;
    }

    public function getChannelDetail(Request $request)
    {
        $channel = $request->get('channel');
        $detailChannel = config('customer.channel_detail');
        if (array_key_exists($channel,$detailChannel)){
            $detail = $detailChannel[$channel];
        }else{
            $detail = [];
        }
        $data = [
            'code' => 0,
            'msg' => '正在请求中...',
            'data' => $detail
        ];
        return response()->json($data);
    }

    //编辑
    public function edit($id){
        $status_array = config('customer.status_hidden');
        $status_appointment = config('customer.status_appointment');
        $customer_type = config('customer.customer_type');
        $channel = config('customer.channel');
        $user = DB::table('sys_users')->get()->toArray();
        $ids = array_column($user,'id');
        $name = array_column($user,'name');
        $users = array_combine($ids,$name);

        $info = Customer::query()->find($id);
        if ($info->channel){
            $channel_detail = config('customer.channel_detail');
            if (array_key_exists($info->channel,$channel_detail)){
                $detail_channel = $channel_detail[$info->channel];
            }else{
                $detail_channel = [];
            }
        }
        if (!$info){
            return redirect()->to(route('admin.customer'))->withErrors('未找到信息');
        }

        return view('admin.customer.edit',
            compact('status_array','customer_type','channel','users','info','detail_channel','status_appointment','form_token'));
    }

    public function update(Request $request,$id)
    {
        $customer = Customer::findOrFail($id);

        $data = $request->only(['child_name','parent_name','child_age','mobile','channel','channel_detail','child_area','describe_source','child_sex','child_birthday','phone','explain','child_school','describe_sales','collect_at','collect_area','status_hidden','visit_at','part_number','status_describe','customer_type','responer','status_appointment','appointment_describe','appointment_sign','arrive_at','is_sign','arrive_person','arrive_describe','arrive_decision','refuse_reason','arrive_plan']);

        if ($customer->update($data)){
            $adminUser = $request->user()->toArray();
            $this->addSysLog([
                'user_id' => $adminUser['id'],
                'username' => $adminUser['name'],
                'module' => SysLog::manage_customer,
                'page' => '信息列表',
                'type' => SysLog::edit,
                'content' => '信息列表编辑：'.$id,
            ]);
            return redirect(route('admin.customer'))->with(['status'=>'更新成功']);
        }
        return Redirect::back()->withErrors(['更新失败,请重试'])->withInput();

    } 

    //查看
    public function show($id)
    {
        $info = Customer::with(['responer_One','create_One'])->findOrFail($id);
        $status_array = config('customer.status_hidden');
        $customer_type = config('customer.customer_type');
        $status_appointment = config('customer.status_appointment');
        return view('admin.customer.show',compact('info','status_array','customer_type','status_appointment'));

    }

    public function turn(Request $request){
        $id = intval($request->get('id'));
        $status = intval($request->get('status'));//1约访，2到访
        $info = Customer::query()->find($id);
        if ($info){
            if ($info->type<$status){
                if ($status==3){
                    $info->is_turn = 1;
                }else{
                    $info->type = $status;
                }
                $info->update();
                $data = [
                    'code' => 0,
                    'msg' => '修改成功'
                ];
            }else{
                $data = [
                    'code' => 1,
                    'msg' => '状态已修改，请刷新查看'
                ];
            }
            $adminUser = $request->user()->toArray();
            $this->addSysLog([
                'user_id' => $adminUser['id'],
                'username' => $adminUser['name'],
                'module' => SysLog::manage_customer,
                'page' => '信息列表',
                'type' => SysLog::edit,
                'content' => '信息列表编辑：'.$id.'修改状态',
            ]);
        }else{
            $data = [
                'code' => 1,
                'msg' => '未找到对应信息'
            ];
        }
        return response()->json($data);
    }

    //转为学员
    public function turn_student(Request $request){
        $id = intval($request->get('id'));
        $info = Customer::query()->find($id);
        if ($info){
            $info->is_turn = 1;
            $info->update();

            //复制信息到学员表
            $data = [];
            $data['identifier'] = StudentController::getIdent();
            $data['name'] = $info->child_name;
            $data['parent_name'] = $info->parent_name;
            $data['age'] = $info->child_age;
            $data['sex'] = $info->child_sex;
            $data['mobile'] = $info->mobile;
            $data['phone'] = $info->phone;
            $data['birthday'] = $info->child_birthday;
            $data['child_area'] = $info->child_area;
            $data['child_school'] = $info->child_school;
            $data['status'] = '等班';
            $data['note'] = $info->describe_source;
            $data['customer_id'] = $info->id;
            Student::create($data);
            $data = [
                'code' => 0,
                'msg' => '修改成功'
            ];
            $adminUser = $request->user()->toArray();
            $this->addSysLog([
                'user_id' => $adminUser['id'],
                'username' => $adminUser['name'],
                'module' => SysLog::manage_student,
                'page' => '学员管理',
                'type' => SysLog::add,
                'content' => '学员管理添加学员：'.$id,
            ]);
        }else{
            $data = [
                'code' => 1,
                'msg' => '未找到对应信息'
            ];
        }
        return response()->json($data);
    }

    //导入
    public function importExcel()
    {
        return view('admin.customer.importExcel');
    }

    public function exportExcel(){
        $pathToFile = public_path('excel/信息导入模板.xlsx');
        return response()->download($pathToFile, '导入模版' . date('ymdHis') . '.xlsx');
    }

    public function import(){
        Excel::load($_FILES['file']['tmp_name'], function($reader) {
            $data = $reader->getSheet(0)->toArray();
            $msg = [];
            $i=0;
            $str='';
            $status_hidden = config('customer.status_hidden');
            $status_array = array_flip($status_hidden);
            $user = DB::table('sys_users')->get()->toArray();
            $ids = array_column($user,'id');
            $name = array_column($user,'name');
            $users = array_combine($name,$ids);
            foreach ($data as $k=>$v) {
                if ($k==0) continue;
                $child_name = trim($v[0]);//孩子姓名
                $parent_name = trim($v[1]);//家长姓名
                $child_sex = trim($v[2]);//性别
                $child_age = trim($v[3]);//年龄
                $child_birthday = trim($v[4]);//生日
                $mobile = trim($v[5]);//电话
                $phone = trim($v[6]);//手机
                $part_number = trim($v[7]);//兼职编号
                $channel = trim($v[8]);//信息渠道
                $channel_detail = trim($v[9]);//渠道详情
                $child_area = trim($v[10]);//孩子小区
                $child_school = trim($v[11]);//孩子学校
                $hidden_status = trim($v[12]);//潜在信息状态
                $status_describe = trim($v[13]);//状态说明
                $collect_at = trim($v[14]);//收集日期
                $explain = trim($v[15]);//详情说明
                $customer_type = trim($v[16]);//客户类型
                $visit_at = trim($v[17]);//回访日期
                $describe_source = trim($v[18]);//描述
                $responer = trim($v[19]);//负责人
                $collect_address = trim($v[20]);//收集地址
                $describe_sales = trim($v[21]);//销售描述
                if($child_name && $phone  && $child_age && $child_birthday &&$channel && $hidden_status && $visit_at){
                    if (strlen(intval($phone))!=11){
                        $msg[] =  '第'.($k+1).'行 手机号格式不正确';
                    }
                    if (intval($child_age)==0){
                        $msg[] =  '第'.($k+1).'行 年龄不正确';
                    }
                    if (date('Y/n/j', strtotime($child_birthday))  != $child_birthday){
                        $msg[] =  '第'.($k+1).'行 生日日期格式不正确';
                    }
                    if (date('Y/n/j', strtotime($visit_at))  != $visit_at){
                        $msg[] =  '第'.($k+1).'行 回访日期格式不正确';
                    }
                    if (!array_key_exists($hidden_status,$status_array)){
                        $msg[] =  '第'.($k+1).'行 状态文字描述不对';
                    }
                    if (!array_key_exists($responer,$users)){
                        $msg[] =  '第'.($k+1).'行 未找到对应负责人';
                    }
                }else{
                    $msg[] = '第'.($k+1).'行 必填项没有填写完整';
                }
                if ($child_sex){
                    if ($child_sex!='男'&&$child_sex!='女'){
                        $msg[] = '第'.($k+1).'行 性别请填写"男"或者"女"';
                    }
                }
            }
            if ($msg){
                $str = implode(' </br>',$msg);
                echo $str;die;
            }
            $created_by = Auth::id();
            $insert = [];
            foreach ($data as $k=>$v) {
                if ($k==0) continue;
                $tmp = array();
                $tmp['identifier'] = $this->getIdent();
                $tmp['created_by'] = $created_by;
                $tmp['child_name'] = trim($v[0]);//孩子姓名
                $tmp['parent_name'] = trim($v[1]);//家长姓名
                $tmp['child_sex'] = trim($v[2])=='男'?1:2;//性别
                $tmp['child_age'] = trim($v[3]);//年龄
                $tmp['child_birthday'] = trim($v[4]);//生日
                $tmp['mobile'] = trim($v[5]);//电话
                $tmp['phone'] = trim($v[6]);//手机
                $tmp['part_number'] = trim($v[7]);//兼职编号
                $tmp['channel'] = trim($v[8]);//信息渠道
                $tmp['channel_detail'] = trim($v[9]);//渠道详情
                $tmp['child_area'] = trim($v[10]);//孩子小区
                $tmp['child_school'] = trim($v[11]);//孩子学校
                $tmp['status_hidden'] = $status_array[trim($v[12])];
                $tmp['status_describe'] = trim($v[13]);//状态说明
                $tmp['collect_at'] = trim($v[14])?trim($v[14]):null;//收集日期
                $tmp['explain'] = trim($v[15]);//详情说明
                $tmp['customer_type'] = trim($v[16]);//客户类型
                $tmp['visit_at'] = trim($v[17]);//回访日期
                $tmp['describe_source'] = trim($v[18]);//描述
                $tmp['responer'] = $users[trim($v[19])];//负责人
                $tmp['collect_area'] = trim($v[20]);//收集地址
                $tmp['describe_sales'] = trim($v[21]);//销售描述
                $insert[] = $tmp;
            }
            $res = DB::table('customer')->insert($insert);
            if ($res){
                echo '导入成功';
            }
        });
    }

   
}