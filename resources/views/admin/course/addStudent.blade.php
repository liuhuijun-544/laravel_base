@extends('admin.base')
<style type="text/css">

    .layui-card-body{
        padding-left: 10px;
        padding-top: 20px;
    }
</style>
@section('content')
    <input type="hidden" id="course_id" value="{{$course_id}}">
<div class="layui-card">
    <div class="layui-form layui-card-header layuiadmin-card-header-auto">
        <div class="layui-input-inline" style="width: 200px;float:left;">
            <input class="layui-input" name="keywords" id="keywords" autocomplete="off" placeholder="请输入孩子姓名、手机号">
        </div>
        <button class=" layui-btn layui-btn-normal" data-type="reload" id="search" style="margin-left: 40px">搜索</button>
    </div>
    <table id="studentDataTable" lay-filter="studentDataTable"></table>
    <div class="layui-card-body" style="float: right;">
        <a href="" class="layui-btn layui-btn-sm close">关闭</a>
    </div>
    <script type="text/html" id="options">
        <div class="layui-btn-group">
            @can('course.addStudent')
                <a class="layui-btn layui-btn-sm" lay-event="addStudent">添加</a>
            @endcan
        </div>
    </script>
</div>

@endsection

@section('script')
<script type="text/javascript">
    $('.close').click(function(){
        layui.use('layer', function(){
            var layer = layui.layer;
            var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
            parent.layer.close(index); //再执行关闭
            parent.layui.table.reload('dataTable');
        }); 
        
    })

    layui.use(['layer','table','form'],function () {
        var layer = layui.layer;
        var form = layui.form;
        var table = layui.table;
        //用户表格初始化
        var dataTable1 = table.render({
            elem: '#studentDataTable'
            ,height: 300
            ,url: "{{ route('admin.student.data') }}" //数据接口
            ,page: true //开启分页
            ,cols: [[ //表头
                {field: 'identifier', title: '学员编号', sort: true,templet: '#identifier'}
                ,{field: 'name', title: '孩子姓名',width:100}
                ,{field: 'age', title: '年龄',width:80}
                ,{field: 'mobile', title: '电话'}
                ,{field: 'phone', title: '手机'}
                ,{field: 'course_identifier', title: '班级编号'}
                ,{fixed: 'right',title: '操作', align:'center',width:100, toolbar: '#options'}
            ]]
        });

        //搜索
        $("#search").click(function () {
            var keywords = $("#keywords").val();
            dataTable1.reload({
                where:{keywords:keywords},
                page:{curr:1}
            })
        })

        //监听工具条
        table.on('tool(studentDataTable)', function(obj){ //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
            var data = obj.data //获得当前行数据
                ,layEvent = obj.event; //获得 lay-event 对应的值
            if(layEvent === 'addStudent'){
                var course_id = $("#course_id").val();
                if(data.course_identifier){
                    layer.confirm('该学员已经关联班级，是否重新分配？', {icon: 3, title:'提示'}, function(index){
                        layer.close(index);
                        $.get("{{route('admin.course.saveStudent')}}",{'id':data.id,'course_id':course_id},function (res) {
                            if (res.code==0) {
                                layer.msg(res.msg);
                                dataTable1.reload();
                            }else {
                                layer.msg(res.msg);
                            }
                        });
                    });
                }else{
                    $.get("{{route('admin.course.saveStudent')}}",{'id':data.id,'course_id':course_id},function (res) {
                        if (res.code==0) {
                            layer.msg(res.msg);
                            dataTable1.reload();
                        }else {
                            layer.msg(res.msg);
                        }
                    });
                }
            }
        });
    });

</script>
@endsection
