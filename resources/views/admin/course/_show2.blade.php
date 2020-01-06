<div class="layui-card">
    <div class="layui-form layui-card-header" style="padding: 0;">
        @can('course.addStudent')
            <button class="layui-btn layui-btn-sm addStudent">添加学员</button>
        @endcan
    </div>
    <table id="dataTable" lay-filter="dataTable"></table>
    @can('course.delStudent')
    <script type="text/html" id="options">
        <div class="layui-btn-group">
            <a class="layui-btn layui-btn-sm layui-btn-danger" lay-event="student_del">删除</a>
        </div>
    </script>
    @endcan
    <script type="text/html" id="identifier">
        <a href="/admin/course/@{{d.id}}/show" style="color:#3c8dbc" title="点击查看">@{{d.identifier}}</a>
    </script>
</div>






