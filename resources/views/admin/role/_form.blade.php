{{csrf_field()}}
<div class="layui-form-item">
    <label for="" class="layui-form-label">名称</label>
    <div class="layui-input-block">
        <input class="layui-input" type="text" name="name" lay-verify="required" value="{{$role->name??old('name')}}" placeholder="如:admin">
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">显示名称</label>
    <div class="layui-input-block">
        <input class="layui-input" type="text" name="display_name" lay-verify="required" value="{{$role->display_name??old('display_name')}}" placeholder="如：管理员" >
    </div>
</div>
<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-filter="formDemo" lay-submit="" >确 认</button>
        <a href="{{route('admin.role')}}" class="layui-btn" >返 回</a>
    </div>
</div>

@section('script')
    <script type="text/javascript">
        layui.use(['form'],function () {
            var form = layui.form;

            // 监听提交
            var isSubmitted = false;
            form.on('submit(formDemo)', function(data){
                if(isSubmitted){
                    return false;
                }
                isSubmitted = true;
            });
        })
    </script>
@endsection
