<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>layuiAdmin 控制台主页一</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="/static/admin/layuiadmin/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="/static/admin/layuiadmin/style/admin.css" media="all">
    <style type="text/css">
        a.text-blue{
            text-decoration: underline;
        }

        .text-blue{
            color: #1E9FFF;
        }

        .text-red {
            color: #FF5722;
        }

        .text-green {
            color: #5FB878;
        }

        .text-purple {
            color: #3A55B1;
        }

        .text-yellow {
            color: #FF9629;
        }

        .text-brown {
            color: #969696;
        }

        .text-gray {
            color: #CBCBCB;
        }
    </style>
</head>
<body>

<div class="layui-fluid">
    @yield('content')
</div>

<script src="/js/jquery.min.js"></script>
<!-- <script src="/js/socket.io.js"></script> -->
<script src="/static/admin/layuiadmin/layui/layui.js"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    layui.config({
        base: '/static/admin/layuiadmin/' //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
    }).use(['element','form','layer','table','upload','laydate'],function () {
        var element = layui.element;
        var layer = layui.layer;
        var form = layui.form;
        var table = layui.table;
        var upload = layui.upload;
        var laydate = layui.laydate;

        //监听排序事件
        table.on('sort(dataTable)', function(obj){ //注：tool是工具条事件名，test是table原始容器的属性 lay-filter="对应的值"
            // console.log(obj.field); //当前排序的字段名
            // console.log(obj.type); //当前排序类型：desc（降序）、asc（升序）、null（空对象，默认排序）
            // console.log(this); //当前排序的 th 对象
            table.reload('dataTable', {
                initSort: obj //记录初始排序，如果不设的话，将无法标记表头的排序状态。
                ,where: {
                    order_field: obj.field //排序字段
                    ,order_type: obj.type //排序方式
                }
            });
        });

        //错误提示
        @if(count($errors)>0)
            @foreach($errors->all() as $error)
                layer.msg("{{$error}}",{icon:5});
                @break
            @endforeach
        @endif

        //信息提示
        @if(session('status'))
            layer.msg("{{session('status')}}",{icon:6});
        @endif

        //监听消息推送
        // $(document).ready(function () {
        //     // 连接服务端
        //     var socket = io("{{config('custom.PUSH_MESSAGE_LOGIN')}}");
        //     // 连接后登录
        //     socket.on('connect', function () {
        //         socket.emit('login', "{{auth()->user()->uuid}}");
        //     });
        //     // 后端推送来消息时
        //     socket.on('new_msg', function (title, content) {
        //         //弹框提示
        //         layer.open({
        //             title: title,
        //             content: content,
        //             offset: 'rb',
        //             anim: 1,
        //             time: 5000
        //         })
        //     });
        // });

        //长时间未操作退出登录
        $('body').on('keydown mousemove mousedown mousewheel click', function(e) {
            window.parent.time = window.parent.maxTime; // reset
        });
        /*var intervalId = setInterval(function() {
            window.parent.time--;
            if (window.parent.time <= 0) {
                clearInterval(intervalId);
            }
        }, 1000)*/
    });
    //禁止连续提交
    layui.use('form', function(){
        var form = layui.form;
        //监听提交
        form.on('submit(formDemo)', function(data){
            $('button').addClass("layui-btn-disabled");//改成禁止点击样式
            $('button').attr("disabled",'disabled');//禁止按钮点击

            $('form').submit();
            return false;
        });

    });
    @if(!\Auth::user()->can('generalPermissions.copy'))
    {
        document.body.oncopy = function(e)
        {
            // alert('无复制权限');return false;
        }
    }@endif
</script>
@yield('script')
</body>
</html>



