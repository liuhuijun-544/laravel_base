<?php
namespace App\Http\Controllers\Admin;

use App\Http\Requests\CustomerRequest;
use App\Models\Customer;
use App\Models\Member;
use App\Models\SysLogDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use DB;
use Excel;
use App\Models\SysLog;  
use Illuminate\Contracts\Session\Session; 
  
class CustomerController extends Controller
{
    public $accountLogType = [0=>'自动',1=>'手动'];
    public $accountType = ['buy'=>'充值','present'=>'赠送'];

    public function  index(){  
        //获取全部的支付权限
        $pays = DB::table('paytype')->select('id','title')->where('status', '1')->orderBy('updated_at','desc')->get()->toArray();
      
        //获取附加优惠表信息
         $discounts = DB::table('discount_additional')->select('id','title')->orderBy('updated_at','desc')->where('status', '1')->get()->toArray();

         //获取所有的会员等级
        $leavels = DB::table('member_level')->select('id','title')->where('status', '1')->orderBy('created_at','desc')->get()->toArray();
        
        return view('admin.customer.index',['pays'=>$pays,'discounts'=>$discounts,'leavels'=>$leavels]);
    }
    public function data(Request $request)
    {   
    

        $param = [  
            'memberName'=>$request->get('memberName'),
            'memberPhone'=>$request->get('memberPhone'), 
            // 'wxName'=>$request->get('wxName'),
            'coupon'=>$request->get('coupon'),
            'pay_role'=>$request->get('pay_role'),
            'customId'=>$request->get('customId'),
            'level'=>$request->get('level'),
            'isMatch'=>$request->get('isMatch'),
            'pipei_time_start'=>$request->get('pipei_time_start'),
            'pipei_time_end'=>$request->get('pipei_time_end'),
            'matchedCard'=>$request->get('matchedCard'),
            'matchedMember'=>$request->get('matchedMember'),
            'status'=>$request->get('status'),
        ];

        $model = $this->getSeachModel($param);

        $orderBy='updated_at';
        $orderSort='desc'; 
        
        if($request->get('order_field') && $request->get('order_type')){
            $orderBy = $request->get('order_field');
            $orderSort = $request->get('order_type');
           
           switch ($request->get('order_field')) {
                case 'id':
                    $orderBy = 'id';
                   break;
                case 'phone':
                    $orderBy = 'c.phone';
                   break;
                case 'datitle':
                    $orderBy = 'c.additional';
                   break;
                case 'levelTitle':
                    $orderBy = 'c.level';
                   break;
                case 'matched_at':
                    $orderBy = 'c.matched_at';  
                   break;
           }

        } 
               // DB::connection()->enableQueryLog();

        $res = $model->select('c.*','da.title as datitle','ml.title  as levelTitle',DB::raw('group_concat(distinct(pc.paytype_id)) as payids'),'pc.paytype_id','m.username as musername','m.card as mcard')
        ->leftJoin('paytype_customer as pc', 'c.id', '=', 'pc.customer_id')
        ->leftJoin('discount_additional as da',function($join){
                $join->on('c.additional', '=', 'da.id')->where('da.status','=','1');
        })
        ->leftJoin('member_level as ml', 'c.level', '=', 'ml.id')
        ->leftJoin('member as m', 'm.id', '=', 'c.member_id')
        
        ->groupBy('c.id')->orderBy($orderBy,$orderSort)->paginate($request->get('limit',30))->toArray();
// print_r(DB::getQueryLog());die;
        // dd($param);


        foreach ($res['data'] as &$v) {
            if($v->payids){
                $parr=explode(',', $v->payids);

                $r=DB::table('paytype')->select(DB::raw('group_concat(title) as paytitle'))->where('status', '1')->whereIn('id', $parr)->get();
               
                $v->paytitle = $r[0]->paytitle;
            }else{
                $v->paytitle = '';
            }
            $v->levelTitle = $v->level==0?'普通':$v->levelTitle;

            // $v->status = $v->status==0?'<span style="color: red">停用</span>':'启用'; 
           
            $v->isMatch = $v->member_id?$v->musername.','.$v->mcard:'未匹配';
            
  
        }

        $data = [
            'code' => 0,
            'msg'   => '正在请求中...',
            'count' => $res['total'],
            'data'  => $res['data']
        ];

        // dd($res);die;
        return response()->json($data);
    }

    public function getSeachModel($param)
    {
        if(!is_array($param)){
            return false;
        }

        $model = DB::table('customer as c');

        if ($param['memberName']){
            $model = $model->where('c.username','like','%'.$param['memberName'].'%');
        }

        if ($param['memberPhone']){
            $model = $model->where('c.phone','like','%'.$param['memberPhone'].'%');
        }

        // if ($param['wxName']){
        //     $model = $model->where('c.wx_name','like','%'.$param['wxName'].'%');
        // }
        if ($param['coupon']){

            $model = $model->where('c.additional',$param['coupon']);
        }
        $payIdArr = [];

        if (!is_null($param['pay_role']) && is_array($param['pay_role']) && count($param['pay_role']) && $param['pay_role'] != ''){
            if(is_array($param['pay_role'])){
                $payIdArr = $param['pay_role'];
            }else{
                $payIdArr = explode(',', $param['pay_role']);
            }
            sort($payIdArr);
            $paystr = implode(',', $payIdArr);
            $r = DB::select("SELECT group_concat( py.paytype_id ORDER BY py.paytype_id ) AS payids,py.customer_id FROM paytype_customer py GROUP BY py.customer_id ");
             
            $memberArr = [];
            foreach ($r as $v) {
                if($v->payids == $paystr || strpos($v->payids,$paystr) !==  false){
                    $memberArr[] = $v->customer_id;
                }
            }

            $model = $model->whereIn('c.id',$memberArr);

        }
        if ($param['customId']){
            $model = $model->where('c.id','=',$param['customId']);
        }
        if ($param['level'] != ''){
            $model = $model->where('c.level','=',$param['level']);
        }
        if ($param['isMatch'] == 1){
            $model = $model->where('c.member_id','>',0);
        }elseif($param['isMatch'] == 2){
            $model = $model->where('c.member_id','=',0);
        }
        if ($param['pipei_time_start'] || $param['pipei_time_end']){
            if($param['pipei_time_start'] && !$param['pipei_time_end']){

                $model = $model->where('c.matched_at','>=',$param['pipei_time_start']);

            }elseif(!$param['pipei_time_start'] && $param['pipei_time_end']){
                $model = $model->where('c.matched_at','<=',date('Y-m-d',strtotime($param['pipei_time_end'].'+1 day')) );   
            }else{

                $model = $model->whereBetween('c.matched_at',array($param['pipei_time_start'],date('Y-m-d',strtotime($param['pipei_time_end'].'+1 day')) ));
            }
        }
        if ($param['matchedCard']){
            $model = $model->where('m.card','like','%'.$param['matchedCard'].'%');
        }
        if ($param['matchedMember']){
            $model = $model->where('m.username','like','%'.$param['matchedMember'].'%');
        }
        if ($param['status'] != ''){
            $model = $model->where('c.status','=',$param['status']);
        }
        return $model;

    }


    public function export(Request $request)
    {
        $param = $request->get('param');

        $param = json_decode($param,true);

        $model = $this->getSeachModel($param);
// DB::connection()->enableQueryLog();
        $res = $model->select('c.*','da.title as datitle','ml.title  as levelTitle',DB::raw('group_concat(distinct(pc.paytype_id)) as payids'),'pc.paytype_id','m.username as musername','m.card as mcard')
            ->leftJoin('paytype_customer as pc', 'c.id', '=', 'pc.customer_id')
            ->leftJoin('discount_additional as da',function($join){
                $join->on('c.additional', '=', 'da.id')->where('da.status','=','1');
            })
            ->leftJoin('member_level as ml', 'c.level', '=', 'ml.id')
            ->leftJoin('member as m', 'm.id', '=', 'c.member_id')

            ->groupBy('c.id')->orderBy('updated_at','desc')->get()->toArray();
// print_r(DB::getQueryLog());die;
        ini_set('memory_limit','500M');
        set_time_limit(0);//设置超时限制为0分钟

        $cellData[0]=['ID','姓名','手机号','附加优惠','支付权限','等级','公司','地址','备注','是否匹配','匹配时间','是否启用'];
        foreach ($res as &$v)
        {
            if($v->payids){
                $parr=explode(',', $v->payids);

                $r=DB::table('paytype')->select(DB::raw('group_concat(title) as paytitle'))->where('status', '1')->whereIn('id', $parr)->get();

                $v->paytitle = $r[0]->paytitle;
            }else{
                $v->paytitle = '';
            }
            $v->isMatch = $v->member_id?$v->musername.','.$v->mcard:'未匹配';
            $v->status = $v->status==0?'停用':'启用';

            $cellData[] = [
                $v->id,
                $v->username,
                $v->phone,
                // $v->wx_name,
                $v->datitle,
                $v->paytitle,
                $v->level?'普通':$v->levelTitle,
                $v->company,
                $v->address,
                $v->comment,
                $v->isMatch,
                $v->matched_at,
                $v->status
            ];
        }

        // sys_log表
        $adminUser = $request->user()->toArray();
      
        $this->addSysLog([
            'user_id' => $adminUser['id'],
            'username' => $adminUser['name'],
            'module' => SysLog::member_manage,
            'page' => '潜在客户管理',
            'type' => SysLog::export,
            'content' => '潜在客户列表导出',
        ]);


        Excel::create('潜在客户列表',function($excel) use ($cellData){
            $excel->sheet('customer', function($sheet) use ($cellData){
                $sheet->rows($cellData);
            });
        })->export('xlsx');

    }

    // 新增
    public function add(CustomerRequest $request)
    {

         //获取全部的支付权限
        $pays = DB::table('paytype')->select('id','title')->where('status', '1')->orderBy('updated_at','desc')->get()->toArray();

        //获取附加优惠表信息
        $discounts = DB::table('discount_additional')->select('id','title')->orderBy('updated_at','desc')->where('status', '1')->get()->toArray();
        //获取所有的会员等级
        $leavels = DB::table('member_level')->select('id','title')->where('status', '1')->orderBy('created_at','desc')->get()->toArray();
        $customer = [
            'username'=>'',
            'phone'=>'',
            // 'wx_name'=>'',
            'level'=>0,
            'additional'=>0,
            'company'=>'',
            'address'=>'',
            'comment'=>'',
            'status'=>1,
            'payids'=>[],

        ];
        // dd($request->isMethod('post'));die;
        if($request->isMethod('post')){
            if(!$request->session()->get('form_token')) {Redirect::back()->withErrors(['重复提交,请重试'])->withInput();}
            $request->session()->forget('form_token');

            $this->validate($request, [
            'username'   => 'required|string|min:1|max:100',
            'phone'   => 'required|telphone|unique:customer',
            // 'wx_name' => 'required|string',
            'level'   => 'numeric',
            'company'   => 'required|string|min:1|max:100',
            'address'   => 'required|string|min:1|max:100',
            // 'comment'   => 'string',
            'status'   => 'required|numeric',
            ]); 
            $data = $request->only(['username','phone','level','additional','company','address','comment','status','additional']);
            $data['comment'] = is_null($request->get('comment'))?'':$request->get('comment');
            $payids = $request->get('pay_role');
            if($payids){
                $payids = explode(',', $payids[0]);
            }
            // dd($request->get('pay_role'));
            if(isset($data['status']) && $data['status'] == '1'){
                $data['status'] = 1;
            }else{
                $data['status'] = 0;
            }

            $customer = Customer::create($data);
            
            if ($customer && !empty($payids) && $payids[0] != ''){
            $customer->pays()->attach($payids,['created_at'=>date('Y-m-d H:i:s',time())]);
            }   

            // 添加会员表数据 
            $memberObj = Member::where('phone',$data['phone'])->get();
            if(count($memberObj) <= 0){

                $m = Member::create([
                    'phone'=>$data['phone'],
                    'username'=>$data['username'],
                    'additional'=>$data['additional'],
                    'level'=>$data['level'],

                ]);
                if ($m && !empty($payids) && $payids[0] != ''){
                    $m->pays()->attach($payids,['created_at'=>date('Y-m-d H:i:s',time())]);
                }  
            }


            // sys_log表
            $adminUser = $request->user()->toArray();
            
            $r=$this->addSysLog([
                'user_id' => $adminUser['id'],
                'username' => $adminUser['name'],
                'module' => SysLog::member_manage,
                'page' => '潜在客户管理',
                'type' => SysLog::add,
                'content' => '潜在客户添加',
            ]);

            if($r !== false){ 
                return redirect(route('admin.customer.customer'))->with(['status'=>'添加成功']);
            }else{
                return Redirect::back()->withErrors(['添加失败,请重试'])->withInput();

            }

        }
        $form_token = md5(time().\Auth::user());
        $request->session()->put('form_token', $form_token);
        return view('admin.customer.add',
            compact('pays','discounts','leavels','customer','form_token'));
    }


    public function edit(Request $request,$id){
        //获取全部的支付权限
        $pays = DB::table('paytype')->select('id','title')->where('status', '1')->orderBy('updated_at','desc')->get()->toArray();

        //获取附加优惠表信息
        $discounts = DB::table('discount_additional')->select('id','title')->orderBy('updated_at','desc')->where('status', '1')->get()->toArray();
        //获取所有的会员等级
        $leavels = DB::table('member_level')->select('id','title')->where('status', '1')->orderBy('created_at','desc')->get()->toArray();

        $customer = Customer::with('childs')->findOrFail($id)->toArray();

        if(!empty($customer['childs'])){
            foreach ($customer['childs'] as $c) {
                $payids[] = $c['paytype_id'];
            }
            $customer['payids'] = $payids;
        }else{
            $customer['payids'] = [];

        }
        $form_token = md5(time().\Auth::user());
        $request->session()->put('form_token', $form_token);

        return view('admin.customer.edit',
            compact('customer','discounts','leavels','pays','form_token'));
    }

    public function update(CustomerRequest $request)
    {
   
        if($request->get('id')){
            if(!$request->session()->get('form_token')) {Redirect::back()->withErrors(['重复提交,请重试'])->withInput();}
            $request->session()->forget('form_token');

            $this->validate($request, [
            'username'   => 'required|string',
            'phone'   => 'required|telphone|unique:customer,phone,'.$request->get('id'),
            // 'wx_name' => 'required|string',
            'level'   => 'numeric',
            'company'   => 'required|string',
            'address'   => 'required|string',
            // 'comment'   => 'string',
            'status'   => 'required|numeric',
            ]); 
            $data = $request->only(['username','phone','level','additional','company','address','comment','status','additional','updated_at']);
            $data['comment'] = is_null($request->get('comment'))?'':$request->get('comment');
            $payids = $request->get('pay_role');
            if($payids){
                $payids = explode(',', $payids[0]);
            }
            if(isset($data['status']) && $data['status'] == '1'){
                $data['status'] = 1;
            }else{
                $data['status'] = 0;
            }


            $customer = Customer::findOrFail($request->get('id'));

            if ($customer->update($data)){
                
                $customer->pays()->detach();
// dd($payids);
                if (!empty($payids) && $payids[0] !=''){

                    $customer->pays()->attach($payids,['created_at'=>date('Y-m-d H:i:s',time())]);
                }

                // 添加会员表数据 
                $memberObj = Member::where('phone',$data['phone'])->get();
                if(count($memberObj) <= 0){

                    $m = Member::create([
                        'phone'=>$data['phone'],
                        'username'=>$data['username'],
                        'additional'=>$data['additional'],
                        'level'=>$data['level'],

                    ]);
                    if ($m && !empty($payids) && $payids[0] != ''){
                        $m->pays()->attach($payids,['created_at'=>date('Y-m-d H:i:s',time())]);
                    }  
                }

                // sys_log表
                $adminUser = $request->user()->toArray();
              
                $r = $this->addSysLog([
                    'user_id' => $adminUser['id'],
                    'username' => $adminUser['name'],
                    'module' => SysLog::member_manage,
                    'page' => '潜在客户管理',
                    'type' => SysLog::update,
                    'content' => '潜在客户编辑',
                ]);

                if($r !== false){ 
                    return redirect(route('admin.customer.customer'))->with(['status'=>'更新成功']);
                }else{
                    return Redirect::back()->withErrors(['更新失败,请重试'])->withInput();

                }
            }

        }
    } 


     /** 
     * 查看潜在客户
     */
    public  function show($id)
    {
        $customer = Customer::with(['childs'=>function($query){
            $query->with(['customerPays'=>function($query){
                $query->select('id','title');
            }]);
        },'disaddtion'=>function($query){
            $query->select('id','title');
        },'cuslevel'=>function($query){
            $query->select('id','title'); 
        }])->findOrFail($id)->toArray();


// dd($customer);
        return view('admin.customer.show',['customer'=>$customer]);

    }


    /**
     *
     * Excel导入
     */
    public function import(){

        Excel::load($_FILES['file']['tmp_name'], function($reader) {
            $data = $reader->getSheet(0)->toArray();
            $msg = [];
            $i=0;
            $str='';
            foreach ($data as $k=>$v) {
                $name = trim($v[1]);
                $phone = trim($v[2]);
                $level = trim($v[3]);
                $additional = trim($v[4]);
                $payrole = trim($v[5]);
                $company = trim($v[6]);
                $address = trim($v[7]);
                $comment = trim($v[8]);
            
                if($k){
                    if( $name && $phone  && $company && $address ){

                        if($level == '普通' || $level == '' ){
                            $level_id = 0;
                        }else{

                            // 会员等级
                            $levels = DB::table('member_level')->select('id','title')->where('title', $level)->where('status', '1')->get()->toArray();

                            if(empty($levels)){
                                $msg[] = '第'.($k+1).'行会员等级填写有误导入失败';
                                continue;
                            }
                            $level_id = $levels[0]->id;
                        }

                        $additional_id = 0;
                        if($additional)
                        {

                            // 附加优惠
                            $discount = DB::table('discount_additional')->where('title','=',$additional)->where('status','=','1')->get()->toArray();

                            if(empty($discount)){
                                $msg[] = '第'.($k+1).'行附加优惠填写有误导入失败';
                                continue;
                            }
                            $additional_id = $discount[0]->id;
                        }

                        $payids = [];
                        if($payrole)
                        {

                            $payrole = str_replace('，', ',', $payrole);//中文下的，号换成英文的
                            $payroles = explode(',', $payrole);


                            foreach ($payroles as $t) {
                                $payArr = DB::table('paytype')->where('title',$t)->where('status','=','1')->get()->toArray();
                                if(empty($payArr)){
                                    $msg[] = '第'.($k+1).'行支付权限('.$t.')填写有误导入失败';
                                    continue 2 ;
                                }else{
                                    
                                    $payids[] = $payArr[0]->id;
                                }
                            
                            }

                        }
                        $cellData = [
                            'username'=>$name,  
                            'phone'=>$phone,
                            'level'=>$level_id,
                            'additional'=>$additional_id,
                            'company'=>$company,
                            'address'=>$address,
                            'comment'=>$comment,
                            'status'=>1,
                        ];

                        $customer = new Customer();
                        $str = $customer->createData($cellData);
                        if($str != 'ok'){
                            $msg[] = '第'.($k+1).'行'.$str;
                        }else{
                            $i++;
                            $customer = $customer->create($cellData);
                            if(!empty($payids)){
                                $customer->pays()->attach($payids,['created_at'=>date('Y-m-d H:i:s',time())]);
                            }

                            // 添加会员表数据 
                            $memberObj = Member::where('phone',$cellData['phone'])->get();
                            if(count($memberObj) <= 0){

                                $m = Member::create([
                                    'phone'=>$cellData['phone'],
                                    'username'=>$cellData['username'],
                                    'additional'=>$cellData['additional'],
                                    'level'=>$cellData['level'],

                                ]);
                                if ($m && !empty($payids) ){
                                    $m->pays()->attach($payids,['created_at'=>date('Y-m-d H:i:s',time())]);
                                }  
                            }

                        }

                    }else{
                        $msg[] = '第'.($k+1).'行 数据填写不正确';
                    }
                }
                
            }
            // sys_log表
            
            $this->addLog(7,1,'潜在客户管理','潜在客户导入');

            if(!empty($msg)){

                $str = '上传成功，本次成功导入'.$i.'条记录<br/>';
                $str .= implode('</br>', $msg);
            }else{
                $str = '上传成功，本次成功导入'.$i.'条记录';
            }
           
            echo $str;

        });
    }

    public function importExcel(CustomerRequest $request)
    {
        $adminUser = $request->user()->toArray();
        return view('admin.customer.importExcel',['adminUser'=>$adminUser]);

    }
   

    public function exportExcel(){
        $pathToFile = public_path('excel/潜在客户导入模板.xlsx');
        return response()->download($pathToFile, '导入模版' . date('ymdHis') . '.xlsx');
  
        // $filename=dirname(app_path()).'/public/excel/潜在客户导入模板.xlsx';
        // $filename=iconv("UTF-8","gb2312", $filename);

        // header('Content-Description: File Transfer');

        // header('Content-Type: application/octet-stream');
        // header('Content-Disposition: attachment; filename='.basename($filename));
        // header('Content-Transfer-Encoding: binary');
        // header('Expires: 0');
        // header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        // header('Pragma: public');
        // header('Content-Length: ' . filesize($filename));
        // readfile($filename);
    }  

        //修改状态
    public function revise(Request $request){
        $ids = $request->post('ids');
        $val = $request->post('val');
        $type = Customer::findOrFail($ids);
        $data['status'] = $val==1?0:1;
        if ($type->update($data)) {
            $this->addLog(7,5,'潜在客户管理','修改潜在客户状态：'.$ids);
            return response()->json(['code'=>0,'status'=>$data['status']]);  
        }else{
            return response()->json(['code'=>1,'status'=>$val]);  

        }
        
    }
  
   
   
}