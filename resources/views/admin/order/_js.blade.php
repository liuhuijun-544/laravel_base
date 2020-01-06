<style>
    #layui-upload-box li{
        width: 120px;
        height: 100px;
        float: left;
        position: relative;
        overflow: hidden;
        margin-right: 10px;
        border:1px solid #ddd;
    }
    #layui-upload-box li img{
        width: 100%;
    }
    #layui-upload-box li p{
        width: 100%; 
        height: 22px;
        font-size: 12px;
        position: absolute;  
        left: 0;
        bottom: 0;
        line-height: 22px;
        text-align: center;
        color: #fff;
        background-color: #333;
        opacity: 0.6;
    }
    #layui-upload-box li i{
        display: block;
        width: 20px;
        height:20px;
        position: absolute;
        text-align: center;
        top: 2px;
        right:2px;
        z-index:999;
        cursor: pointer;
    }
    .layui-form-label{
        width: 95px;
    }
    .layui-input-block{
        margin-left: 125px;
    }
</style>
<script>
    layui.use('laydate',function(){
        var laydate = layui.laydate;
        //执行一个laydate实例
        laydate.render({
            elem: '#starttime',
            type: 'datetime',
            format: 'yyyy-MM-dd HH:mm',
            trigger: 'click'
        })

        laydate.render({
            elem: '#endtime',
            type: 'datetime',
            format: 'yyyy-MM-dd HH:mm',
            trigger: 'click'
        })

        laydate.render({
            elem: '#order_at',
            type: 'datetime',
            format: 'yyyy-MM-dd HH:mm',
            trigger: 'click'
        })
    });

    layui.use('form', function(){
        var form = layui.form;
          //监听提交
        form.on('submit(formDemo)', function(data){
            $('button').addClass("layui-btn-disabled");
            $('button').attr("disabled",'disabled');
            $('form').submit();
            return false;
        });

        var form = layui.form;
        // 根据省获取市

    });

  
</script>