<?php
namespace App\Http\Controllers\Admin;
  
use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\ClassroomCourse;
use App\Models\ClassroomCourseDetail;
use App\Models\Course;
use App\Models\CourseAttribute;
use App\Models\SysLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;

class ClassroomController extends Controller
{
    //列表
    public function index(){
        $classroom = Classroom::query()->get()->toArray();
        if (!$classroom)
            $classroom = [];
        $year = date('Y');
        $month = date('n');
        return view('admin.classroom.index',compact('classroom','year','month'));
    }
    public function getData(Request $request)
    {
        $id = $request->get('id');
        $year = $request->get('year');
        $month = $request->get('month');
        $model = ClassroomCourse::with(['course','teacher_info','detail']);
        if (!$year){
            $year = date('Y');
        }
        if (!$month){
            $month = date('n');
        }
        $info = $model->where('classroom_id',$id)
            ->where('year',$year)
            ->where('month',$month)
            ->paginate($request->get('limit',10))->toArray();
        $week=['星期日','星期一','星期二','星期三','星期四','星期五','星期六'];
        foreach ($info['data'] as &$item) {
            if ($item['teacher_info'])
                $item['teacher_name'] = $item['teacher_info']['name'];
            $detail = $item['detail'];
            if ($detail){
                $item['week'] = $week[date('w',strtotime($detail[0]['starttime']))];
                $item['time'] = date('H:i',strtotime($detail[0]['starttime'])).' - '.date('H:i',strtotime($detail[0]['endtime']));
            }
            if ($item['course']){
                $item['course_name'] = $item['course']['identifier'];
                $item['course_amount'] = $item['course']['degree_number'] - $item['course']['left_number'];
                $item['course_count'] = $item['course']['degree_number'];
            }
        }
        $data=array(
            'code'=>0,
            'msg'=>'',
            'data'=>$info['data'],
            'count'=>$info['total']
        );
        return response()->json($data);
    }

    // 新增
    public function add()
    {
        return view('admin.classroom.add');
    }

    public function save(Request $request)
    {
        $name = $request->get('name');
        $classroom  = Classroom::query()->where('name',$name)->first();
        if ($classroom){
            return Redirect::back()->withErrors(['教室名称已存在，请修改'])->withInput();
        }
        $res = Classroom::create(['name'=>$name]);
        if ($res){
            $adminUser = $request->user()->toArray();
            $this->addSysLog([
                'user_id' => $adminUser['id'],
                'username' => $adminUser['name'],
                'module' => SysLog::manage_classroom,
                'page' => '教室管理',
                'type' => SysLog::add,
                'content' => '教室管理新增：'.$res->id,
            ]);
            return redirect()->to(route('admin.classroom'))->with(['status'=>'添加成功']);
        }else{
            return Redirect::back()->withErrors(['新增失败,请重试'])->withInput();
        }
    }

    //编辑
    public function edit($id){
        $info = Classroom::query()->find($id);
        return view('admin.classroom.edit',compact('info'));
    }

    public function update(Request $request,$id)
    {
        $name = $request->get('name');
        $classroom  = Classroom::query()->where('name',$name)->where('id','!=',$id)->first();
        if ($classroom){
            return Redirect::back()->withErrors(['教室名称已存在，请修改'])->withInput();
        }
        $info = Classroom::query()->find($id);
        $info->name = $name;
        $res = $info->update();
        if ($res){
            $adminUser = $request->user()->toArray();
            $this->addSysLog([
                'user_id' => $adminUser['id'],
                'username' => $adminUser['name'],
                'module' => SysLog::manage_classroom,
                'page' => '教室管理',
                'type' => SysLog::add,
                'content' => '教室管理编辑：'.$id,
            ]);
            return redirect()->to(route('admin.classroom'))->with(['status'=>'更新成功']);
        }else{
            return Redirect::back()->withErrors(['更新失败,请重试'])->withInput();
        }

    }

    //删除
    public function del(Request $request,$id){
        $info = Classroom::query()->find($id)->delete();
        if ($info){
            $adminUser = $request->user()->toArray();
            $this->addSysLog([
                'user_id' => $adminUser['id'],
                'username' => $adminUser['name'],
                'module' => SysLog::manage_classroom,
                'page' => '教室管理',
                'type' => SysLog::delete,
                'content' => '删除教室：'.$id,
            ]);
            return redirect()->to(route('admin.classroom'))->with(['status'=>'删除成功']);
        }
    }

    //排课
    public function addPlan()
    {
        //教室
        $classroom = Classroom::query()->get()->toArray();
        //班级
        $course = Course::query()->get()->toArray();
        //老师
        $courseController = new CourseController();
        $user = $courseController->getUser('teacher');

        $year = date('Y');
        $month = date('n');
        $count_detail = 1;
        return view('admin.classroom.addPlan',compact('classroom','course','user','year','month','count_detail'));
    }

    public function detail_add(Request $request)
    {
        $count_detail = $request->get('count_detail');
        $course_attribute = CourseAttribute::query()->get()->toArray();
        return view('admin.classroom._detail_add',compact('count_detail','course_attribute'));
    }

    public function savePlan(Request $request)
    {
        $data = $request->all();
        $course = [];
        $course['year'] = $data['year'];
        $course['month'] = $data['month'];
        $course['classroom_id'] = $data['classroom_id'];
        $course['course_id'] = $data['course_id'];
        $course['teacher'] = $data['teacher'];
        $detail = $data['detail'];
        $res = ClassroomCourse::create($course);
        if ($res){
            $adminUser = $request->user()->toArray();
            $this->addSysLog([
                'user_id' => $adminUser['id'],
                'username' => $adminUser['name'],
                'module' => SysLog::manage_classroom_course,
                'page' => '课程安排',
                'type' => SysLog::add,
                'content' => '课程安排新增：'.$res->id,
            ]);
            if ($detail){
                foreach ($detail as &$item) {
                    $item['classroom_course_id'] = $res->id;
                    $item['course_code'] = $this->getIdentifier();
                }
                $res1 = DB::table('classroom_course_detail')->insert($detail);
                if ($res1){
                    return redirect()->to(route('admin.classroom.show',['id'=>$res->id]))->with(['status'=>'添加成功']);
                }else{
                    return redirect()->to(route('admin.classroom.editPlan',['id'=>$res->id]))->withErrors(['status'=>'时间添加出错，请编辑']);
                }
            }
            return redirect()->to(route('admin.classroom.show',['id'=>$res->id]))->with(['status'=>'添加成功']);
        }else{
            return Redirect::back()->withErrors(['添加失败,请重试'])->withInput();
        }
    }

    private function getIdentifier(){
        $Str = "ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
        $rangtr1 = $Str[rand(0,25)];
        $rangtr2 = $Str[rand(0,25)];
        $rangtr3 = $Str[rand(0,25)];
        $rangtr4 = $Str[rand(0,25)];
        $rangnum = rand(00,99);
        $identifier = 'CI-'.$rangnum.$rangtr1.$rangtr2.$rangtr3.$rangtr4;
        return $identifier;
    }

    public function editPlan($id)
    {
        $info = ClassroomCourse::with('detail')->find($id);
        //教室
        $classroom = Classroom::query()->get()->toArray();
        //班级
        $course = Course::query()->get()->toArray();
        //老师
        $courseController = new CourseController();

        $user = $courseController->getUser('teacher');

        $year = date('Y');
        $month = date('n');
        $count_detail = 1;
        if ($info['detail']){
            $count_detail = count($info['detail']);
        }
        $course_attribute = CourseAttribute::query()->get()->toArray();
        return view('admin.classroom.editPlan',compact('classroom','course','user','year','month','count_detail','course_attribute','info'));
    }

    public function updatePlan(Request $request,$id)
    {
        $info = ClassroomCourse::query()->find($id);
        $data = $request->all();
        $course = [];
        $info->year = $data['year'];
        $info->month = $data['month'];
        $info->classroom_id = $data['classroom_id'];
        $info->course_id = $data['course_id'];
        $info->teacher = $data['teacher'];
        $detail = $data['detail'];
        if ($info->update()){
            $adminUser = $request->user()->toArray();
            $this->addSysLog([
                'user_id' => $adminUser['id'],
                'username' => $adminUser['name'],
                'module' => SysLog::manage_classroom_course,
                'page' => '课程安排',
                'type' => SysLog::edit,
                'content' => '课程安排编辑：'.$id,
            ]);
            $detail_info = ClassroomCourseDetail::query()->where('classroom_course_id',$id)->delete();
            if ($detail){
                foreach ($detail as &$item) {
                    $item['classroom_course_id'] = $id;
                    if (!$item['course_code']) $item['course_code'] = $this->getIdentifier();
                }
                $res = DB::table('classroom_course_detail')->insert($detail);
                if ($res){
                    return redirect()->to(route('admin.classroom.show',['id'=>$id]))->with(['status'=>'更新成功']);
                }else{
                    return redirect()->to(route('admin.classroom.editPlan',['id'=>$id]))->withErrors(['status'=>'时间修改出错，请重新编辑']);
                }
            }
            return redirect()->to(route('admin.classroom.show',['id'=>$id]))->with(['status'=>'更新成功']);
        }else{
            return Redirect::back()->withErrors(['更新失败,请重试'])->withInput();
        }
    }

    //查看排版
    public function show($id)
    {
        $info = ClassroomCourse::with(['classroom','detail','detail.course_attribute','course','teacher_info',])->find($id);
        return view('admin.classroom.show',compact('info'));
    }


}