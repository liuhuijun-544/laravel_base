@extends('admin.base')

@section('content')
    <style>
        .layui-col-md6{
            height: 465px;
            float: left;
            padding-left: 30px;
            padding-right: 30px;
        }
        .layui-card-header.layuiadmin-card-header-auto{
            padding-top: 5px;
            padding-bottom: 5px;
        }
        .layui-table-cell{
            padding: 0 5px;
        }
        .layui-table-view .layui-table td, .layui-table-view .layui-table th {
            padding: 0;
        }
        .layui-input-inline{
            width: 120px;
        }
    </style>
    <div class="layui-card">
        @can('classroom.add')
        <div class="layui-card-header layuiadmin-card-header-auto" style="border-bottom: 0px;">
            <a class="layui-btn layui-btn-sm  layui-btn-normal" href="{{ route('admin.classroom.add') }}">添 加</a>
        </div>
        @endcan
        <div class="layui-row layui-col-space15" style="padding: 10px 0px;">
            @foreach($classroom as $item)
            <div class="layui-col-md6">
                <div class="layui-row layui-table-cell" style="background-color: #dddddd;height: 38px;line-height: 38px;">
                    <div class="layui-form-label" style="text-align: left">{{$item['name']}}</div>
                    @can('classroom.del')
                        <a class="layui-btn layui-btn-sm layui-btn-danger del" data="{{$item['id']}}" layui-filter="del" style="float: right;margin-top: 5px;">删除</a>
                    @endcan
                    @can('classroom.edit')
                    <a class="layui-btn layui-btn-sm" href="{{route('admin.classroom.edit',['id'=>$item['id']])}}" style="float: right;margin-top: 5px;">编辑</a>
                    @endcan
                </div>
                <div class="layui-form layui-card-header layuiadmin-card-header-auto">
                    <div class="layui-input-inline">
                        <select name="year{{$item['id']}}" id="year{{$item['id']}}" lay-filter="year{{$item['id']}}">
                            @for($i=$year-5;$i<=$year+5;$i++)
                                <option value="{{$i}}" @if($i==$year) selected @endif>{{$i}}年</option>
                            @endfor
                        </select>
                    </div>
                    <div class="layui-input-inline">
                        <select name="month{{$item['id']}}" id="month{{$item['id']}}" lay-filter="month{{$item['id']}}">
                            @for($i=1;$i<=12;$i++)
                                <option value="{{$i}}" @if($i==$month) selected @endif>{{$i}}月</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <table id="dataTable{{$item['id']}}" lay-filter="dataTable{{$item['id']}}"></table>
            </div>
            @endforeach
        </div>
    </div>
@endsection
@section('script')
    <script>
        layui.use(['layer','table','form'],function () {
            var layer = layui.layer;
            var form = layui.form;
            var table = layui.table;
            @foreach($classroom as $item)
            var dataTable{{$item['id']}} = table.render({
                    elem: '#dataTable{{$item['id']}}'
                    ,height: 370
                    ,url: "{{ route('admin.classroom.data',['id'=>$item['id']])}}" //数据接口
                    ,page: true //开启分页
                    ,limit:10
                    ,page: true //开启分页
                    ,cols: [[ //表头
                        {field: 'teacher_name', title: '教师',templet: "#teacher_name{{$item['id']}}"}
                        ,{field: 'week', title: '星期'}
                        ,{field: 'time', title: '时间',width:115}
                        ,{field: 'course_name', title: '班级',width:135,templet:"#course_name{{$item['id']}}"}
                        ,{field: 'course_amount', title: '已有学员',width:70}
                        ,{field: 'course_count', title: '班级容量',width:70}
                    ]]
            });
            form.on("select(year{{$item['id']}})", function (data) {
                var year = data.value;
                var month = $("#month{{$item['id']}}").val();
                dataTable{{$item['id']}}.reload({
                    where:{year:year,month:month},
                    page:{curr:1}
                })
            });
            form.on("select(month{{$item['id']}})", function (data) {
                var month = data.value;
                var year = $("#year{{$item['id']}}").val();
                dataTable{{$item['id']}}.reload({
                    where:{year:year,month:month},
                    page:{curr:1}
                })
            });
            @endforeach

            $(".del").click(function () {
                var id = $(this).attr('data');
                layer.confirm('确认删除教室?', {icon: 3, title:'提示'}, function(index){
                    location.href = '/admin/classroom/'+id+'/del';
                    layer.close(index);
                });
            });
        });
    </script>
    @foreach($classroom as $item)
        <script type="text/html" id="teacher_name{{$item['id']}}">
            <a href="/admin/classroom/@{{d.id}}/show" style="color:#3c8dbc" title="点击查看">@{{d.teacher_name}}</a>
        </script>
        <script type="text/html" id="course_name{{$item['id']}}">
            <a href="/admin/course/@{{d.course_id}}/show?from=classroom" style="color:#3c8dbc" title="点击查看">@{{d.course_name}}</a>
        </script>
    @endforeach
@endsection



