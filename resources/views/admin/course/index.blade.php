@extends('admin.base')

@section('content')
    <style>
        .layui-table-cell{
            height: auto;
            white-space: normal;
            padding: 0 10px;
            line-height: 20px;
        }
    </style>
    <div class="layui-card">
        <div class="layui-form layui-card-header layuiadmin-card-header-auto" >
            <span class="layui-form-label" style="width: auto;"> 主讲教师 </span>
            <div class="layui-input-inline" style="float:left;">
                <select name="type" id="user">
                    <option value="">请选择</option>
                    @foreach($users as $k=>$v)
                        <option value="{{$k}}">{{$v}}</option>
                    @endforeach
                </select>
            </div>
            <span class="layui-form-label" style="width: auto;"> 课程类别 </span>
            <div class="layui-input-inline" style="float:left;">
                <select name="type" id="class_type" lay-search>
                    <option value="">请选择</option>
                    @foreach($class_type as $v)
                        <option value="{{$v}}">{{$v}}</option>
                    @endforeach
                </select>
            </div>
            <button class=" layui-btn layui-btn-normal" data-type="reload" id="search" style="margin-left: 40px">搜索</button>
            @can('course.export')
                <a class="layui-btn layui-btn-sm"  onclick="exportExcel();" style="float: right;margin-top: 9px;margin-right: 0px;">导出</a>
            @endcan
            @can('course.add')
                <a class="layui-btn layui-btn-sm" href="{{ route('admin.course.add') }}" style="float: right;background:rgb(0, 146, 252);margin-left: 1rem;margin-top: 9px;">添 加</a>
            @endcan
        </div>

        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">
                    <a class="layui-btn layui-btn-sm" lay-event="show">查看</a>
                    @can('course.edit')
                        <a class="layui-btn layui-btn-sm" lay-event="edit">编辑</a>
                    @endcan
                </div>
            </script>
            <script type="text/html" id="identifier">
            <a href="/admin/course/@{{d.id}}/show" style="color:#3c8dbc" title="点击查看">@{{d.identifier}}</a>
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
                ,url: "{{ route('admin.course.data') }}" //数据接口
                ,page: true //开启分页
                ,limit:20
                ,limits:[20,50,100]
                ,page: true //开启分页
                ,cols: [[ //表头
                    {field: 'identifier', title: '班级编号', sort: true,templet: '#identifier'}
                    ,{field: 'type', title: '课程类别',width:100}
                    ,{field: 'lecturer_name', title: '主讲老师',width:80}
                    ,{field: 'teacher_name', title: '教务老师',width:80}
                    ,{field: 'degree_number', title: '班满容量',width:80}
                    ,{field: 'left_number', title: '剩余学位',width:80}
                    ,{field: 'ages',title: '适合年龄'}
                    ,{field: 'is_choose',sort: true, title: '可选',width:70}
                    ,{field: 'is_delete',sort: true, title: '作废',width:70}
                    ,{field: 'time_str',sort: true, title: '上课时间',width:160}
                    ,{fixed: 'right',title: '操作', align:'center', toolbar: '#options'}
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
                    location.href = '/admin/course/'+data.id+'/edit';
                }else if(layEvent === 'show'){
                    location.href = '/admin/course/'+data.id+'/show';
                }
            });
            //搜索
            $("#search").click(function () {
                var user = $("#user").val();
                var class_type = $("#class_type").val();
                dataTable.reload({
                    where:{user:user,class_type:class_type},
                    page:{curr:1}
                })
            })
        });


        function exportExcel() {
            var keywords = $("#keywords").val();

             var param = '{"keywords":"'+keywords+'"}';

            location.href = '/admin/course/export?param='+param;
        }

    </script>
@endsection



