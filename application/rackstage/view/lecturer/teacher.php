{include file="public/header" /}
<link rel="stylesheet" href="/public/layui/formSelects-v4.css"  media="all">
<script type="text/html" id="checkboxTp1">
    {{# if(d.is_teacher == -1){ }}
    不是
    {{# }else{ }}
    是
    {{#}}}

</script>
<script type="text/html" id="checkboxTp2">
    {{# if(d.is_quit == 1){ }}
    离职
    {{# }else{ }}
    在职
    {{#}}}
</script>
<script type="text/html" id="sex">
    {{# if(d.sex == 1){d.sex="男"}}
    {{d.sex}}
    {{# }else{d.sex="女"}}
    {{d.sex}}
    {{#}}}
</script>
<script type="text/html" id="marriage">
    {{# if(d.marriage == -1){d.marriage="未婚"}}
    {{d.marriage}}
    {{# }else{d.marriage="已婚"}}
    {{d.marriage}}
    {{#}}}
</script>
<div class="layui-body">
    <div class="layui-main">
        <fieldset class="layui-elem-field layui-field-title" style="margin-top: 30px;">
            <legend>绩效查询</legend>
        </fieldset>
        <form class="layui-form" action="" id="formid"  style="margin-top: 20px;">


            <div class="layui-form-item" >
                <label class="layui-form-label">开课时间</label>
                <div class="layui-input-inline" style="width:150px;">
                    <input style="" type="text" id="start_time" lay-verify="required" value="" placeholder="请选择开始日期" autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid">~</div>
                <div class="layui-input-inline" style="width:150px;">
                    <input type="text" id="end_time" lay-verify="required" value="" placeholder="请选择结束日期" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">选择用户</label>
                <div class="layui-input-inline" style="width:328px;">
                    <select name="department" xm-select="select7_3" xm-select-skin="danger" xm-select-search=""xm-select-show-count="1">
                        {volist name="teacher" id="vo"}
                        <option value="{$vo.userid}" >{$vo.username}</option>
                        {/volist}
                    </select>
                </div>
            </div>

            <div class="layui-form-item">
                <div class="layui-input-block">
                    <span class="layui-btn" id="statistics" >查询</span>
                </div>
            </div>
        </form>
        <table class="layui-hide"  lay-filter="test" id="test"></table>
    </div>
</div>
<script src="/public/layui/layui.js" charset="utf-8"></script>
<script src="/public/layui/formSelects-v4.js" charset="utf-8"></script>
<script>
    layui.config({
        base: './'
    }).extend({
        formSelects: 'formSelects-v4'
    });

    var callbackdata;
    layui.use(['layer','table', 'form','element','laydate','jquery'], function(){
        var table = layui.table
            ,layer = layui.layer
            ,$=layui.jquery
            ,form = layui.form
            ,laydate = layui.laydate;
        laydate.render({
            elem: '#start_time'
            ,type: 'datetime'
        });
        laydate.render({
            elem: '#end_time'
            ,type: 'datetime'
        });
        $(document).on('click','#statistics',function(){
            //部门和岗位不能为空，课程二级分类不能为空
            var username =layui.formSelects.value('select7_3', 'valStr'),//岗位
                start_time=$('#start_time').val(),
                end_time=$('#end_time').val();

            if(start_time == ''){
                layer.msg('开始时间不能为空',{icon:0});
                return false;
            }
            if(end_time == ''){
                layer.msg('结束时间不能为空',{icon:0});
                return false;
            }
            var time_code=start_time+' - '+end_time;

            table.render({
                id: 'test'
                ,toolbar: true
                ,elem: '#test'
                , url: 'teacher'
                ,method:'post'
                ,totalRow: true
                ,where: {
                    time_code: time_code,
                    username:username,
                }

                , cols: [[
                    {type:'numbers', minWidth: 20, title: '编号'}
                    ,{field:'region_title',  align:'center',  title: '地区'}
                    ,{field:'headmaster',  align:'center',  title: '班主任'}
                    ,{field:'classify_title', align:'center',  title: '培训类型'}
                    ,{field:'startdate', align:'center',  title: '培训日期'}
                    ,{field:'username', align:'center',  title: '参训名单'}
                    ,{field:'department_title', align:'center', title: '部门'}
                    ,{field:'station_title', align:'center', title: '岗位'}
                    ,{field:'project_title', align:'center',  title: '项目名称'}
                    ,{field:'branch', align:'center',  title: '考试成绩'}
                    ,{field:'money', align:'center',  title: '绩效', totalRow: true}
                ]]
            });
        });
    })

</script>
{include file="public/footer" /}