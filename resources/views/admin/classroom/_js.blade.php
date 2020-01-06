<style>

</style>
<script>

    var count_detail = $('#count_detail').val();

    layui.use('form', function(){
        var form = layui.form;
          //监听提交
        form.on('submit(formDemo)', function(data){
            $('button').addClass("layui-btn-disabled");
            $('button').attr("disabled",'disabled');
            $('form').submit();
            return false;
        });

        $(".detail-add").click(function () {
            count_detail ++;
            $.get("{{route('admin.classroom.detail_add')}}",{count_detail:count_detail},function (res) {
                $('.detail-add').parent().parent().append(res);
                form.render('select');
            });
        });

        $(document).on("click",".detail_del",function(){
            $(this).parent().remove();
        })
    });

</script>