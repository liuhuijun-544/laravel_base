<div class="layui-card week_time">
    <label for="" class="layui-form-label"></label>
    <div class="layui-input-block">
        <div class="week_line">
            <div class="week">
                <select name="course_time[{{$week_count}}][week]" id="items__course_week">
                    <option value="星期一">星期一</option>
                    <option value="星期二">星期二</option>
                    <option value="星期三">星期三</option>
                    <option value="星期四">星期四</option>
                    <option value="星期五">星期五</option>
                    <option value="星期六">星期六</option>
                    <option value="星期日">星期日</option>
                </select>
            </div>
            <div class="starttime">
                <input type="text" name="course_time[{{$week_count}}][starttime]" id="starttime{{$week_count}}"  value="{{$info->starttime??old('starttime')}}" lay-verify="required" class="layui-input">
            </div>
            <span class="start_end">--</span>
            <div class="starttime">
                <input type="text" name="course_time[{{$week_count}}][endtime]" id="endtime{{$week_count}}" value="{{$info->endtime??old('endtime')}}" lay-verify="required" class="layui-input">
            </div>
        </div>
        <div class="layui-btn layui-btn-danger week_del">删除</div>
    </div>
</div>
<script>
    layui.use('laydate',function(){
        var laydate = layui.laydate;
        laydate.render({
            elem: '#starttime{{$week_count}}',
            type: 'time',
            format: 'HH:mm',
            trigger: 'click'
        })

        laydate.render({
            elem: '#endtime{{$week_count}}',
            type: 'time',
            format: 'HH:mm',
            trigger: 'click'
        })

    });
</script>
