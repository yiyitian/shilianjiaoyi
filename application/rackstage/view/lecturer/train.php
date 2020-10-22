{include file="public/header" /}
<link rel="stylesheet" href="/public/layui/formSelects-v4.css"  media="all">
<style>
 #user {
    display:none;
 }
 #partment{
    display:none;
 }
</style>
<div class="layui-body">
    <div class="layui-main">
    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 30px;">
        <legend>培训查询</legend>
    </fieldset>
    <form class="layui-form" action="" id="formid"  style="margin-top: 20px;">

    <div class="layui-form-item">
            <label class="layui-form-label">查询类型</label>
            <div class="layui-input-inline">
                <select name="chaxun" id="chaxun" lay-filter="chaxun">
                                    <option value="0" >请选择</option>

                    <option value="1" >部门查询</option>
                    <option value="2"  >个人查询</option>    
                </select>
            </div>
        </div>
        <div class="layui-form-item" id="user">
           <label class="layui-form-label">请选择用户</label>
              <div class="layui-input-inline">
                <select name="userId" lay-verify="required" lay-search="" id="userId">
                  <option value="">姓名单独查询，不可和岗位一起查询</option>

                  {volist  name="userinfo" id="vo"}
                  <option value="{$vo.id}">{$vo.work_id} -- {$vo.username}</option>
                  {/volist}
                 
                </select>
              </div>
        </div>
        <div id='partment'>
            <div class="layui-form-item" >
                <label class="layui-form-label">培训时间</label>

                <div class="layui-input-inline" style="width:150px;">
                    <input style="" type="text" id="start_time" lay-verify="required" value="" placeholder="请选择开始日期" autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid">~</div>
                <div class="layui-input-inline" style="width:150px;">
                    <input type="text" id="end_time" lay-verify="required" value="" placeholder="请选择结束日期" autocomplete="off" class="layui-input">
                </div>
                <div class="layui-inline layui-word-aux">请选择员工入职时间范围</div>
            </div>
            <div class="layui-form-item" >
                <label class="layui-form-label">选择部门</label>
                <div class="layui-input-inline">
                    <select name="department" xm-select="select7_0" xm-select-skin="danger" xm-select-search="">
                        {volist name="framework_pid" id="vo_pid"}
                        <optgroup label="{$vo_pid.name}">
                            {volist name="framework" id="vo"}
                            {if condition="$vo.pid eq $vo_pid.id"}
                            <option value="{$vo.id}" {range name="vo.id" value="$list.department|default='0'" type="in"}selected{/range}>{$vo.name}</option>
                            {/if}
                            {/volist}
                        </optgroup>
                        {/volist}

                    </select>
                </div>
            </div>
        </div>
      
        <div class="layui-form-item">
            <div class="layui-input-block" style='margin-left:140px;'>
                <span class="layui-btn" id="statistics" >查询</span>
            </div>
        </div>

    </form>
        <table class="layui-hide"  lay-filter="test" id="test"></table>
    </div>
</div>
<script src="/public/layui/layui.js" charset="utf-8"></script>
<script src="/public/layui/formSelects-v4.js" charset="utf-8"></script>
<!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->
<script>
    //全局定义一次, 加载formSelects
    layui.config({
        base: './' //此处路径请自行处理, 可以使用绝对路径
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

           

          form.on('select(chaxun)', function(data){
                if(data.value==2)
                {
                    $("#partment").attr("style","display:none;");
                    $("#user").attr("style","display:block;");
                }else
                {
                    $("#user").attr("style","display:none;");
                    $("#partment").attr("style","display:block;");
                }
            });

          
            //监听select end
            //触发搜索
            $(document).on('click','#statistics',function(){
                var type =$("#chaxun option:selected").val(),
                    uid = $("#userId option:selected").val(),
                    start_time=$('#start_time').val(),
                    end_time=$('#end_time').val(),
                    department=layui.formSelects.value('select7_0', 'valStr');
                    if(type == 2)
                    {
                    
                         if(uid == '')
                         {
                            layer.msg('姓名不能为空',{icon:0});
                            return false;
                         }
                         
                        
                    }else{
                         if(start_time == ''){
                            layer.msg('开始时间不能为空',{icon:0});
                            return false;
                         }
                         if(end_time == ''){
                            layer.msg('结束时间不能为空',{icon:0});
                            return false;
                         }
                         if(department == ''){
                            layer.msg('部门不能为空',{icon:0});
                            return false;
                         }
                    }

                table.render({
                    id: 'test'
                    ,toolbar: true
                    ,elem: '#test'
                    , url: 'Train'
                    ,method:'post'
                    ,where: {
                        department: department,
                        uid:uid,
                        start_time:start_time,
                        end_time:end_time,
                        type:type
                    }
                   
                    , cols: [[
                        {type:'numbers', minWidth: 20, title: '编号'}
                        ,{field:'region', align:'center',  title: '组织地区'}
                        ,{field:'headmaster', align:'center',title:'班主任'}
                        ,{field:'username',  align:'center',  title: '姓名'}
                        ,{field:'department', align:'center',  title: '部门'}
                        ,{field:'station', align:'center',  title: '岗位'}
                        ,{field:'projectname', align:'center',  title: '项目名称'}
                        ,{field:'dates', align:'center',title:'培训时间'}
                        ,{field:'info', align:'center',title:'培训类型'}
                        ,{field:'branch', align:'center',  title: '得分'}

                    ]]
                });
            });
        })

</script>
{include file="public/footer" /}