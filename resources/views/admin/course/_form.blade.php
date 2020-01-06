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
    .layui-disabled{
        background-color: #eeeeee;
    }
</style>
{{csrf_field()}}
<input type="hidden" id="week_count" value="{{$week_count}}">
<div class="layui-row layui-col-space15" style="padding-top: 10px;">
    <div class="layui-col-md6">
        <div class="layui-card">
            <label for="" class="layui-form-label">班级编号</label>
            <div class="layui-input-block">
                <input type="text" name="child_name" value="{{$info->identifier}}"  placeholder="自动生成" readonly class="layui-input layui-disabled" style="background-color: #eeeeee">
            </div>
        </div>
        <div class="layui-card">
            <label for="" class="layui-form-label"><span style="color: red;">*</span>主讲老师</label>
            <div class="layui-input-block">
                <select name="lecturer" lay-verify="required" lay-search>
                <option value=""></option>
                @foreach($teacher as $k=>$v)
                    <option value="{{$k}}" @if($k==$info->lecturer) selected @endif>{{$v}}</option>
                @endforeach
                </select>
            </div>
        </div>
        <div class="layui-card">
            <label for="" class="layui-form-label"><span style="color: red;">*</span>教务老师</label>
            <div class="layui-input-block">
                <select name="edu_teacher_id" lay-verify="required" lay-search>
                    <option value=""></option>
                    @foreach($administration as $k=>$v)
                        <option value="{{$k}}" @if($k==$info->edu_teacher_id) selected @endif>{{$v}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="layui-card">
            <label for="" class="layui-form-label">班级进度</label>
            <div class="layui-input-block">
                <input type="text" name="schedule" value="{{$info->schedule??old('schedule')}}"  placeholder="请输入班级进度" class="layui-input">
            </div>
        </div>
        <div class="layui-card">
            <label for="" class="layui-form-label">满班容量</label>
            <div class="layui-input-block">
                <input type="text" name="degree_number" value="{{$info->degree_number??old('degree_number')}}"  placeholder="请输入满班容量" class="layui-input">
            </div>
        </div>
        <div class="layui-card">
            <label for="" class="layui-form-label">剩余学位</label>
            <div class="layui-input-block">
                <input type="text" name="left_number" value="{{$info->left_number??old('left_number')}}"  placeholder="请输入满班容量" readonly class="layui-input layui-disabled" >
            </div>
        </div>
        <div class="layui-card">
            <label class="layui-form-label"></label>
            <div class="layui-input-block" style="height: 18px;line-height: 18px;">
                <input type="checkbox" name="is_public" @if($info->is_public) checked @endif value="1" title="公用" lay-skin="primary">
                <input type="checkbox" name="is_plan" @if($info->is_plan) checked @endif value="1" title="安排课程" lay-skin="primary">
                <input type="checkbox" name="is_delete" @if($info->is_delete) checked @endif value="1" title="作废" lay-skin="primary">
                <input type="checkbox" name="is_choose" @if($info->is_choose) checked @endif value="1" title="可选" lay-skin="primary">
            </div>
        </div>
    </div>
    <div class="layui-col-md6">
        <div class="layui-card">
            <label for="" class="layui-form-label"><span style="color: red;">*</span>课程类别</label>
            <div class="layui-input-block">
                <select name="type" lay-verify="required" lay-search>
                    <option value=""></option>
                    @foreach($class_type as $item)
                        <option value="{{$item}}" @if($item==$info->type) selected @endif>{{$item}}</option>@endforeach
                </select>
            </div>
        </div>
        <div class="layui-card">
            <label class="layui-form-label"><span style="color: red;">*</span>开班日期</label>
            <div class="layui-input-block">
                <input type="text" name="start_date" id="start_date" value="{{$info->start_date??old('start_date')}}" lay-verify="required" placeholder="请选择开班日期" @if($info->start_date) readonly class="layui-input layui-disabled" @else class="layui-input" @endif>
            </div>
        </div>
        <div class="layui-card week_time">
            <label for="" class="layui-form-label"><span style="color: red;">*</span>上课时间</label>
            <div class="layui-input-block">
                <div class="week_line">
                    <div class="week">
                        <select name="course_time[0][week]" id="items__course_week" lay-verify="required">
                            <option value="星期一" @if($info['course_time'][0]->week=='星期一') selected @endif>星期一</option>
                            <option value="星期二" @if($info['course_time'][0]->week=='星期二') selected @endif>星期二</option>
                            <option value="星期三" @if($info['course_time'][0]->week=='星期三') selected @endif>星期三</option>
                            <option value="星期四" @if($info['course_time'][0]->week=='星期四') selected @endif>星期四</option>
                            <option value="星期五" @if($info['course_time'][0]->week=='星期五') selected @endif>星期五</option>
                            <option value="星期六" @if($info['course_time'][0]->week=='星期六') selected @endif>星期六</option>
                            <option value="星期日" @if($info['course_time'][0]->week=='星期日') selected @endif>星期日</option>
                        </select>
                    </div>
                    <div class="starttime">
                        <input type="text" name="course_time[0][starttime]" id="starttime" value="{{$info['course_time'][0]->starttime??old('starttime')}}" lay-verify="required" class="layui-input">
                    </div>
                    <span class="start_end">--</span>
                    <div class="starttime">
                        <input type="text" name="course_time[0][endtime]" id="endtime" value="{{$info['course_time'][0]->endtime??old('endtime')}}" lay-verify="required" class="layui-input">
                    </div>
                </div>
                <div class="layui-btn layui-btn-normal week_add">添加</div>
            </div>
        </div>
        @if($week_count>1)
             @for($i=1;$i<$week_count;$i++)
                <div class="layui-card week_time">
                    <label for="" class="layui-form-label"></label>
                    <div class="layui-input-block">
                        <div class="week_line">
                            <div class="week">
                                <select name="course_time[{{$i}}][week]" id="items__course_week">
                                    <option value="星期一" @if($info['course_time'][$i]->week=='星期一') selected @endif>星期一</option>
                                    <option value="星期二" @if($info['course_time'][$i]->week=='星期二') selected @endif>星期二</option>
                                    <option value="星期三" @if($info['course_time'][$i]->week=='星期三') selected @endif>星期三</option>
                                    <option value="星期四" @if($info['course_time'][$i]->week=='星期四') selected @endif>星期四</option>
                                    <option value="星期五" @if($info['course_time'][$i]->week=='星期五') selected @endif>星期五</option>
                                    <option value="星期六" @if($info['course_time'][$i]->week=='星期六') selected @endif>星期六</option>
                                    <option value="星期日" @if($info['course_time'][$i]->week=='星期日') selected @endif>星期日</option>
                                </select>
                            </div>
                            <div class="starttime">
                                <input type="text" name="course_time[{{$i}}][starttime]" id="starttime{{$i}}"  value="{{$info['course_time'][$i]->starttime}}" lay-verify="required" class="layui-input">
                            </div>
                            <span class="start_end">--</span>
                            <div class="starttime">
                                <input type="text" name="course_time[{{$i}}][endtime]" id="endtime{{$i}}" value="{{$info['course_time'][$i]->endtime}}" lay-verify="required" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-btn layui-btn-danger week_del">删除</div>
                    </div>
                </div>
             @endfor
        @endif
    </div>
</div>
<div class="layui-row layui-col-space15">
    <div class="layui-card">
        <label for="" class="layui-form-label">年龄</label>
        <div class="layui-input-block" style="height: 18px;line-height: 18px;">
            <input type="checkbox" name="ages[]" @if(in_array('2岁',$ages)) checked @endif value="2岁" title="2岁" lay-skin="primary">
            <input type="checkbox" name="ages[]" @if(in_array('3岁',$ages)) checked @endif value="3岁" title="3岁" lay-skin="primary">
            <input type="checkbox" name="ages[]" @if(in_array('4岁',$ages)) checked @endif value="4岁" title="4岁" lay-skin="primary">
            <input type="checkbox" name="ages[]" @if(in_array('5岁',$ages)) checked @endif value="5岁" title="5岁" lay-skin="primary">
            <input type="checkbox" name="ages[]" @if(in_array('6岁',$ages)) checked @endif value="6岁" title="6岁" lay-skin="primary">
            <input type="checkbox" name="ages[]" @if(in_array('7岁',$ages)) checked @endif value="7岁" title="7岁" lay-skin="primary">
            <input type="checkbox" name="ages[]" @if(in_array('8岁',$ages)) checked @endif value="8岁" title="8岁" lay-skin="primary">
            <input type="checkbox" name="ages[]" @if(in_array('9岁',$ages)) checked @endif value="9岁" title="9岁" lay-skin="primary">
            <input type="checkbox" name="ages[]" @if(in_array('10岁',$ages)) checked @endif value="10岁" title="10岁" lay-skin="primary">
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
        <button type="submit"   class="layui-btn" lay-submit="formDemo" lay-filter="formDemo">确 认</button>
        <a  class="layui-btn" href="{{route('admin.course')}}" >返 回</a>
    </div>
</div>

