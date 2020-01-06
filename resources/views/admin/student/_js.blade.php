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
        laydate.render({
            elem: '#enter_class_date',
            trigger: 'click'
        })
        laydate.render({
            elem: '#birthday',
            trigger: 'click'
        })
    });
    layui.use('form',function () {
        var form = layui.form;
        //根据课程获取主讲老师和教务老师
        form.on('select(course_id)', function (data) {
            $.get("{{ route('admin.student.getTeacher') }}", {'course_id':data.value}, function (result) {
                if (result.code == 0) {
                    $('#lecturer').val(result.lecturer);
                    $('#teacher').val(result.teacher);
                }
            });
        });
    });
</script>