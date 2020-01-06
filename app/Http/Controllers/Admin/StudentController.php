<?php
namespace App\Http\Controllers\Admin;
  
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Student;
use App\Models\SysLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class StudentController extends Controller
{
    //列表
    public function index(){

        return view('admin.student.index');
    }

    public function getData(Request $request)
    {
        $list=Student::with(['course','course.teacher_1']);
        $keywords = $request->get('keywords');
        if(isset($keywords)){
            $list->where(function($query)use($keywords){
                $query->where('name','like',"%{$keywords}%")->orWhere('mobile','like',"%{$keywords}%")->orWhere('phone','like',"%{$keywords}%");
            });
        }
        $list  = $list->paginate($request->get('limit',10))->toArray();

        foreach ($list['data'] as &$item) {
            $item['course_identifier'] = '';
            if ($item['course']){
                $item['course_identifier'] = $item['course']['identifier'];
                $item['teacher_name'] = $item['course']['teacher_1']['name'];
            }
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

    //编辑
    public function edit($id){
        $info = Student::with(['course.teacher_1','course.teacher_2'])->find($id);
        if ($info->course->teacher_1->name){
            $lecturer = $info->course->teacher_1->name;
        }
        if ($info->course->teacher_2->name){
            $teacher = $info->course->teacher_2->name;
        }
        $status = config('customer.student_status');
        $model =  Course::query()->get()->toArray();
        $coure_id = array_column($model,'id');
        $coure_identifier = array_column($model,'identifier');
        $course = array_combine($coure_id,$coure_identifier);
        return view('admin.student.edit',compact('info','status','course','lecturer','teacher'));
    }

    public function update(Request $request,$id)
    {
        $info = Student::findOrFail($id);

        $data = $request->only(['name','parent_name','age','mobile','contact_one','contact_one_phone','child_area','student_diy','student_independence','status','sex','birthday','phone','contact_two','contact_two_phone','child_school','student_expression','note','course_id','enter_class_date']);

        $course_id = $info->course_id;
        if ($info->update($data)){
            $new_course_id = $info->course_id;
            if ($course_id != $new_course_id){//课程id变更课程以后课程剩余数量需要修改
                if ($course_id){
                    $course1 = Course::query()->find($course_id);
                    $count1 = Student::query()->where('course_id',$course_id)->count();
                    $left_number1 = $course1->degree_number - $count1;
                    $left_number1 = $left_number1<0?0:$left_number1;
                    $course1->left_number = $left_number1;
                    $course1->update();
                }
                if ($new_course_id){
                    $course2 = Course::query()->find($new_course_id);
                    $count2 = Student::query()->where('course_id',$new_course_id)->count();
                    $left_number2 = $course2->degree_number - $count2;
                    $left_number2 = $left_number2<0?0:$left_number2;
                    $course2->left_number = $left_number2;
                    $course2->update();
                }
            }
            $adminUser = $request->user()->toArray();
            $this->addSysLog([
                'user_id' => $adminUser['id'],
                'username' => $adminUser['name'],
                'module' => SysLog::manage_student,
                'page' => '学员管理',
                'type' => SysLog::edit,
                'content' => '学员管理编辑：'.$id,
            ]);
            return redirect(route('admin.student'))->with(['status'=>'更新成功']);
        }
        return Redirect::back()->withErrors(['更新失败,请重试'])->withInput();

    }

    public function del(Request $request,$id)
    {
        $info = Student::query()->find($id);
        $course_id = $info->course_id;
        $res = $info->delete();
        if ($res){
            if ($course_id){
                $course = Course::query()->find($course_id);
                $count = Student::query()->where('course_id',$course_id)->count();
                $left_number = $course->degree_number - $count;
                $left_number = $left_number<0?0:$left_number;
                $course->left_number = $left_number;
                $course->update();
            }
            $adminUser = $request->user()->toArray();
            $this->addSysLog([
                'user_id' => $adminUser['id'],
                'username' => $adminUser['name'],
                'module' => SysLog::manage_student,
                'page' => '学员管理',
                'type' => SysLog::delete,
                'content' => '学员管理删除：'.$id,
            ]);
            return redirect(route('admin.student'))->with(['status'=>'删除成功']);
        }
    }

    public function getTeacher(Request $request){
        $course_id = $request->get('course_id');
        $course = Course::with(['teacher_1','teacher_2'])->find($course_id);
        if ($course){
            $lecturer = $course->teacher_1->name;
            $teacher = $course->teacher_2->name;
            return [
                'code' => 0,
                'msg' => 'ok',
                'lecturer'=>$lecturer,
                'teacher'=>$teacher
            ];
        }
        return [
            'code' => -1,
            'msg' => '未找到课程信息',
            'lecturer'=>'',
            'teacher'=>''
        ];
    }

    //查看
    public function show($id)
    {
        $info = Student::with(['course','course.teacher_1','course.teacher_2'])->find($id);
        return view('admin.student.show',compact('info'));

    }

    public static function getIdent()
    {
        $Str = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $rangtr1 = $Str[rand(0,25)];
        $rangtr2 = $Str[rand(0,25)];
        $rangtime = date("Ymd",time());
        $rangnum = rand(00,99);
        $identifier = 'ST-'.$rangtime.$rangtr1.$rangtr2.$rangnum;
        return $identifier;
    }
}