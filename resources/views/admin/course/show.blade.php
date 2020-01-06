
@extends('admin.base')

@section('content')
    <style>
        .layui-card .layui-tab-brief .layui-tab-title li.layui-this {
            color: #009688;
        }
    </style>
    <input type="hidden" id="course_id" value="{{$info->id}}">
    <div class="layui-card">
        <div class="layui-card-body">
            <div class="layui-tab layui-tab-brief" lay-filter="demo">
                <ul class="layui-tab-title">
                    <li class="layui-this">班级信息</li>
                    <li>班级学员</li>
                    <li>课程安排</li>
                </ul>
                <div class="layui-tab-content">
                    <div class="layui-tab-item layui-show">
                        @include('admin.course._show1')
                    </div>
                    <div class="layui-tab-item">
                        @include('admin.course._show2')
                    </div>
                    <div class="layui-tab-item">
                        @include('admin.course._show3')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')

    <script>
        var course_id = $("#course_id").val();
        layui.use(['layer','table','form'],function () {
            var layer = layui.layer;
            var form = layui.form;
            var table = layui.table;
            //用户表格初始化
            var dataTable = table.render({
                elem: '#dataTable'
                ,height: 500
                ,url: "{{ route('admin.course.show_student') }}" //数据接口
                ,page: false //开启分页
                ,where:{id:course_id}
                ,cols: [[ //表头
                    {field: 'identifier', title: '学员编号', sort: true,templet: '#identifier'}
                    ,{field: 'name', title: '孩子姓名'}
                    ,{field: 'age', title: '年龄'}
                    ,{field: 'phone', title: '手机'}
                    ,{field: 'lecturer_name', title: '主讲老师'}
                    ,{field: 'teacher_name', title: '教务老师'}
                    ,{field: 'enter_class_date', title: '入班日期'}
                    ,{fixed: 'right',title: '操作', align:'center',width:100, toolbar: '#options'}
                ]]
            });

            //删除监控
            table.on('tool(dataTable)', function(obj){ //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
                var data = obj.data //获得当前行数据
                    ,layEvent = obj.event; //获得 lay-event 对应的值
                if(layEvent === 'student_del'){
                    $.get("{{route('admin.course.delStudent')}}",{'id':data.id,'course_id':data.course_id},function (res) {
                        if (res.code==0) {
                            layer.msg(res.msg);
                            dataTable.reload();
                        }else {
                            layer.msg(res.msg);
                        }
                    });
                }
            });
        });

        $(".addStudent").click(function () {

            layui.use('layer', function(){
                var layer = layui.layer;
                layer.open({
                    type: 2,
                    title :'添加学员',
                    offset :'20px',
                    area: ['80%','90%'],
                    content: "{{route('admin.course.addStudent',['course_id'=>$info->id])}}",
                    cancel: function(index, layero){
                        layui.table.reload('dataTable');
                        layer.close(index);
                        return false;
                    }
            });

            });
        });

    </script>
@endsection




