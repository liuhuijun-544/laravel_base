@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <form id="search-form" class="layui-form">
                <div class="layui-form-item">
                    <label class="layui-form-label">操作模块</label>
                    <div class="layui-input-inline">
                        <select name="module" lay-search>
                            <option value="">全部</option>
                            @foreach(\App\Models\SysLog::$optModuleName as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <label class="layui-form-label">操作类型</label>
                    <div class="layui-input-inline">
                        <select name="type" lay-search>
                            <option value="">全部</option>
                            @foreach(\App\Models\SysLog::$optTypeName as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <label class="layui-form-label">操作页面</label>
                    <div class="layui-input-inline">
                        <div class="layui-input-inline">
                            <input type="text" name="optPage" id="optPage" placeholder="操作页面" class="layui-input">
                        </div>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <label class="layui-form-label">操作人</label>
                        <div class="layui-input-inline">
                            <div class="layui-input-inline">
                                <input type="text" name="username" id="username" placeholder="操作人" class="layui-input">
                            </div>
                        </div>
                        <label class="layui-form-label">被操作人</label>
                        <div class="layui-input-inline">
                            <div class="layui-input-inline">
                                <input type="text" name="content" id="content" placeholder="被操作人" class="layui-input">
                            </div>
                        </div>
                        <label class="layui-form-label">操作时间</label>
                        <div class="layui-input-inline" style="width: 120px;">
                            <input type="text" name="time_start" id="time_start" placeholder="开始时间" class="layui-input">
                        </div>
                        <div class="layui-input-inline" style="width: 120px;">
                            <input type="text" name="time_end" id="time_end" placeholder="结束时间" class="layui-input">
                        </div>
                        <div class="layui-btn-group ">
                            <button type="submit" class="layui-btn layui-btn-sm" lay-submit="" lay-filter="formDemo">
                                搜 索
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="layui-card-body" style="padding-bottom: 0">
            <span><button class="layui-btn layui-btn-primary">操作日志</button></span>
            @can('system.sysLog.export')
                <a style="float: right;margin-top: 7px" class="layui-btn layui-btn-sm" onclick="exportExcel()">导 出</a>
            @endcan
        </div>
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>
        </div>
    </div>
@endsection

@section('script')
    @can('system.sysLog')
        <script>
            var dataTable;
            layui.use(['layer', 'table', 'form', 'laydate'], function () {
                var layer = layui.layer;
                var form = layui.form;
                var table = layui.table;
                var laydate = layui.laydate;

                laydate.render({
                    elem: '#time_start' //指定元素
                });
                laydate.render({
                    elem: '#time_end' //指定元素
                });

                //用户表格初始化
                dataTable = table.render({
                    elem: '#dataTable'
                    , autoSort: false //禁用前端自动排序。注意：该参数为 layui 2.4.4 新增
                    , height: 500
                    , url: "{{ route('admin.sysLog.data') }}" //数据接口
                    , where: {model: "user"}
                    , page: true //开启分页
                    , limit: 20
                    , limits: [20, 50, 100]
                    , cols: [[ //表头
                        {field: 'id', title: 'ID', sort: true, width: 80}
                        , {field: 'username', title: '操作人', width: 160, align: 'center', sort: true}
                        , {field: 'module', title: '操作模块', width: 120, align: 'center', sort: true}
                        , {field: 'page', title: '操作页面', width: 300, align: 'center', sort: true}
                        , {field: 'type', title: '操作类型', width: 120, align: 'center', sort: true}
                        , {field: 'content', title: '被操作者', width: 600, align: 'center', sort: true}
                        , {field: 'created_at', title: '操作时间', width: 180, align: 'center', sort: true}
                    ]]
                });

                // 搜索
                form.on('submit(formDemo)', function (data) {
                    field = data.field;
                    dataTable.reload({
                        where: field,
                        page: {curr: 1}
                    });
                    return false; // 阻止表单跳转
                });
            });

            var field = {};

            // 导出
            function exportExcel() {
                location.href = '/admin/sysLog/export?params=' + JSON.stringify(field);
            }
        </script>
    @endcan
@endsection



