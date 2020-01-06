<style>
    .detail-add{
        color: #3c8dbc;
        cursor: pointer;
        line-height: 38px;
    }
</style>
{{csrf_field()}}
<input type="hidden" value="{{$count_detail}}" id="count_detail" >
<div class="layui-row layui-col-space15" style="padding: 10px 0px;">
    <div class="layui-col-md6">
        <div class="layui-card">
            <label for="" class="layui-form-label">月份</label>
            <div class="layui-input-inline">
                <select name="year" id="year" lay-filter="year" >
                    @for($i=$year-5;$i<=$year+5;$i++)
                        <option value="{{$i}}" @if($i==$info->year || $i==$year) selected @endif>{{$i}}年</option>
                    @endfor
                </select>
            </div>
            <div class="layui-input-inline">
                <select name="month" id="month" lay-filter="month">
                    @for($i=1;$i<=12;$i++)
                        <option value="{{$i}}" @if($i==$info->month || $i==$month) selected @endif>{{$i}}月</option>
                    @endfor
                </select>
            </div>
        </div>
        <div class="layui-card">
            <label for="" class="layui-form-label">教室</label>
            <div class="layui-input-block">
                <select name="classroom_id"  layui-search lay-verify="required">
                    <option value="">请选择</option>
                    @foreach($classroom as $item)
                        <option value="{{$item['id']}}" @if($item['id']==$info->classroom_id) selected @endif>{{$item['name']}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="layui-card">
            <label for="" class="layui-form-label">班级</label>
            <div class="layui-input-block">
                <select name="course_id"  layui-search lay-verify="required">
                    <option value="">请选择</option>
                    @foreach($course as $item)
                        <option value="{{$item['id']}}" @if($item['id']==$info->course_id) selected @endif>{{$item['identifier']}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="layui-card">
            <label for="" class="layui-form-label">老师</label>
            <div class="layui-input-block">
                <select name="teacher"  layui-search lay-verify="required">
                    <option value="">请选择</option>
                    @foreach($user as $k=>$v)
                        <option value="{{$k}}" @if($k==$info->teacher) selected @endif>{{$v}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
<div class="layui-row layui-col-space15" style="padding: 10px 0px;">
    <div class="layui-col-md1">
        <label for="" class="layui-form-label">时间</label>
        <div class="layui-input-block course_detail" style="min-width: 900px;">
            <div class="layui-input-block" style="min-width:900px;">
                <div class="detail-add">添加</div>
            </div>
            @for($i=0;$i<count($info['detail']);$i++)
                <div class="layui-input-block" style="min-width:950px; @if($i>0) margin-top: 15px; @endif">
                    <div class="layui-input-inline">课程编号：</div>
                    <div class="layui-input-inline" style="width: 100px;"><input type="text" name="detail[{{$i}}][course_code]" value="{{$info['detail'][$i]->course_code}}" readonly class="layui-input layui-disabled"></div>
                    <div class="layui-input-inline margin">课程：</div>
                    <div class="layui-input-inline">
                        <select name="detail[{{$i}}][course_attribute_id]" lay-search lay-verify="required">
                            <option value="">请选择</option>
                            @foreach($course_attribute as $item)
                                <option value="{{$item['id']}}" @if($info['detail'][$i]->course_attribute_id==$item['id']) selected @endif>{{$item['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="layui-input-inline margin">开始时间：</div>
                    <div class="layui-input-inline" style="width: 140px;"><input type="text" name="detail[{{$i}}][starttime]" lay-verify="required" value="{{date('Y-m-d H:i',strtotime($info['detail'][$i]->starttime))}}" class="layui-input"></div>
                    <div class="layui-input-inline margin">结束时间：</div>
                    <div class="layui-input-inline" style="width: 140px;"><input type="text" name="detail[{{$i}}][endtime]" lay-verify="required" value="{{date('Y-m-d H:i',strtotime($info['detail'][$i]->endtime))}}" class="layui-input"></div>
                    <div class="layui-btn layui-btn-danger detail_del">删除</div>
                </div>
            @endfor
        </div>
    </div>
</div>

<div class="layui-form-item" style="margin-top:10px;">
    <div class="layui-input-block">
        @if($info->if)
        <a  class="layui-btn layui-btn-primary" href="{{route('admin.classroom.show',['id'=>$info->id])}}" >返 回</a>
        @endif
        <button type="submit" class="layui-btn" lay-submit="formDemo" lay-filter="formDemo">确 认</button>
    </div>
</div>