
<link rel="stylesheet" href="_CSS_/layui.css">
{include file="public/header" /}

<script type="text/html" id="checkboxTpl">
    <input type="checkbox" name="status" value="{{d.status}}" title="回款" lay-filter="lockDemo" {{ d.status == 1 ? 'checked' : '' }}>
</script>
<script type="text/html" id="checkboxTp2">
    <input type="checkbox" name="is_verified" value="{{d.is_verified}}" title="通过" lay-filter="lockDemo" {{ d.is_verified == 1 ? 'checked' : '' }}>
</script>
<div class="layui-body">
    <!-- 内容主体区域 -->
    <div style="padding: 20px; background-color: #F2F2F2;text-align:left;font-size:22px;">
       欢迎登录世联怡高管理系统
    </div>
    <div style="font-size:18px;text-align:center;padding-top:20px;">岗位职责<span style="font-size:14px;color:red;">({$role_name})</span></div>
    <div style="width:80%;margin:auto;padding-top:30px;">{$content}</div>


</div>
<script src="/public/layui/layui.js"></script>

{include file="public/footer" /}