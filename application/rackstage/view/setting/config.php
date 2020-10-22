{include file="public/header" /}
<style>
    .layui-upload-img {
        width: 92px;
        height: 92px;
        margin: 0 10px 10px 0;
    }
</style>
<body>
<style type="text/css">


</style>
<div class="layui-body">
<form class="layui-form" method="post" style="margin-top:15px;" id="formid">
    <div class="layui-form-item">
        <label class="layui-form-label">开放时间</label>
        <div class="layui-input-inline">
            <input type="text" id="test6" name="open_time" lay-verify="required" value="{:sysconf('open_time')}"
                   placeholder="请输入开放时间" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">置业认购数</label>
        <div class="layui-input-inline">
            <input type="text" id="employee_min" name="employee_min" lay-verify="required"
                   value="{:sysconf('employee_min')}"
                   placeholder="请输入置业顾问认购数目" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">商办来访数</label>
        <div class="layui-input-inline">
            <input type="text" id="business_visiting" name="business_visiting" lay-verify="required"
                   value="{:sysconf('business_visiting')}"
                   placeholder="请输入商办来访数" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">普通来访数</label>
        <div class="layui-input-inline">
            <input type="text" id="primary_visiting" name="primary_visiting" lay-verify="required"
                   value="{:sysconf('primary_visiting')}"
                   placeholder="请输入上班来访数" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">认购完成</label>
        <div class="layui-input-inline">
            <input type="text" id="subscribe_complete" name="subscribe_complete" lay-verify="required"
                   value="{:sysconf('subscribe_complete')}"
                   placeholder="请输入认购完成率" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">姓名分隔符</label>
        <div class="layui-input-inline">
            <input type="text" id="subscribe_complete" name="username_break" lay-verify="required"
                   value="{:sysconf('username_break')}"
                   placeholder="请输入认购完成率" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item layui-form-text">
        <div class="layui-input-block">
            <button type="button" class="layui-btn" lay-filter="demo1" id="submit">立即提交</button>
        </div>

    </div>
    <div class="layui-form-item layui-form-text">
        <div class="layui-input-block">
            <button type="button" class="layui-btn layui-btn-normal" id="test5"><i class="layui-icon"></i>上传业绩</button>
            <button type="button" class="layui-btn layui-btn-normal" id="test1"><i class="layui-icon"></i>上传erp来访</button>
            <button type="button" class="layui-btn layui-btn-normal" id="test2"><i class="layui-icon"></i>上传erp成交</button>
        </div>

    </div>

</form>
    </div>
<script src="/public/layui/layui.js" charset="utf-8"></script>
<script src="/public/layui/layui-xtree.js" charset="utf-8"></script>
<!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->
<script>

    var callbackdata;
    layui.use(['layer', 'form', 'element', 'jquery', 'laydate', 'upload'], function () {
        var layer = layui.layer
            , $ = layui.jquery
            , laydate = layui.laydate
            , upload = layui.upload
            , form = layui.form;
        laydate.render({
            elem: '#test6'
            , range: true
        });
        //上传业绩台账
        upload.render({ //允许上传的文件后缀
            elem: '#test5'
            , url: '/rackstage/Employee/upload?type=3' //改成您自己的上传接口
            , accept: 'file' //普通文件
            , exts: 'xls|csv|xlsx' //只允许上传压缩文件
            , done: function (res) {
                layer.msg('上传成功');
                console.log(res)
            }
        });
        upload.render({ //允许上传的文件后缀
            elem: '#test1'
            , url: '/rackstage/Employee/upload?type=4' //改成您自己的上传接口
            , accept: 'file' //普通文件
            , exts: 'xls|csv|xlsx' //只允许上传压缩文件
            , done: function (res) {
                layer.msg('上传成功');
                console.log(res)
            }
        });
        upload.render({ //允许上传的文件后缀
            elem: '#test2'
            , url: '/rackstage/Employee/upload?type=5' //改成您自己的上传接口
            , accept: 'file' //普通文件
            , exts: 'xls|csv|xlsx' //只允许上传压缩文件
            , done: function (res) {
                layer.msg('上传成功');
                console.log(res)
            }
        });
        //自定义验证规则
        function verifycontent() {
            if ($('#contract_num').val() == "") {
                layer.alert('合同编号不能为空');
                return false;
            }
            ;
            if ($('#contract_holder').val() == "") {
                layer.alert('合同人不能为空');
                return false;
            }
            ;
            if ($('#src_img').val() == "") {
                layer.alert('电子合同不能为空');
                return false;
            }
            ;
            if ($('#saler').val() == "") {
                layer.alert('销售人员不能为空');
                return false;
            }
            ;
            return true;

        }

        $("#submit").click(function () {
            var data = $("#formid").serializeArray();
            $.ajax({
                url: "config",
                data: data,
                type: "post",
                dataType: 'json',
                success: function (data) {

                    layer.msg(data.msg, {time: 1000}, function () {
                        window.location.reload();
                    });
                }
            })
        });

    })


    layui.use(['form'], function () {
        var form = layui.form;

    });

</script>
{include file="public/footer" /}