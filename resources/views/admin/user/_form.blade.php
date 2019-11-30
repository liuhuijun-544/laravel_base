{{csrf_field()}}
<input type="hidden" name="id" value="{{ $user->id }}">
<div class="layui-form-item">
    <label for="" class="layui-form-label">账户</label>
    <div class="layui-input-inline">
        <input type="text" name="usercode" value="{{$user->usercode??old('usercode')}}" lay-verify="required" placeholder="请输入账户" class="layui-input">
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">用户名</label>
    <div class="layui-input-inline">
        <input type="text" name="name" value="{{ $user->name ?? old('name') }}" lay-verify="required" placeholder="请输入用户名" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">手机号</label>
    <div class="layui-input-inline">
        <input type="number" name="mobile" value="{{$user->mobile??old('mobile')}}" lay-verify="required" placeholder="请输入手机号" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">邮箱</label>
    <div class="layui-input-inline">
        <input type="email" name="useremail" value="{{$user->useremail??old('useremail')}}" lay-verify="email" placeholder="请输入Email" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">登录密码</label>
    <div class="layui-input-inline">
        <input type="password" name="userpass" placeholder="请输入密码" class="layui-input">
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">确认密码</label>
    <div class="layui-input-inline">
        <input type="password" name="password_confirmation" placeholder="请输入密码" class="layui-input">
    </div>
</div>

<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
        <a  class="layui-btn" href="{{route('admin.user')}}" >返 回</a>
    </div>
</div>