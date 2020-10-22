<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>layui</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="/public/layui/css/layui.css"  media="all">
    <!-- 注意：如果你直接复制所有代码到本地，上述css路径需要改成你本地的 -->
</head>
<style>
    .layui-upload-img{width: 92px;  height: 92px;  margin: 0 10px 10px 0; }
</style>
<body>
<style type="text/css">




    .xtree_contianer {
        width: 500px;
        border: 1px solid #9C9C9C;
        overflow: auto;
        margin-bottom: 30px;
        background-color: #fff;
        padding: 10px 0 25px 5px;
    }

</style>

<form class="layui-form" style="margin-top:15px;" >
    <div class="layui-form-item">
        <label class="layui-form-label">角色名称</label>
        <div class="layui-input-inline">
            <input type="text" id="role_name" name="role_name" lay-verify="required" value="{$list.role_name|default=''}" placeholder="请输入角色名称" autocomplete="off" class="layui-input">
        </div>
    </div>
    <?php if(isset($list))echo '<input type="hidden" id="getId" name="id" value="'.$list['id'].'" />';?>
     <div class="layui-form-item">
        <label class="layui-form-label">权限管理</label>
        <div class="layui-input-block">
            <div id="xtree3" class="xtree_contianer " style="padding-left:20px;"></div>
        </div>
    </div>
    <div class="layui-form-item layui-form-text">
        <label class="layui-form-label">备注</label>
        <div class="layui-input-block">
            <textarea placeholder="请输入内容" class="layui-textarea" name="mark" style="width:80%">{$list.mark|default=''}</textarea>
        </div>
    </div>

</form>
<script src="/public/layui/layui.js" charset="utf-8"></script>
<script src="/public/layui/layui-xtree.js" charset="utf-8"></script>
<!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->
<script>

    var callbackdata;
    layui.use(['layer', 'form','element','jquery'], function(){
        var layer = layui.layer
            ,$=layui.jquery
            ,form = layui.form;
        var xtree3 = new layuiXtree({
            elem: 'xtree3'
            , form: form
            , data: 'get_cate?id='+{$id}
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
        callbackdata=function () {
            var _allck = xtree3.GetAllCheckBox();
            var arr = new Array();
            var arrIndex = 0;
            for (var i = 0; i < _allck.length; i++) {
                if (_allck[i].checked) {
                    arr[arrIndex] = _allck[i].value;

                    arrIndex++;
                }
            }
            var data  ="id="+$("#getId").val()+"&mark="+$(".layui-textarea").val()+"&role_name="+$("#role_name").val()+"&role_cate="+arr.join(",");//将数组合并成字符串
            return data;

        }


        //自定义验证规则
        function verifycontent() {
            if($('#contract_num').val()==""){ layer.alert('合同编号不能为空'); return false;};
            if($('#contract_holder').val()=="") {layer.alert('合同人不能为空');  return false;};
            if($('#src_img').val()=="") {layer.alert('电子合同不能为空');  return false;};
            if($('#saler').val()==""){ layer.alert('销售人员不能为空');  return false;};
            return true;

        }

    })

    layui.use(['form'], function () {
        var form = layui.form;

    });

</script>
</body>
</html>