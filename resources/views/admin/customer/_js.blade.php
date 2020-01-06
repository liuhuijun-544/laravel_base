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
            elem: '#child_birthday', //指定元素
            trigger: 'click'
        })

        laydate.render({
            elem: '#collect_at', //指定元素
            trigger: 'click'
        })

        laydate.render({
            elem: '#visit_at', //指定元素
            trigger: 'click'
        })

        laydate.render({
            elem: '#visit_at_2', //指定元素
            trigger: 'click'
        })

        laydate.render({
            elem: '#arrive_at', //指定元素
            type: 'datetime',
            format:'yyyy-MM-dd HH:mm',
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
        form.on('select(channel)', function (data) {
            var channel = data.value; //得到被选中的值
            $.get("{{ route('admin.customer.getChannelDetail') }}", {'channel':channel}, function (result) {
                if (result.code == 0) {
                    var selected = result.data.length == 1 ? 'selected' : '';
                    var html = '<option value=""></option>';
                    layui.each(result.data, function (index, item) {
                        html += '<option ' + selected + ' value="' + item +'">' + item + '</option>';
                    });

                    $("select[name='channel_detail']").html(html);
                    form.render('select'); //刷新select选择框渲染
                }
            });
        });
        var click = 0;
        $("#turn_on").click(function () {
            var customer_id = $(this).attr('data-id');
            var status = $(this).attr('data-status');
            if (click==1){
                return false;
            }
            click = 1;
            $.get("{{route('admin.customer.turn')}}",{'id':customer_id,'status':status},function (res) {
                click = 0;
                if (res.code==0){
                    alert('修改成功');
                    location.reload();
                }else{
                    alert(res.msg);
                }
            });
        });
        //转成学员
        $("#turn_student").click(function () {
            var customer_id = $(this).attr('data-id');
            if (click==1){
                return false;
            }
            $.get("{{route('admin.customer.turn_student')}}",{'id':customer_id},function (res) {
                click = 0;
                if (res.code==0){
                    alert('修改成功');
                    location.reload();
                }else{
                    alert(res.msg);
                }
            });
        });
    });

  
</script>