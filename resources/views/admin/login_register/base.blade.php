


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>登入 - 瓦力工厂后台管理系统</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="/static/admin/layuiadmin/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="/static/admin/layuiadmin/style/admin.css" media="all">
    <link rel="stylesheet" href="/static/admin/layuiadmin/style/login.css" media="all">
    <script>
        //在iframe中
        if (self != top) {
            parent.location.reload();
        }
    </script>
</head>
<body>

<div class="layadmin-user-login layadmin-user-display-show" >

    <div class="layadmin-user-login-main">
        <div class="layadmin-user-login-box layadmin-user-login-header">
            <h2>瓦力工厂</h2>
            <p>后台管理系统</p>
        </div>
        @yield('content')
    </div>

    <div class="layui-trans layadmin-user-login-footer">

        <p>© 2018 <a href="#" target="_blank">瓦力工厂</a></p>
        {{--<p>--}}
        {{--<span><a href="http://www.layui.com/admin/#get" target="_blank">获取授权</a></span>--}}
        {{--<span><a href="http://www.layui.com/admin/pro/" target="_blank">在线演示</a></span>--}}
        {{--<span><a href="http://www.layui.com/admin/" target="_blank">前往官网</a></span>--}}
        {{--</p>--}}
    </div>
</div>

<script src="/static/admin/layuiadmin/layui/layui.js"></script>
<script>
    layui.config({
        base: '/static/admin/layuiadmin/' //静态资源所在路径
    }).use(['layer','form','jquery'],function () {
        var layer = layui.layer;
        var form = layui.form;
        var $ = layui.jquery;

        //表单提示信息
        @if(count($errors)>0)
        @foreach($errors->all() as $error)
        layer.msg("{{$error}}",{icon:5});
        @break
        @endforeach
        @endif

        //正确提示
        @if(session('success'))
        layer.msg("{{session('success')}}",{icon:6});
        @endif

        form.on('checkbox(remember)',function (data) {
            //var remember = data.elem.checked; //是否被选中，true或者false
        });

        //【查】：读取全部的数据
        var loginuser = layui.data('loginuser');
        var username = loginuser.username;
        if(username){
            form.val("login-form", {
                "username": username // "name": "value"
                ,"remember": true
            });
        }

        form.on('submit(login)', function(data){
            //console.log(data.field); //当前容器的全部表单字段，名值对形式：{name: value}
            var username = data.field.username;
            if(data.field.remember == 'on') {
                //【增】：向user表插入一个username字段，如果该表不存在，则自动建立。
                layui.data('loginuser', {
                    key: 'username', value: username
                });
            }else{
                //【删】：删除user表的username字段
                layui.data('loginuser', {
                    key: 'username',remove: true
                });
            }
            //return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
        });

        //信息提示
        @if(session('auto'))
        layer.open({
            type: 1
            ,title:'你已安全退出系统'
            ,offset: '10px' //具体配置参考：http://www.layui.com/doc/modules/layer.html#offset
            ,id: 'layerDemo' //防止重复弹出
            ,content: ''
            ,btn: false
            ,btnAlign: 'c' //按钮居中
            ,shade: 0 //不显示遮罩
        });
        @endif

        @if($auto)
        layer.open({
            type: 1
            ,title:'你已安全退出系统'
            ,offset: '10px' //具体配置参考：http://www.layui.com/doc/modules/layer.html#offset
            ,id: 'layerDemo' //防止重复弹出
            ,content: ''
            ,btn: false
            ,btnAlign: 'c' //按钮居中
            ,shade: 0 //不显示遮罩
        });
    @endif

    })
</script>
</body>
</html>