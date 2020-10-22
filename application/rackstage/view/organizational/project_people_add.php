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
</style>
<body>
<form class="layui-form" action="" id="formid"  style="margin-top: 20px;">

  

    <div class="layui-form-item">
        <label class="layui-form-label">请选择员工</label>
        <div class="layui-input-inline">
            <select name="uid" lay-verify="required" lay-search="">
                <option value="">直接选择或搜索选择</option>
                {volist name="list" id="vo"}
                <option value="{$vo.id}" {if condition="isset($userInfo)&&($userInfo['uid'] eq $vo['id'])"} selected {/if}>{$vo.work_id}--{$vo.username}--{$vo.phone}</option>
                {/volist}
            </select>
        </div>
    </div>

  <div class="layui-form-item">
        <label class="layui-form-label">用户状态</label>
        <div class="layui-inline">
            <div class="layui-input-inline">
                 <input type="radio" name="status" <?php if(!isset($userInfo)){?> checked=""<?php }?> value="正常" title="正常" {if condition="isset($userInfo)&&($userInfo['status'] eq '正常')"} checked="" {/if}>
                 <input type="radio" name="status" value="禁用" title="禁用" {if condition="isset($userInfo)&&($userInfo['status'] eq '禁用')"} checked=""{/if}>
                 <input type="radio" name="status" value="离职" title="离职" {if condition="isset($userInfo)&&($userInfo['status'] eq '离职')"} checked=""{/if}>
            </div>
        </div>
    </div>
    {if condition="isset($types)"}

    <div class="layui-form-item">
        <label class="layui-form-label">当前项目</label>
        <div class="layui-inline">
            <div class="layui-input-inline">
                 <input type="radio" name="isHave" value="在" title="在" {if condition="isset($userInfo)&&($userInfo['isHave'] eq '在')"} checked="" {/if}  <?php if(!isset($userInfo)){?> checked=""<?php }?>>
                 <input type="radio" name="isHave" value="不在" title="不在" {if condition="isset($userInfo)&&($userInfo['isHave'] eq '不在')"} checked=""{/if}>
            </div>
        </div>
    </div>
    {/if}
    {if condition="isset($userInfo)"}
            <input type='hidden' name='id' value="{$userInfo.id}"/>
    {/if}
    <input type="hidden" name='pid' value="{$id}"/>
    <div class="layui-form-item">
        <label class="layui-form-label">入职时间</label>
        <div class="layui-inline">
            <div class="layui-input-inline">
                <input type="text" id="addtime"  name="addtime" lay-verify="required"  value="{$userInfo.addtime|default=''}" placeholder="" autocomplete="off" class="layui-input">

            </div>
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">调离时间</label>
        <div class="layui-inline">
            <div class="layui-input-inline">
                <input type="text" id="createtime"  name="stoptime" lay-verify="required"  value="{$userInfo.stoptime|default=''}" placeholder="" autocomplete="off" class="layui-input">

            </div>
        </div>
    </div>
 
</form>
<script src="/public/layui/layui.js" charset="utf-8"></script>
<script src="/public/kindeditor/kindeditor-all.js" charset="utf-8"></script>
<script src="/public/kindeditor/plugins/code/prettify.js" charset="utf-8"></script>
<script src="/public/jwplayer/jwplayer.js"></script>
<script>jwplayer.key="hTHv8+BvigYhzJUOpkmEGlJ7ETsKmqyrQb8/PetBTBI=";</script>
<script src="/public/layui/formSelects-v4.js" charset="utf-8"></script>
<!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->
<script>

  
    var callbackdata;
    layui.use(['layer', 'form','element','jquery','laydate'], function(){
        var layer = layui.layer
            ,$=layui.jquery
            ,form = layui.form
            ,laydate = layui.laydate;
        laydate.render({
            elem:'#createtime'
            ,btns: ['confirm']
          ,theme: 'grid'
          ,trigger: 'click'
        });

        laydate.render({
            elem:'#addtime'
            ,btns: ['confirm']
            ,theme: 'grid'
            ,trigger: 'click'
        });


        //返回值
        callbackdata=function () {

            var arr = new Array();
            $("input:checkbox[name='department']:checked").each(function(i){
                arr[i] = $(this).val();
            });
                var data =$("#formid").serialize();

                return data;

        }
        //自定义验证规则
        function verifycontent() {
            return true;
        }
    })
    

</script>
</body>
</html>