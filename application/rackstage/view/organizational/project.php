<link rel="stylesheet" href="_CSS_/layui.css">
{include file="public/header" /}
<link rel="stylesheet" href="/public/layui/formSelects-v4.css" media="all">

<script type="text/html" id="checkboxTp2">
    <input type="checkbox" name="status" value="{{d.status}}" lay-skin="switch" lay-text="显示|隐藏" lay-filter="sexDemo" {{ d.status == 1 ? 'checked' : '' }}>
</script>
<script type="text/html" id="checkboxTp3">
    <input type="checkbox" name="is_edit" value="{{d.is_edit}}" lay-skin="switch" lay-text="确定|取消" lay-filter="sexDemo" {{ d.is_edit == 1 ? 'checked' : '' }}>
</script>
<div class="layui-body">
    <!-- 内容主体区域 -->
    <div style="padding: 15px;">
        {if condition="isset($block)"}{else/}
            <div class="demoTable">
                <div class="layui-input-inline" style="">
                    <input class="layui-input" name="search_field" value="" id="search_field" placeholder="请根据项目名称搜索" autocomplete="off">
                </div>
                <div class="layui-input-inline" style="">
                    <input class="layui-input" name="manager" value="" id="manager" placeholder="请根据项目经理搜索" autocomplete="off">
                </div>
                <div class="layui-input-inline layui-form" style="">
                    <select id="search_fields" name="search_field" lay-search>

                        <option value="-1">未撤场</option>
                        <option value="1">已撤场</option>

                    </select>
                </div>
                <button class="layui-btn search" data-type="reload" style="">搜索</button>
                {notempty name="uid"}
                <button class="layui-btn" id="add">新增项目</button>
                {/notempty}
                                    <button type="reset" class="layui-btn" id="reset">重置</button>

            </div>
        {/if}
        <table class="layui-hide"  lay-filter="test" id="test"></table>
        <script type="text/html" id="barDemo">
            {if condition="isset($block)"}
            <a class="layui-btn layui-btn-xs" lay-event="projectPeople">项目人员</a>
            {else/}
            {notempty name="uid"}

            <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
{/notempty}
            <a class="layui-btn layui-btn-xs" lay-event="projectPeople">项目人员</a>
            {notempty name="uid"}

            <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">撤场</a>
            {/notempty}
            {/if}
        </script>

        <div id="pages" class="text-center"></div>
    </div>
</div>
<script src="/public/layui/layui.js"></script>

<script src="/public/layui/formSelects-v4.js" charset="utf-8"></script>

<script>
  layui.config({
        base: './' //此处路径请自行处理, 可以使用绝对路径
    }).extend({
        formSelects: 'formSelects-v4'
    });
    layui.use(['table','layer','jquery'], function(){
        var table = layui.table,
            $   = layui.jquery
            ,form = layui.form
            ,layer = layui.layer;
            $(document).on('click','#reset',function(){
            $('input').val('');
            $('select').val('');
            renderTable();
        });
        var clientWidth=document.body.clientWidth;
        var clientHeight=document.body.clientHeight;
        var renderTable = function(){
            table.render({
                id:'test'
                ,elem: '#test'
                ,url:'project?id=1'

                ,page: { //支持传入 laypage 组件的所有参数（某些参数除外，如：jump/elem） - 详见文档
                    layout: ['limit', 'count', 'prev', 'page', 'next', 'skip'] //自定义分页布局
                    //,curr: 5 //设定初始在第 5 页
                    ,limit:25 //一页显示多少条
                    ,limits:[25,50,100,200,300]//每页条数的选择项
                    ,groups: 6 //只显示 6 个连续页码
                    ,first: "首页" //不显示首页
                    ,last: "尾页" //不显示尾页

                }
                ,cols: [[
                    {type:'numbers', minWidth: 20, title: '编号'}
                    ,{field:'name',  align:'center',  title: '项目名称'}
                    ,{field:'user_name',  align:'center',  title: '负责人'}
                    ,{field:'manager',  align:'center',  title: '项目经理'}
                    ,{field:'department', align:'center',  title: '部门'}
                    ,{field:'mark', align:'center', title: '备注'}
                                        ,{field:'type', align:'center', title: '类型',templet:function (d) {
                                            if (d.type==1) {
return '<span style="color:green">住宅</span>';
                                            }else if(d.type==2){
                                                return '<span style="color:blue">商用</span>';

                                            }
                                            // body...
                                        }}

//                  ,{field:'status', align:'center',title:'状态', templet: '#checkboxTp2', unresize: true,event:'checkStatusProject'}
                    ,{field:'is_edit', align:'center',title:'编辑', templet: '#checkboxTp3', unresize: true,event:'checkStatusProjects'}
                    ,{fixed: 'right', width:222, align:'center', toolbar: '#barDemo',title:'操作'}
                ]]
            });
        }
        renderTable();
        /*搜索开始*/
        var $ = layui.$, active = {
            reload: function(){
                var demoReload = $('#search_field');
                //执行重载
                table.reload('test', {
                    url: 'project?id=1'
                    ,page: {
                        curr: 1 //重新从第 1 页开始
                    }
                    ,method: 'post'
                    ,where: {
                        search_field: demoReload.val(),
                        manager:$('#manager').val(),
                        del:$('#search_fields').val(),
                    }
                });
            }
        };
        $('.demoTable .layui-btn').on('click', function(){
            var type = $(this).data('type');
            active[type] ? active[type].call(this) : '';
        });
        /*搜索结束*/
        table.on('tool(test)', function(obj){
            var data = obj.data;
            if(obj.event === 'del'){
                layer.confirm('确定撤场吗', function(index){
                    $.ajax({
                        url: "project_del" ,
                        data: {'id':data.id} ,
                        type: "post" ,
                        dataType:'json',
                        success:function(data){
                            layer.msg('撤场成功', {icon: 1},function(){
                                renderTable();//$(".layui-laypage-btn").click();
                                });
                        }
                    })
                });
            } else if(obj.event === 'edit'){
                var index = layer.open({
                    type: 2,
                    shade: [0.1],
                    title:"添加/编辑",
                    area: [clientWidth*.7+'px', clientHeight*.6+'px'],
                    maxmin: true,
                    content: 'project_edit?id='+data.id,
                    btn: ['保存','关闭'],
                    zIndex: layer.zIndex,
                    yes: function(index){
                        var row= window["layui-layer-iframe" + index].callbackdata();
                        if(!$.trim(row)){
                            return false;
                        }
                        
                        layer.closeAll();
                        $.ajax({
                            url:"project_edit",
                            type:"post",
                            dataType: "json",
                            cache: false,
                            data:row,
                            contentType: "application/x-www-form-urlencoded; charset=utf-8",
                            success:function(data){
                                if(data.code==1){
                                    layer.msg(data.msg,{icon:1,time: 500},function () {
                                        renderTable();//location.reload();
                                    });
                                }else{
                                    layer.msg(data.msg, { icon: 0});
                                }
                            }
                        });
                    },
                    cancel: function(){
                    },
                    end: function(){ //此处用于演示
                    }
                });
            }else if(obj.event === 'checkStatusProject'){
                $.ajax({
                    url: "checkStatusProject" ,
                    data: {'id':data.id,'status':data.status} ,
                    type: "post" ,
                    dataType:'json',
                    success:function(data){
                        layer.msg(data.msg, {icon: data.code},function(){renderTable();});
                    }
                })
            }else if(obj.event === 'checkStatusProjects'){
                $.ajax({
                    url: "checkStatusProjects" ,
                    data: {'id':data.id,'status':data.is_edit} ,
                    type: "post" ,
                    dataType:'json',
                    success:function(data){
                        layer.msg(data.msg, {icon: data.code},function(){renderTable();});
                    }
                })
            }else if(obj.event === 'projectPeople'){
                var index = layer.open({
                    title:"项目人员维护",
                    type: 2,
                    content: "projectPeople?id="+data.id,
                    area: ['100%', '100%'],
                    maxmin: true
                });
                layer.full(index);
            }
        });
        $(document).on('click','#add',function(){
            var index = layer.open({
                type: 2,
                shade: [0.1],
                title:"添加/编辑",
                area: [clientWidth*.7+'px', clientHeight*.6+'px'],
                maxmin: true,
                content: 'project_add?type=-1',
                btn: ['保存','关闭'],
                zIndex: layer.zIndex, //重点1
                yes: function(index){
                    var row= window["layui-layer-iframe" + index].callbackdata();
                    if(!$.trim(row)){
                        return false;
                    }
                    layer.closeAll();
                    $.ajax({
                        url:"project_add",
                        type:"post",
                        dataType: "json",
                        cache: false,
                        data:row,
                        contentType: "application/x-www-form-urlencoded; charset=utf-8",
                        success:function(data){
                            if(data.code==1){
                                layer.msg(data.msg,{icon:1,time: 500},function () {
                                    renderTable();//location.reload();
                                });
                            }else{
                                layer.msg(data.msg, { icon: 0});
                            }
                        }
                    });
                },
                cancel: function(){
                },
                end: function(){ //此处用于演示
                }
            });
        });
        //#添加end
    });

    
</script>
{include file="public/footer" /}