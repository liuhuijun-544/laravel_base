@extends('admin.login_register.base')

@section('content')
    <div class="layadmin-user-login-box layadmin-user-login-body layui-form" lay-filter="login-form">
        <form action="{{route('admin.login')}}" method="post">
            {{csrf_field()}}
            <div class="layui-form-item">
                <label class="layadmin-user-login-icon layui-icon layui-icon-username" for="LAY-user-login-username"></label>
                <input type="text" name="usercode" value="{{old('usercode')}}" lay-verify="required" placeholder="用户名" class="layui-input">
            </div>
            <div class="layui-form-item">
                <label class="layadmin-user-login-icon layui-icon layui-icon-password" for="LAY-user-login-password"></label>
                <input type="password" name="password"  lay-verify="required" placeholder="密码" class="layui-input">
            </div>

            <div class="layui-form-item" style="margin-bottom: 20px;">
                <input type="checkbox" name="remember" lay-filter="remember" lay-skin="primary" title="记住用户名">
            </div>
            <div class="layui-form-item">
                <button type="submit" class="layui-btn layui-btn-fluid" lay-submit lay-filter="login">登 入</button>
            </div>
        </form>
    </div>
@endsection