{include file="public/header" /}
<link rel="stylesheet" href="/public/layui/formSelects-v4.css"  media="all">

<div class="layui-body">
    <div class="layui-main">
    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 30px;">
        <legend>统计查询</legend>
    </fieldset>
    <form class="layui-form" action="" id="formid"  style="margin-top: 20px;">


        <div class="layui-form-item" >
            <label class="layui-form-label">入职时间</label>

            <div class="layui-input-inline" style="width:150px;">
                <input style="" type="text" id="start_time" lay-verify="required" value="" placeholder="请选择开始日期" autocomplete="off" class="layui-input">
            </div>
            <div class="layui-form-mid">~</div>
            <div class="layui-input-inline" style="width:150px;">
                <input type="text" id="end_time" lay-verify="required" value="" placeholder="请选择结束日期" autocomplete="off" class="layui-input">
            </div>
            <div class="layui-inline layui-word-aux">请选择员工入职时间范围</div>
        </div>
        
        
        <div class="layui-form-item">
            <label class="layui-form-label">课程类型</label>
            <div class="layui-input-inline">
                <select name="classtype" id="classtype" lay-filter="classtype">
                    {notempty name="list"}
                    <option value="{$list.classtype|default=''}">{$list.classtype_name|default=''}</option>
                    {else /}
                    <option value=""></option>
                    {/notempty}
                    {volist name="classArr" id="vo"}
                    <option value="{$vo.id}">{$vo.title}</option>
                    {/volist}
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">课程分类</label>
            <div class="layui-input-inline">
                <select name="classify" id="classify" lay-filter="classify">
                    {notempty name="list"}
                    <option value="{$list.classify|default=''}">{$list.classify_name|default=''}</option>
                    {else /}
                    <option value=""></option>
                    {/notempty}

                </select>
            </div>
        </div>
      <div class="layui-form-item outline online">
            <label class="layui-form-label">选择岗位</label>
            <div class="layui-input-inline" >
                <select id="station" name="station"  lay-filter="station" xm-select="select7_2" xm-select-skin="danger" xm-select-search="">
                    
                    <optgroup label="岗位">
                        {volist name="posts" id="vo"}
                      
                        <option value="{$vo.id}">{$vo.posts}</option>
                        {/if}
                        {/volist}
                    </optgroup>
                  

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

//监听select start
            form.on('select(classtype)', function(data){
                console.log(data.elem); //得到select原始DOM对象
                console.log(data.value); //得到被选中的值
                console.log(data.othis); //得到美化后的DOM对象
                $.ajax({
                    url: "classinfo" ,
                    data: {'pid':data.value,'levels':'1'} ,
                    type: "post" ,
                    dataType:'json',
                    success:function(data){
                        var lists=data.data;
                        $("#classnamelist").html('');
                        $("#classify").empty();
                        $("#classname").empty();
                        $("#classify").append("<option value=''>请选择</option>");
                        for(var i=0;i<lists.length;i++){
                            console.log(i+": "+lists[i]['title'])
                            $('#classify').append('<option value="'+lists[i]['id']+'">'+lists[i]['title']+'</option>');
                        }
                        form.render('select');
                        //layer.msg(data.msg, {icon: data.code},function(){$(".layui-laypage-btn").click();});
                    }
                })
            });
            form.on('select(classify)',function(data){
                console.log(data.value);

            });
            //所属岗位开始
            form.on('select(region)', function(data){
                $.ajax({
                    url: "/rackstage/Personnel/getCate" ,
                    data: {'pid':data.value} ,
                    type: "get" ,
                    dataType:'json',
                    success:function(data){
                        console.log(data);
                        framework=data.framework
                        $("#department").empty();
                        $("#department").append("<option value=''>请选择</option>");//新增
                        for(var i = 0; i < framework.length; i++){
                            $("#department").append("<option value='"+framework[i].id+"'>"+framework[i].name+"</option>");//新增
                        }

                        post=data.post
                        $("#station").empty();
                        $("#station").append("<option value=''>请选择</option>");//新增
                        for(var i = 0; i < post.length; i++){
                            $("#station").append("<option value='"+post[i].id+"'>"+post[i].posts+"</option>");//新增
                        }
                        form.render('select');
                    }
                })
            });
            //监听select end
            //触发搜索
            $(document).on('click','#statistics',function(){
                //部门和岗位不能为空，课程二级分类不能为空
                var department=layui.formSelects.value('select7_0', 'valStr'),//部门
                    station=layui.formSelects.value('select7_2', 'valStr'),//岗位
                    classify=$('#classify').val(),
                    start_time=$('#start_time').val(),
                    end_time=$('#end_time').val(),
                    is_train=$('input[name="is_train"]:checked').val();
                console.log(is_train);
                // if(department == ''&&station == ''){
                //     layer.msg('部门和岗位不能同时为空',{icon:0});
                //     return false;
                // }
                //
                if(start_time == ''){
                    layer.msg('开始时间不能为空',{icon:0});
                    return false;
                }
                if(end_time == ''){
                    layer.msg('结束时间不能为空',{icon:0});
                    return false;
                }
                var time_code=start_time+' - '+end_time;
                if(classify == ''){
                    layer.msg('课程分类不能为空',{icon:0});
                    return false;
                }

                table.render({
                    id: 'test'
                    ,toolbar: true
                    ,elem: '#test'
                    , url: 'class'
                    ,method:'post'
                    ,where: {
                        time_code: time_code,
                        department: department,
                        station:station,
                        classify: classify,
                        is_train:is_train,
                    }
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
                        {type:'numbers', minWidth: 20, title: '编号'}
                        ,{field:'name',  align:'center',  title: '部门'}
                        ,{field:'xue', align:'center',  title: '已培训'}
                        ,{field:'wei', align:'center', title: '未培训'}
                        ,{field:'num', align:'center',  title: '人数合计'}
                        ,{field:'bai', align:'center',  title: '培训率'}
                        

                    ]]
                });
            });
        })

</script>
{include file="public/footer" /}