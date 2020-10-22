{include file="public/header" /}
<div class="layui-body">
    <div class="layui-main">
    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 30px;">
        <legend>周报查询</legend>
    </fieldset>
    <form class="layui-form" action="" id="formid"  style="margin-top: 20px;">


        <div class="layui-form-item">
            <label class="layui-form-label">时间范围</label>
            <div class="layui-input-inline">
                <input type="text"  id="time_code"  name="time_code" value=""  placeholder="请选择" class="layui-input">
            </div>
            <div class="layui-inline layui-word-aux">周一起始，周日结束</div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">职位成员</label>
            <div class="layui-input-inline">
                <input type="radio" name="is_member" value="1" title="显示">
                <input type="radio" name="is_member" value="-1" title="不显示" checked>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">是否联代</label>
            <div class="layui-input-inline">
                <input type="radio" name="is_agent" value="1" title="是">
                <input type="radio" name="is_agent" value="-1" title="否" checked>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">公司名称</label>
            <div class="layui-input-inline">
                <input type="radio" name="type" value="all" title="所有公司"  checked="checked">
                <input type="radio" name="type" value="shilian" title="世联">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-inline" style="text-align:right;">
                <button type="submit" class="layui-btn" lay-submit="" lay-filter="demo1">查询</button>
            </div>
        </div>
    </form>
        <table class="layui-hide"  lay-filter="test" id="test"></table>
    </div>
</div>
<script src="/public/layui/layui.js" charset="utf-8"></script>
<script>

        var callbackdata;
        layui.use(['layer','table', 'form','element','laydate','jquery'], function(){
            var table = layui.table
                ,layer = layui.layer
                ,$=layui.jquery
                ,form = layui.form
                ,laydate = layui.laydate;
            laydate.render({
                elem: '#time_code'
                ,range: true
            });
            form.on('submit(demo1)', function(data){
                var time_code=$('#time_code').val();
                var is_member=$('input[name="is_member"]:checked').val();
                var type=$('input[name="type"]:checked').val();
                var is_agent=$('input[name="is_agent"]:checked').val();
                if(time_code==''){
                    layer.msg('请选择时间',{icon:0,time:500});
                    return false;
                }
                table.render({
                    id: 'test'
                    ,toolbar: true
                    ,elem: '#test'
                    , url: 'weeksearch?search=1'
                    ,method:'post'
                    ,where: {time_code: time_code, type: type,is_member:is_member,is_agent:is_agent}
                    , page: { //支持传入 laypage 组件的所有参数（某些参数除外，如：jump/elem） - 详见文档
                        layout: ['limit', 'count', 'prev', 'page', 'next', 'skip'] //自定义分页布局
                        //,curr: 5 //设定初始在第 5 页
                        , limit: 25 //一页显示多少条
                        , limits: [25, 50, 100, 999999]//每页条数的选择项
                        , groups: 2 //只显示 2 个连续页码
                        , first: "首页" //不显示首页
                        , last: "尾页" //不显示尾页
                    }
                    , cols: [[
                        {type: 'numbers', width: '5%', title: '编号'}
                        ,{field:'title', width:150,align:'center', sort: true,  title: '周报标题'}
                        ,{field:'framework',width:150,align:'center', title: '部门'}
                        ,{field:'name',  width:150, align:'center',  title: '项目名称'}
                        ,{field:'company',  width:150, align:'center',  title: '公司名称'}
                        ,{field:'comecall', width:150, align:'center',  title: '来电'}
                        ,{field:'comevisit',width:150, align:'center',  title: '来访'}
                        ,{field:'weektao',width:180, align:'center', title: '周认购总套数'}
                        ,{field:'mainhouse',width:180, align:'center', title: '周认购总金额(万)'}
                        ,{field:'weekjine',width:180, align:'center',title:'周成交主房套数'}
                        ,{field:'monthtao', width:180,align:'center',title:'月认购套数'}
                        ,{field:'monthjine',width:180, align:'center',title:'月认购金额(万）'}
                        ,{field:'yearjine', width:180,align:'center',title:'年认购金额(万）'}
                        ,{field:'remark',width:180, align:'center',title:'备注'}
                    ]]
                });
                return false;
            });

        })

</script>
{include file="public/footer" /}