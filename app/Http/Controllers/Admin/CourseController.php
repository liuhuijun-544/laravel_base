<?php
namespace App\Http\Controllers\Admin;
  
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseTime;
use App\Models\Customer;
use App\Models\Role;
use App\Models\Student;
use App\Models\SysLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;

class CourseController extends Controller
{
    //列表
    public function index(){

        $users = $this->getUser('teacher');
        //课程类型
        $class_type = config('customer.class_type');

        return view('admin.course.index',compact('users','class_type'));
    }

    //获取教师或者教务
    public function getUser($role_name)
    {
        $role = Role::query()->select('id')->where('name',$role_name)->limit(1)->get()->toArray();
        $role_id = $role[0]['id'];
        //教师
        $user_role = DB::select("select model_id from sys_model_has_roles where role_id = :role_id",[':role_id'=>$role_id]);
        $user_role = array_map('get_object_vars', $user_role);
        $user_ids = array_column($user_role,'model_id');//取到教师id
        $user = User::query()->whereIn('id',$user_ids)->get()->toArray();
        $ids = array_column($user,'id');
        $names = array_column($user,'name');
        $users = array_combine($ids,$names);
        return $users;
    }

    public function getData(Request $request)
    {

        $list=Course::query();
        $user = $request->get('user');
        $class_type = $request->get('class_type');
        if(isset($user)){
            $list->where('lecturer',$user);
        }
        if (isset($class_type)){
            $list->where('type',$class_type);
        }
        $list->with(['course_time','teacher_1','teacher_2']);
        $list  = $list->paginate($request->get('limit',10))->toArray();
        foreach ($list['data'] as &$item) {
            $course_time = $item['course_time'];
            $time_str = '';
            $count = count($course_time);
            for ($i=0;$i<$count;$i++){
                $time_str .= $course_time[$i]['week'].'('.$course_time[$i]['starttime'].'-'.$course_time[$i]['endtime'].')';
                if ($i!=$count-1){
                    $time_str .= '<br/>';
                }
            }
            $item['time_str'] = $time_str;
            $item['lecturer_name'] = $item['teacher_1']['name'];
            $item['teacher_name'] = $item['teacher_2']['name'];
            $item['is_choose'] = $item['is_choose']==1?'是':'否';
            $item['is_delete'] = $item['is_delete']==1?'是':'否';
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
        $teacher = $this->getUser('teacher');
        $administration = $this->getUser('administration');
        $class_type = config('customer.class_type');
        $week_count = 1;
        $ages = [];
        return view('admin.course.add',compact('teacher','administration','class_type','week_count','ages'));
    }

    public function week_add(Request $request){
        $week_count = $request->get('week_count');
        return view('admin.course._week_add',compact('week_count'));
    }

    public function save(Request $request)
    {
        $data = $request->all();
        $course = [];
        $course['identifier'] = $this->getIdent();
        $course['created_by'] = Auth::id();
        $course['lecturer'] = $data['lecturer'];
        $course['edu_teacher_id'] = $data['edu_teacher_id'];
        $course['schedule'] = $data['schedule'];
        $course['degree_number'] = $data['degree_number'];
        $course['left_number'] = $data['degree_number'];
        $course['type'] = $data['type'];
        $course['start_date'] = $data['start_date'];
        $course['course_describe'] = $data['course_describe'];
        $course['is_public'] = $data['is_public']??0;
        $course['is_plan'] = $data['is_plan']??0;
        $course['is_delete'] = $data['is_delete']??0;
        $course['is_choose'] = $data['is_choose']??0;
        $course['ages'] = $data['ages']?implode(',',$data['ages']):'';
        $course['lecturer'] = $data['lecturer'];

        $course_time = $data['course_time'];
        $res = Course::create($course);
        if ($res){
            foreach ($course_time as &$item) {
                $item['course_id'] = $res->id;
            }
            $res1 = DB::table('course_time')->insert($course_time);
            $adminUser = $request->user()->toArray();
            $this->addSysLog([
                'user_id' => $adminUser['id'],
                'username' => $adminUser['name'],
                'module' => SysLog::manage_course,
                'page' => '班级管理',
                'type' => SysLog::add,
                'content' => '班级管理新增：'.$res->id,
            ]);
            if ($res1){
                return redirect()->to(route('admin.course'))->with(['status'=>'添加成功']);
            }else{
                return redirect()->to(route('admin.course'))->withErrors(['status'=>'上课时间添加出错，请编辑']);
            }
        }else{
            return redirect()->to(route('admin.course'))->withErrors(['status'=>'系统错误']);
        }
    }

    private function getIdent()
    {
        $Str = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $rangtr1 = $Str[rand(0,25)];
        $rangtr2 = $Str[rand(0,25)];
        $rangtime = date("Ymd",time());
        $rangnum = rand(00,99);
        $identifier = '豫'.$rangnum.$rangtr1.$rangtime.$rangtr2;
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

        $teacher = $this->getUser('teacher');
        $administration = $this->getUser('administration');
        $class_type = config('customer.class_type');
        $info = Course::with('course_time')->find($id);
        if (!$info){
            return redirect()->to(route('admin.course'))->withErrors('未找到信息');
        }
        $week_count = count($info['course_time']);
        if ($week_count==0){
            $week_count=1;
        }
        $ages = explode(',',$info['ages']);

        return view('admin.course.edit',
            compact('teacher','administration','class_type','week_count','info','ages'));
    }

    public function update(Request $request,$id)
    {
        $info = Course::findOrFail($id);

        $data = $request->all();
        $course = [];
        $course['lecturer'] = $data['lecturer'];
        $course['edu_teacher_id'] = $data['edu_teacher_id'];
        $course['schedule'] = $data['schedule'];
        $course['degree_number'] = $data['degree_number'];
        $degree_number = $course->degree_number;
        $differ = $course['degree_number'] - $degree_number;
        $course['left_number'] += $differ;//剩余数
        $course['left_number'] = $course['left_number']>0?$course['left_number']:0;
        $course['type'] = $data['type'];
        $course['course_describe'] = $data['course_describe'];
        $course['is_public'] = $data['is_public']??0;
        $course['is_plan'] = $data['is_plan']??0;
        $course['is_delete'] = $data['is_delete']??0;
        $course['is_choose'] = $data['is_choose']??0;
        $course['ages'] = $data['ages']?implode(',',$data['ages']):'';
        $course['lecturer'] = $data['lecturer'];

        $course_time = $data['course_time'];

        if ($info->update($course)){
            CourseTime::query()->where('course_id',$id)->delete();
            foreach ($course_time as &$item) {
                $item['course_id'] = $id;
            }
            DB::table('course_time')->insert($course_time);

            $adminUser = $request->user()->toArray();
            $this->addSysLog([
                'user_id' => $adminUser['id'],
                'username' => $adminUser['name'],
                'module' => SysLog::manage_customer,
                'page' => '班级管理',
                'type' => SysLog::edit,
                'content' => '班级管理编辑：'.$id,
            ]);
            return redirect(route('admin.course'))->with(['status'=>'更新成功']);
        }
        return Redirect::back()->withErrors(['更新失败,请重试'])->withInput();

    } 

    //查看
    public function show(Request $request,$id)
    {
        $from = $request->get('from');
        $info = Course::with('course_time')->find($id);
        $teacher = $this->getUser('teacher');
        $administration = $this->getUser('administration');
        return view('admin.course.show',compact('info','teacher','administration','from'));

    }

    //查看--学生列表
    public function show_student(Request $request){
        $id = $request->get('id');
        $student = Student::with(['course','course.teacher_1','course.teacher_2'])->where('course_id','=',$id)->get()->toArray();
        foreach ($student as &$item) {
            $item['lecturer_name'] = $item['course']['teacher_1']['name'];
            $item['teacher_name'] = $item['course']['teacher_1']['name'];
        }

        // 获取状态分组
        $data=array(
            'code'=>0,
            'msg'=>'',
            'data'=>$student,
            'count'=>count($student)
        );
        return response()->json($data);
    }

    //查看-添加学生
    public function addStudent(Request $request)
    {
        $course_id = $request->get('course_id');
        return view('admin.course.addStudent',compact('course_id'));
    }

    //查看-添加保存学生
    public function saveStudent(Request $request)
    {
        $student_id = intval($request->get('id'));
        $course_id = intval($request->get('course_id'));
        $student = Student::query()->find($student_id);
        $course = Course::query()->find($course_id);
        if (!$student || !$course){
            return response()->json(['code'=>-1,'msg'=>'班级或者学员信息不存在，请刷新重试！']);
        }
        if ($student->course_id == $course_id){
            return response()->json(['code'=>0,'msg'=>'分班成功！']);
        }
        if ($course->left_number<=0){
            return response()->json(['code'=>-1,'msg'=>'班级已经满人']);
        }
        $student->course_id = $course_id;
        $student->enter_class_date = date('Y-m-d');
        $student->status = '在班';
        $res1 = $student->update();

        $count = Student::query()->where('course_id',$course_id)->count();
        $left_number = $course->degree_number - $count;
        if ($left_number<0){
            $left_number = 0;
        }
        $course->left_number = $left_number;
        $res2 = $course->update();
        if ($res1 && $res2){
            $adminUser = $request->user()->toArray();
            $this->addSysLog([
                'user_id' => $adminUser['id'],
                'username' => $adminUser['name'],
                'module' => SysLog::manage_course,
                'page' => '班级管理',
                'type' => SysLog::distribute,
                'content' => '班级管理添加学员,班级id:'.$course_id.'、学员id:'.$student_id,
            ]);
            return response()->json(['code'=>0,'msg'=>'分班成功']);
        }else{
            return response()->json(['code'=>-1,'msg'=>'系统错误']);
        }
    }

    //查看-删除学生
    public function delStudent(Request $request){
        $id = intval($request->get('id'));
        $course_id = intval($request->get('course_id'));
        $student = Student::query()->find($id);
        if (!$student){
            return response()->json(['code'=>-1,'msg'=>'学员信息不存在，请刷新重试！']);
        }
        $student->course_id = 0;
        $student->enter_class_date = null;
        if ($student->status == '在班'){
            $student->status = '等班';
        }
        $res = $student->update();
        $course = Course::query()->find($course_id);
        if($res){
            if ($course){
                $count = Student::query()->where('course_id',$course_id)->count();
                $left_number = $course->degree_number - $count;
                if ($left_number<0){
                    $left_number = 0;
                }
                $course->left_number = $left_number;
                $res2 = $course->update();
            }
            $adminUser = $request->user()->toArray();
            $this->addSysLog([
                'user_id' => $adminUser['id'],
                'username' => $adminUser['name'],
                'module' => SysLog::manage_course,
                'page' => '班级管理',
                'type' => SysLog::distribute,
                'content' => '班级管理删除学员,班级id:'.$course_id.'、学员id:'.$id,
            ]);
            return response()->json(['code'=>0,'msg'=>'删除成功']);
        }else{
            return response()->json(['code'=>-1,'msg'=>'系统错误']);
        }
    }

}