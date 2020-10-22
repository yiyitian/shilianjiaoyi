<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>layui</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="/public/layui/css/layui.css" media="all">
    <!-- 注意：如果你直接复制所有代码到本地，上述css路径需要改成你本地的 -->
</head>

<body>
<form class="layui-form" action="" id="formid" style="margin-top: 20px;">
    {notempty name='this_profit.id'}
    <div class="layui-form-item">
        <label class="layui-form-label">项目名称</label>
        <div class="layui-input-inline">
            <input type="text" id="name" name="project_title" lay-verify="required"
                   value="{$this_profit.project_title|default=''}"
                   placeholder="请输入项目名称" autocomplete="off" class="layui-input"}>
        </div>
        <input type="hidden" id="project" name="project_name" value="{$project_name|default=''}">
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">姓名</label>
        <div class="layui-input-inline">
            <input type="text" id="aims" name="username" lay-verify="required" value="{$this_profit.username|default=''}"
                   placeholder="请输入姓名" autocomplete="off" class="layui-input">
        </div>
    </div>
    {/notempty}
    <div class="layui-form-item">
        <label class="layui-form-label">成交额</label>
        <div class="layui-input-inline">
            <input type="number" id="aims" name="turnover" lay-verify="required" value="{$this_profit.turnover|default=''}"
                   placeholder="请输入成交额" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">平均代理费率(%)</label>
        <div class="layui-input-inline">
            <input type="number" id="aims" name="agency_rate" lay-verify="required"
                   value="{$this_profit.agency_rate|default=''}"
                   placeholder="请输入平均代理费率" autocomplete="off" class="layui-input" step="0.01">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">物业费</label>
        <div class="layui-input-inline">
            <input type="number" id="aims" name="property" lay-verify="required" value="{$this_profit.property|default=''}"
                   placeholder="请输入物业费" autocomplete="off" class="layui-input" step="0.01">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">保证金扣款比率(%)</label>
        <div class="layui-input-inline layui-cols-3">
            <input type="number" id="aims" name="margin_rate" lay-verify="required"
                   value="{$this_profit.margin_rate|default=''}"
                   placeholder="请输入保证金扣款比率" autocomplete="off" class="layui-input" step="0.01">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">人员数量</label>
        <div class="layui-input-inline">
            <input type="number" id="aims" name="number" lay-verify="required" value="{$total_number|default=''}"
                   placeholder="请输入人员数量" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">人力成本</label>
        <div class="layui-input-inline">
            <input type="number" id="aims" name="labor_costs" lay-verify="required" value="{$total_money|default=''}"
                   placeholder="请输入人力成本" autocomplete="off" class="layui-input" step="0.01">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">二次薪(补助)</label>
        <div class="layui-input-inline">
            <input type="number" id="aims" name="second_money" lay-verify="required"
                   value="{$this_profit.second_money|default=''}"
                   placeholder="请输入二次薪(补助)" autocomplete="off" class="layui-input" step="0.01">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">联代补助</label>
        <div class="layui-input-inline">
            <input type="number" id="aims" name="subsidies" lay-verify="required" value="{$this_profit.subsidies|default=''}"
                   placeholder="请输入联代补助" autocomplete="off" class="layui-input" step="0.01">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">提成比率(%)</label>
        <div class="layui-input-inline">
            <input type="number" id="aims" name="commission_ratio" lay-verify="required"
                   value="{$this_profit.commission_ratio|default=''}"
                   placeholder="请输入提成比率" autocomplete="off" class="layui-input" step="0.01">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">其他费用</label>
        <div class="layui-input-inline">
            <input type="number" id="aims" name="else" lay-verify="required"
                   value="{$this_profit.else|default=''}"
                   placeholder="请输入其他费用" autocomplete="off" class="layui-input" step="0.01">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">集团管理费率</label>
        <div class="layui-input-block">
            {eq name="this_profit.type|default=1" value="1"}
            <input type="radio" name="type" value="1" title="恒大" checked>
            <input type="radio" name="type" value="2" title="非恒大">
            {else /}
            <input type="radio" name="type" value="1" title="恒大">
            <input type="radio" name="type" value="2" title="非恒大" checked>

            {/eq}
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">税费率(%)</label>
        <div class="layui-input-inline">
            <input type="number" id="aims" name="taxes_rate" lay-verify="required"
                   value="{$this_profit.taxes_rate|default=''}"
                   placeholder="请输入税费率" autocomplete="off" class="layui-input" step="0.01">
        </div>
    </div>
    {notempty name='this_profit.id'}<input type='hidden' value='{$this_profit.id}' name='id'>
    {else /}
    {/notempty}
</form>
<script src="/public/layui/layui.js" charset="utf-8"></script>
<!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->
<script>

    var callbackdata;
    layui.use(['layer', 'form', 'element', 'jquery'], function () {
        var layer = layui.layer
            , $ = layui.jquery
            , form = layui.form;
        //两级联动选择地区和部门
       
        //返回值
        callbackdata = function () {
            if (!verifycontent()) {
                false;
            } else {
                var data = $("#formid").serialize();
                return data;
            }
        }

        //自定义验证规则
        function verifycontent() {
            if ($('#framework_id').val() == "") {
                layer.alert($('#framework_id').attr('placeholder'));
                return false;
            }
            ;
            if ($('#user_id').val() == "") {
                layer.alert($('#user_id').attr('placeholder'));
                return false;
            }
            ;
            if ($('#name').val() == "") {
                layer.alert($('#name').attr('placeholder'));
                return false;
            }
            ;
            return true;
        }
    })

</script>
</body>
</html>