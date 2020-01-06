<style type="text/css">
    .layui-input-block textarea{
        padding: 10px;
    }
</style>
{{csrf_field()}}


<div class="layui-row layui-col-space15" style="padding: 10px 0px;border-bottom: 1px solid #f6f6f6">
    <div class="layui-col-md6">
        <div class="layui-card">
            <label for="" class="layui-form-label"><span style="color: red;">*</span>教室名称</label>
            <div class="layui-input-block">
                <input type="text" name="name" value="{{$info->name??old('name')}}" lay-verify="required" placeholder="请输入教室名称" class="layui-input">
            </div>
        </div>
    </div>
</div>

<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit"   class="layui-btn" lay-submit="formDemo" lay-filter="formDemo">确 认</button>
        <a  class="layui-btn" href="{{route('admin.classroom')}}" >返 回</a>
    </div>
</div>
