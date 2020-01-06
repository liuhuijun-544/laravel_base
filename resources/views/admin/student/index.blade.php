@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-form layui-card-header layuiadmin-card-header-auto" >
            <span class="layui-form-label" style="width: auto;"> 搜索 </span>
            <div class="layui-input-inline" style="width: 200px;float:left;">
                <input class="layui-input" name="keywords" id="keywords" autocomplete="off" placeholder="请输入孩子姓名、手机号">
            </div>
            <button class=" layui-btn layui-btn-normal" data-type="reload" id="search" style="margin-left: 40px">搜索</button>
        </div>

        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">
                    <a class="layui-btn layui-btn-sm" lay-event="show">查看</a>
                    @can('student.edit')
                        <a class="layui-btn layui-btn-sm" lay-event="edit">编辑</a>
                    @endcan
                    @can('student.del')
                        <a class="layui-btn layui-btn-sm layui-btn-danger" lay-event="del">删除</a>
                    @endcan
                </div>
            </script>
            <script type="text/html" id="child_name">
            <a href="/admin/student/@{{d.id}}/show" style="color:#3c8dbc" title="点击查看">@{{d.name}}</a>
            </script>
            <script type="text/html" id="course_identifier">
                <a href="/admin/course/@{{d.course_id}}/show?from=student" style="color:#3c8dbc" title="点击查看">@{{d.course_identifier}}</a>
            </script>
        </div>
    </div>

    </div>
@endsection
@section('script')

    <script>
        layui.use(['layer','table','form'],function () {
            var layer = layui.layer;
            var form = layui.form;
            var table = layui.table;
            //用户表格初始化
            var dataTable = table.render({
                elem: '#dataTable'
                ,height: 500
                ,url: "{{ route('admin.student.data') }}" //数据接口
                ,page: true //开启分页
                ,limit:20
                ,page: true //开启分页
                ,cols: [[ //表头
                    {field: 'identifier', title: '学员编号', sort: true,width:150}
                    ,{field: 'name', title: '孩子姓名',width:90,templet:'#child_name'}
                    ,{field: 'parent_name', title: '家长姓名',width:95}
                    ,{field: 'status', title: '状态',width:70}
                    ,{field: 'age', title: '年龄',width:60}
                    ,{field: 'mobile', title: '电话'}
                    ,{field: 'phone', title: '手机'}
                    ,{field: 'course_identifier', title: '班级',templet:'#course_identifier'}
                    ,{field: 'teacher_name', title: '主讲老师',width:90}
                    ,{fixed: 'right',title: '操作', align:'center',width:150, toolbar: '#options'}
                ]]
            });
            //排序
            table.on('sort(dataTable)', function(obj){
                  table.reload('dataTable', { //testTable是表格容器id
                    initSort: obj //记录初始排序，如果不设的话，将无法标记表头的排序状态。 layui 2.1.1 新增参数
                    ,where: { //请求参数（注意：这里面的参数可任意定义，并非下面固定的格式）
                      field: obj.field //排序字段
                      ,order: obj.type //排序方式
                    },
                    page:{curr:1}
                  });
            });
            //监听工具条
            table.on('tool(dataTable)', function(obj){ //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
                var data = obj.data //获得当前行数据
                    ,layEvent = obj.event; //获得 lay-event 对应的值
                if(layEvent === 'edit'){
                    location.href = '/admin/student/'+data.id+'/edit';
                }else if(layEvent === 'show'){
                    location.href = '/admin/student/'+data.id+'/show';
                }else if(layEvent === 'del'){
                    layer.confirm('确认删除学员?', {icon: 3, title:'提示'}, function(index){
                        location.href = '/admin/student/'+data.id+'/del';
                        layer.close(index);
                    });
                }
            });
            //搜索
            $("#search").click(function () {
                var keywords = $("#keywords").val();
                dataTable.reload({
                    where:{keywords:keywords},
                    page:{curr:1}
                })
            })
        });
    </script>
@endsection



