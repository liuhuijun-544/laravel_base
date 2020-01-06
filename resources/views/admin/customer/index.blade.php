@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-form layui-card-header layuiadmin-card-header-auto" >
            <span class="layui-form-label" style="width: auto;"> 搜索 </span>
            <div class="layui-input-inline" style="width: 200px;float:left;">
                <input class="layui-input" name="keywords" id="keywords" autocomplete="off" placeholder="请输入孩子姓名、手机号">
            </div>
            <span class="layui-form-label" style="width: auto;"> 信息状态 </span>
            <div class="layui-input-inline" style="top: -3px;">
                <select name="type" id="type">
                    <option value="">请选择</option>
                    <option value="0">潜在信息</option>
                    <option value="1">约访信息</option>
                    <option value="2">到访信息</option>
                </select>
            </div>
            <button class=" layui-btn layui-btn-normal" data-type="reload" id="search" style="margin-left: 40px">搜索</button>
            @can('customer.export')
                <a class="layui-btn layui-btn-sm"  onclick="exportExcel();" style="float: right;margin-top: 9px;margin-right: 0px;">导出</a>
            @endcan
            @can('customer.import')
                <a class="layui-btn layui-btn-sm"  onclick="importExcel();" style="float: right;background: rgb(37, 155, 36);margin-right: 0.5rem;margin-top: 9px;">导入</a>
            @endcan
            @can('customer.add')
                <a class="layui-btn layui-btn-sm" href="{{ route('admin.customer.add') }}" style="float: right;background:rgb(0, 146, 252);margin-left: 1rem;margin-top: 9px;">添 加</a>
            @endcan
        </div>

        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">
                    <a class="layui-btn layui-btn-sm" lay-event="show">查看</a>
                    @can('customer.edit')
                        <a class="layui-btn layui-btn-sm" lay-event="edit">编辑</a>
                    @endcan
                </div>
            </script>
            <script type="text/html" id="child_name">
            <a href="/admin/customer/@{{d.id}}/show" style="color:#3c8dbc" title="点击查看">@{{d.child_name}}</a>
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
                ,url: "{{ route('admin.customer.data') }}" //数据接口
                // ,where:{model:"customer"}
                ,page: true //开启分页
                ,limit:20
                ,limits:[20,50,100]
                ,page: true //开启分页
                ,cols: [[ //表头
                    {field: 'identifier', title: '信息编号', sort: true,}
                    ,{field: 'child_name', title: '孩子姓名',width:120,templet: '#child_name'}
                    ,{field: 'parent_name', title: '家长姓名',width:120}
                    ,{field: 'phone',sort: true, title: '手机号'}
                    ,{field: 'status_hidden',sort: true, title: '信息状态',width:120}
                    ,{field: 'name',sort: true, title: '负责人',width:120}
                    ,{field: 'updated_at',sort: true, title: '更新时间'}
                    ,{field: 'visit_at',sort: true, title: '下次回访日期'}
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
                    location.href = '/admin/customer/'+data.id+'/edit';
                }else if(layEvent === 'show'){
                    location.href = '/admin/customer/'+data.id+'/show';
                }
            });
            //搜索
            $("#search").click(function () {
                var keywords = $("#keywords").val();
                var type = $('#type').val();
                dataTable.reload({
                    where:{keywords:keywords,type:type},
                    page:{curr:1}
                })
            })
        });


        function exportExcel() {
            var keywords = $("#keywords").val();

             var param = '{"keywords":"'+keywords+'"}';

            location.href = '/admin/customer/export?param='+param;
        }

    function importExcel(){
        layui.use('layer', function(){
            var layer = layui.layer;

              layer.open({
                type: 2,
                title :'导入',
                offset :'20px',
                area: ['80%','90%'],
                content: '/admin/customer/importExcel'
              });

        });
    }

    </script>
@endsection



