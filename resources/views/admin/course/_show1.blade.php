<style type="text/css">
    .layui-input-block textarea{
        padding: 10px;
    }
    .week_line{
        min-width: 300px;
        float: left;
    }
    .week{
        width: 90px;
        float:left;
    }
    .starttime{
        width: 80px;
        margin-left: 10px;
        float:left;
    }
    .start_end{
        float:left;
        margin-left: 10px;
        line-height: 38px;
    }
    .week_add{
        float: right;
        margin-right: 0px;
        line-height: 38px;
    }
    .layui-form-checkbox[lay-skin=primary] {
        margin-top: 10px;
    }
    .week_del{
        float: left;
    }
    .layui-input-block input{
        background-color: #eeeeee;
    }
    .layui-input-block textarea{
        background-color: #eeeeee;
        padding: 5px;
    }
</style>
<div class="layui-row layui-col-space15" style="padding-top: 10px;">
    <div class="layui-col-md6">
        <div class="layui-card">
            <label for="" class="layui-form-label">班级编号</label>
            <div class="layui-input-block">
                <input type="text" name="child_name" value="{{$info->identifier}}"  disabled class="layui-input">
            </div>
        </div>
        <div class="layui-card">
            <label for="" class="layui-form-label">主讲老师</label>
            <div class="layui-input-block">
                <input type="text" name="lecturer" value="{{$teacher[$info->lecturer]}}"  disabled class="layui-input">
            </div>
        </div>
        <div class="layui-card">
            <label for="" class="layui-form-label">教务老师</label>
            <div class="layui-input-block">
                <input type="text" name="lecturer" value="{{$administration[$info->edu_teacher_id]}}"  disabled class="layui-input">
            </div>
        </div>
        <div class="layui-card">
            <label for="" class="layui-form-label">班级进度</label>
            <div class="layui-input-block">
                <input type="text" name="schedule" value="{{$info->schedule}}"  disabled class="layui-input">
            </div>
        </div>
        <div class="layui-card">
            <label for="" class="layui-form-label">满班容量</label>
            <div class="layui-input-block">
                <input type="text" name="degree_number" value="{{$info->degree_number}}" disabled class="layui-input">
            </div>
        </div>
        <div class="layui-card">
            <label for="" class="layui-form-label">剩余学位</label>
            <div class="layui-input-block">
                <input type="text" name="left_number" value="{{$info->left_number}}" disabled class="layui-input" >
            </div>
        </div>
        <div class="layui-card">
            <label for="" class="layui-form-label">公共</label>
            <div class="layui-input-block">
                <input type="text" name="is_public" value="{{$info->is_public==1?'是':'否'}}" disabled class="layui-input" >
            </div>
        </div>
        <div class="layui-card">
            <label for="" class="layui-form-label">安排课程</label>
            <div class="layui-input-block">
                <input type="text" name="is_plan" value="{{$info->is_plan==1?'是':'否'}}" disabled class="layui-input" >
            </div>
        </div>
        <div class="layui-card">
            <label for="" class="layui-form-label">作废</label>
            <div class="layui-input-block">
                <input type="text" name="is_delete" value="{{$info->is_delete==1?'是':'否'}}" disabled class="layui-input" >
            </div>
        </div>
        <div class="layui-card">
            <label for="" class="layui-form-label">可选</label>
            <div class="layui-input-block">
                <input type="text" name="is_choose" value="{{$info->is_choose==1?'是':'否'}}" disabled class="layui-input" >
            </div>
        </div>
    </div>
    <div class="layui-col-md6">
        <div class="layui-card">
            <label for="" class="layui-form-label">课程类别</label>
            <div class="layui-input-block">
                <input type="text" name="type" value="{{$info->type}}" disabled class="layui-input" >
            </div>
        </div>
        <div class="layui-card">
            <label class="layui-form-label">开班日期</label>
            <div class="layui-input-block">
                <input type="text" name="start_date" value="{{$info->start_date}}" lay-verify="required"   disabled class="layui-input" >
            </div>
        </div>
        @for($i=0;$i<count($info['course_time']);$i++)
            <div class="layui-card week_time">
                <label for="" class="layui-form-label">上课时间</label>
                <div class="layui-input-block">
                    <div class="week_line">
                        <div class="week">
                            <input type="text" name="course_time[{{$i}}][week]" value="{{$info['course_time'][$i]->week}}" lay-verify="required"   disabled class="layui-input" >
                        </div>
                        <div class="starttime">
                            <input type="text" name="course_time[{{$i}}][starttime]" value="{{$info['course_time'][$i]->starttime}}" lay-verify="required" disabled class="layui-input">
                        </div>
                        <span class="start_end">--</span>
                        <div class="starttime">
                            <input type="text" name="course_time[{{$i}}][endtime]" value="{{$info['course_time'][$i]->endtime}}" lay-verify="required" disabled class="layui-input">
                        </div>
                    </div>
                </div>
            </div>
        @endfor
    </div>
</div>
<div class="layui-row layui-col-space15">
    <div class="layui-card">
        <label for="" class="layui-form-label">年龄</label>
        <div class="layui-input-block">
            <input type="text" name="ages" style="width:90%;padding: 5px;" value="{{$info->ages}}" lay-verify="required"   disabled class="layui-input" >
        </div>
    </div>
</div>
<div class="layui-row layui-col-space15" style="padding-bottom: 20px;">
    <div class="layui-card">
        <label for="" class="layui-form-label">班级描述</label>
        <div class="layui-input-block">
            <textarea name="course_describe" style="width:90%;height:90px;resize:none;border-color: #e6e6e6;">{{$info->course_describe??old('course_describe')}}</textarea>
        </div>
    </div>
</div>
<div class="layui-form-item">
    <div class="layui-input-block">
        @if($from=='student')
            <a  class="layui-btn" href="{{route('admin.student')}}" >返 回</a>
        @elseif($from=='classroom')
            <a  class="layui-btn" href="{{route('admin.classroom')}}" >返 回</a>
        @else
            <a  class="layui-btn" href="{{route('admin.course')}}" >返 回</a>
        @endif
        <a  class="layui-btn layui-btn-normal" href="{{route('admin.course.edit',['id'=>$info->id])}}" >编 辑</a>
    </div>
</div>







