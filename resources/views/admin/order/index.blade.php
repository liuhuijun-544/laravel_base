@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-form layui-card-header layuiadmin-card-header-auto" >
            <span class="layui-form-label" style="width: auto;"> 搜索 </span>
            <div class="layui-input-inline" style="width: 200px;float:left;">
                <input class="layui-input" name="keywords" id="keywords" autocomplete="off" placeholder="请输入付款人、销售姓名">
            </div>
            <span class="layui-form-label" style="width: auto;"> 收款时间 </span>
            <div class="layui-input-inline" style="top: -3px;">
                <input type="text" name="starttime" id="starttime" class="layui-input" placeholder="请选择开始时间">
            </div>
            <div class="layui-input-inline" style="top: -3px;">
                <input type="text" name="endtime" id="endtime" class="layui-input" placeholder="请选择结束时间">
            </div>
            <button class=" layui-btn layui-btn-normal" data-type="reload" id="search" style="margin-left: 40px">搜索</button>
            @can('admin.order.export')
                <a class="layui-btn layui-btn-sm"  onclick="exportExcel();" style="float: right;margin-top: 9px;margin-right: 0px;">导出</a>
            @endcan
            @can('admin.order.add')
                <a class="layui-btn layui-btn-sm" href="{{ route('admin.order.add') }}" style="float: right;background:rgb(0, 146, 252);margin-left: 1rem;margin-top: 9px;">添 加</a>
            @endcan
        </div>

        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">
                    <a class="layui-btn layui-btn-sm" lay-event="show">查看</a>
                    @can('admin.order.edit')
                        <a class="layui-btn layui-btn-sm" lay-event="edit">编辑</a>
                    @endcan
                    @can('admin.order.refund')
                        <a style="@{{ d.style }}" class="layui-btn layui-btn-sm" lay-event="refund">退款</a>
                    @endcan
                </div>
            </script>
            <script type="text/html" id="identifier">
                <a href="/admin/order/@{{d.id}}/show" style="color:#3c8dbc" title="点击查看">@{{d.identifier}}</a>
            </script>
        </div>
    </div>

    </div>
@endsection
@section('script')

    <script>
        layui.use(['layer','table','form','laydate'],function () {
            var layer = layui.layer;
            var form = layui.form;
            var table = layui.table;
            //用户表格初始化
            var dataTable = table.render({
                elem: '#dataTable'
                ,height: 500
                ,url: "{{ route('admin.order.data') }}" //数据接口
                // ,where:{model:"customer"}
                ,page: true //开启分页
                ,limit:20
                ,limits:[20,50,100]
                ,page: true //开启分页
                ,cols: [[ //表头
                    {field: 'identifier', title: '收款编号',templet: "#identifier"}
                    ,{field: 'pay_name', title: '付款人',width:90}
                    ,{field: 'amount', title: '付款金额',width:90}
                    ,{field: 'order_by', title: '收款人',width:90}
                    ,{field: 'way',sort: true, title: '收款方式',width:100}
                    ,{field: 'order_at',sort: true, title: '收款时间',width:170}
                    ,{field: 'status_name',sort: true, title: '状态',width:80}
                    ,{field: 'student_name', title: '关联学员',width:100}
                    ,{field: 'created_by_name',sort: true, title: '创建人',width:100}
                    ,{fixed: 'right',title: '操作', align:'center', toolbar: '#options'}
                ]]
            });
            //监听工具条
            table.on('tool(dataTable)', function(obj){ //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
                var data = obj.data //获得当前行数据
                    ,layEvent = obj.event; //获得 lay-event 对应的值
                if(layEvent === 'edit'){
                    location.href = '/admin/order/'+data.id+'/edit';
                }else if(layEvent === 'show'){
                    location.href = '/admin/order/'+data.id+'/show';
                }else if(layEvent === 'refund'){
                    $.get("{{ route('admin.order.refund') }}", {'id':data.id}, function (result) {
                        if (result.code == 0) {
                            layer.msg(result.msg);
                            dataTable.reload();
                        }
                    });
                }
            });
            //搜索
            $("#search").click(function () {
                var keywords = $("#keywords").val();
                var starttime = $('#starttime').val();
                var endtime = $('#endtime').val();
                dataTable.reload({
                    where:{keywords:keywords,starttime:starttime,endtime:endtime},
                    page:{curr:1}
                })
            })

            var laydate = layui.laydate;
            //执行一个laydate实例
            laydate.render({
                elem: '#starttime',
                type: 'datetime',
                format: 'yyyy-MM-dd HH:mm',
                trigger: 'click'
            })

            laydate.render({
                elem: '#endtime',
                type: 'datetime',
                format: 'yyyy-MM-dd HH:mm',
                trigger: 'click'
            })
        });


        function exportExcel() {
            var keywords = $("#keywords").val();
            var starttime = $('#starttime').val();
            var endtime = $('#endtime').val();

            var param = '{"keywords":"'+keywords+'","starttime":"'+starttime+'","endtime":"'+endtime+'"}';
            location.href = '/admin/order/export?param='+param;
        }

    </script>
@endsection



