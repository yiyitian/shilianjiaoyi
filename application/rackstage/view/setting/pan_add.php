<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>layui</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="/public/layui/css/layui.css"  media="all">
    <link rel="stylesheet" href="/public/layui/formSelects-v4.css"  media="all">
    <!-- 注意：如果你直接复制所有代码到本地，上述css路径需要改成你本地的 -->
</head>
<style>
    .layui-upload-img{width: 92px;  height: 92px;  margin: 0 10px 10px 0; }
    .search
    {
        left: 0;
        position: relative;
    }
    #auto_div
    {
        display: none;
        width: 300px;
        border: 1px #74c0f9 solid;
        background: #FFF;
        position: absolute;
        top: 40px;
        left: 0;
        color: #323232;
        z-index:999;
    }

</style>
<body>


<form class="layui-form" action="" id="formid" style="margin-top: 20px;">
    <div class="layui-form-item">
        <label class="layui-form-label">文件夹名称</label>
        <div class="layui-input-inline">
            <input type="text" id="files" name="files" value="{$list.files|default=''}" placeholder="请输入文件夹名称"  autocomplete="off" class="layui-input">
        </div>
        
    </div>
    {notempty name="$list"}
		<input type="hidden" id="id" name="id" value="{$id}" />
    {/notempty}
    
    <div class="layui-form-item">
        <label class="layui-form-label">查阅权限</label>
        <div class="layui-input-block">
            <div id="xtree3" class="xtree_contianer " style="padding-left:20px;"></div>
        </div>
    </div>

    <div class="layui-form-item layui-form-text">
        <label class="layui-form-label">备注</label>
        <div class="layui-input-block">
            <textarea placeholder="请输入备注" class="layui-textarea" name="content" style="width:80%">{$list.content|default=''}</textarea>
        </div>
    </div>
        <input type="hidden" name="role" value="" id="department"/>

</form>
<script src="/public/layui/layui.js" charset="utf-8"></script>
<!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->
<script src="/public/layui/layui-xtree.js" charset="utf-8"></script>
<!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->
<script>
    //全局定义一次, 加载formSelects

    var callbackdata;
    layui.use(['layer', 'form','element','jquery','laydate'], function(){
        var layer = layui.layer
            ,$=layui.jquery
            ,form = layui.form
			,laydate=layui.laydate
		laydate.render({
			elem:"#birthday",
		})
		laydate.render({
			elem:"#start_time",
		})

        var xtree3 = new layuiXtree({
            elem: 'xtree3'
            , form: form
            , data: 'getDepartments?id='+{$id}
            , isopen: true
            , ckall: true
            , ckallback: function () { } //全选框状态改变后执行的回调函数
            , icon: {
                open: "&#xe7a0;"
                , close: "&#xe622;"
                , end: "&#xe621;"
            }
            , color: {
                open: "#EE9A00"
                , close: "#EEC591"
                , end: "#828282"
            }
            , click: function (data) {
                console.log(data.elem);

            }
        });

		
        //返回值
        callbackdata=function () {
            if(!verifycontent()){
                false;
            }else {
                var _allck = xtree3.GetAllCheckBox();
                var arr = new Array();
                var arrIndex = 0;
                for (var i = 0; i < _allck.length; i++) {
                    if (_allck[i].checked) {
                        arr[arrIndex] = _allck[i].value;

                        arrIndex++;
                    }
                }
                $('#department').val(arr.join(","));
                var data =$("#formid").serialize();
                return data;
            }
        }
        //自定义验证规则
        function verifycontent() {
            

            return true;

        }
    
    })

</script>
</body>
</html>