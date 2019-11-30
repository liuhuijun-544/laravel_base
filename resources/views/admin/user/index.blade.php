@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-form layui-card-header layuiadmin-card-header-auto" >
            <span class="layui-form-label" style="width: auto;"> 搜索 </span>
            <div class="layui-inline">
                <input class="layui-input" name="keyword" id="title" autocomplete="off" placeholder="请输入账户、用户名、手机号" style="width: 320px">
            </div>

            <button class=" layui-btn layui-btn-normal" data-type="reload" id="searchBtn" style="margin-left: 40px">搜索</button>
            @can('system.user.create')
            <a class="layui-btn layui-btn" href="{{ route('admin.user.create') }}">添 加</a>
            @endcan
        </div>

        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">
                    @can('system.user.edit')
                    <a class="layui-btn layui-btn-sm" lay-event="edit">编辑</a>
                    @endcan
                    @can('system.user.role')
                    <a class="layui-btn layui-btn-sm" lay-event="role">角色</a>
                    @endcan
                    @can('system.user.destroy')
                    <a class="layui-btn layui-btn-danger layui-btn-sm " lay-event="del">删除</a>
                    @endcan
                </div>
            </script>
        </div>

    </div>
@endsection

@section('script')
    @can('system.user')
    <script>
        layui.use(['layer','table','form'],function () {
            var layer = layui.layer;
            var form = layui.form;
            var table = layui.table;

            //用户表格初始化
            var dataTable = table.render({
                elem: '#dataTable'
                ,height: 500
                ,url: "{{ route('admin.user.data') }}" //数据接口
                ,response:{
                    dataName:'list',
                    countName:'counts'
                }
                ,page: true //开启分页
                ,cols: [[ //表头
                    {field: 'id', title: 'ID', sort: true,width:60, align:'center'}
                    ,{field: 'usercode', title: '账户', align:'center'}
                    ,{field: 'name', title: '用户名', align:'center'}
                    ,{field: 'mobile', title: '电话', align:'center'}
                    ,{field: 'useremail', title: '邮箱', align:'center'}
                    ,{field: 'userlasttime', title: '最后登录时间', align:'center'}
                    // ,{field: 'userlastip', title: '最后登录ip', align:'center'}
                    ,{fixed: 'right', align:'center', toolbar: '#options',title: '操作'}
                ]]
            });

            //监听工具条
            table.on('tool(dataTable)', function(obj){ //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
                var data = obj.data //获得当前行数据
                    ,layEvent = obj.event; //获得 lay-event 对应的值
                if(layEvent === 'del'){
                    layer.confirm('确认删除吗？', function(index){
                        $.post("{{ route('admin.user.destroy') }}",{_method:'delete',ids:[data.id]},function (result) {
                            if (result.code==0){
                                obj.del(); //删除对应行（tr）的DOM结构
                            }
                            layer.close(index);
                            layer.msg(result.msg,{icon:6})
                        });
                    });
                } else if(layEvent === 'edit'){
                    location.href = '/admin/user/'+data.id+'/edit';
                } else if (layEvent === 'role'){
                    location.href = '/admin/user/'+data.id+'/role';
                } else if (layEvent === 'permission'){
                    location.href = '/admin/user/'+data.id+'/permission';
                }
            });

            //搜索
            $("#searchBtn").click(function () {
                var title = $("#title").val()
                dataTable.reload({
                    where:{title:title},
                    page:{curr:1}
                });
            
            })
        })
    </script>
    @endcan
@endsection



