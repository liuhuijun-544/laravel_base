@extends('admin.base')
<style type="text/css">

    .layui-card-body{
        padding-left: 10px;
        padding-top: 20px;
    }
</style>
@section('content')
<div class="layui-card">
    
    <div class="layui-card-body">
        <span>请先下载模板，按照格式填写后上传</span>
        <a href="{{route('admin.customer.exportExcel')}}" class="layui-btn layui-btn-sm">下载模板</a>
        
    </div>
    <form class="layui-form" action="" method="post" enctype="multipart/form-data" id="myform">
        <div class="layui-card-body">
                <span>导入文件</span>
                {{ csrf_field() }}
                <input type="file" name="file" value="">
                <input type="hidden" name="adminname" value="{{$adminUser['name']}}">
                <input type="hidden" name="adminid" value="{{$adminUser['id']}}">
        </div>

        <div class="layui-card-body" style="    margin-top: 13%;float: right;">
            <a href="" class="layui-btn layui-btn-sm close" style="border: 1px solid rgb(0, 146, 252);
        background: #fff;
        color: rgb(0, 146, 252);">关闭</a>
                <input type="button" name="" value="导入" class="layui-btn layui-btn-sm import" style="background: rgb(0, 146, 252);">
        </div>
        <div style="clear: both;"></div>
    </form> 
 
</div>
@endsection

@section('script')
<script type="text/javascript">
    $('.close').click(function(){
        layui.use('layer', function(){
            var layer = layui.layer;
            var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
            parent.layer.close(index); //再执行关闭   
        }); 
        
    })

    $('.import').click(function(){
        var form = new FormData(document.getElementById("myform"));
              $.ajax({
                  url: "{{route('admin.customer.import')}}",
                  method: 'POST',
                 data: form,
                 contentType: false, // 注意这里应设为false
                 processData: false,
                 cache: false,
                 success: function(data) {
                    
                    layer.alert(data, {
                        skin: 'layui-layer-molv' //样式类名  自定义样式
                        ,closeBtn: 1    // 是否显示关闭按钮
                        ,title:'提示'
                     
                    });   
                   
                 },
                 error: function (jqXHR) {
                     // console.log(JSON.stringify(jqXHR));

                 }
             })
    })

</script>
@endsection
