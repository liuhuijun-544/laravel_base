<div class="layui-input-block" style="min-width:950px;margin-top: 15px;">
    <div class="layui-input-inline">课程编号：</div>
    <div class="layui-input-inline" style="width: 100px;"><input type="text" name="detail[{{$count_detail}}][course_code]" placeholder="自动生成" readonly class="layui-input layui-disabled" ></div>
    <div class="layui-input-inline margin">课程：</div>
    <div class="layui-input-inline">
        <select name="detail[{{$count_detail}}][course_attribute_id]" lay-search lay-verify="required">
            <option value="">请选择</option>
            @foreach($course_attribute as $item)
                <option value="{{$item['id']}}">{{$item['name']}}</option>
            @endforeach
        </select>
    </div>
    <div class="layui-input-inline margin">开始时间：</div>
    <div class="layui-input-inline" style="width: 140px;"><input type="text" name="detail[{{$count_detail}}][starttime]" lay-verify="required" id="starttime{{$count_detail}}" class="layui-input"></div>
    <div class="layui-input-inline margin">结束时间：</div>
    <div class="layui-input-inline" style="width: 140px;"><input type="text" name="detail[{{$count_detail}}][endtime]" lay-verify="required" id="endtime{{$count_detail}}" class="layui-input"></div>
    <div class="layui-btn layui-btn-danger detail_del">删除</div>
</div>

<script>
    layui.use('laydate',function(){
        var laydate = layui.laydate;
        var form = layui.form;
        laydate.render({
            elem: '#starttime{{$count_detail}}',
            type: 'datetime',
            format: 'yyyy-MM-dd HH:mm',
            trigger: 'click'
        })

        laydate.render({
            elem: '#endtime{{$count_detail}}',
            type: 'datetime',
            format: 'yyyy-MM-dd HH:mm',
            trigger: 'click'
        })

    });
</script>
