<link rel="stylesheet" href="_CSS_/layui.css">
{include file="public/header" /}

<script type="text/html" id="checkboxTp2">
    <input type="checkbox" name="status" value="{{d.status}}" lay-skin="switch" lay-text="显示|隐藏" lay-filter="sexDemo" {{ d.status == 1 ? 'checked' : '' }}>
</script>
<div class="layui-body">
    <!-- 内容主体区域 -->
    <div style="padding: 15px;">
        <div class="demoTable">
            <div class="layui-input-inline layui-form" style="">
                <select id="search_field" name="search_field" lay-search>
                    <option value="">可输入可选择</option>
                    {volist name="project" id="vo"}
                    <option value="{$vo.id}">{$vo.name}</option>
                    {/volist}
                </select>
            </div>
            <div class="layui-input-inline layui-form" style="">
                <select id="user_id" name="user_id" lay-search>
                    <option value="">可输入可选择</option>
                    {volist name="user" id="vo"}
                    <option value="{$vo.id}">{$vo.user_name}</option>
                    {/volist}
                </select>
            </div>
            <button class="layui-btn search" data-type="reload" style="">搜索项目</button>
            <button class="layui-btn" id="add" >添加</button>
            <button type="reset" class="layui-btn" id="reset">重置</button>

            <button class="layui-btn layui-btn-normal" onclick="javascript:window.location.replace('/rackstage/Saleoffice/ftSearch');" >访谈查询</button>
        </div>
        <table class="layui-hide"  lay-filter="test" id="test"></table>
        <script type="text/html" id="barDemo">
            {if condition="($_SESSION['think']['role_title'] eq '项目负责人')OR($_SESSION['think']['role_title'] eq '项目经理')"}
            <a class="layui-btn layui-btn-xs layui-btn-normal" lay-event="see">查看</a>
            {else /}
            <a class="layui-btn layui-btn-xs layui-btn-normal" lay-event="see">查看</a>

            <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
            <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
            {/if}
        </script>

        <div id="pages" class="text-center"></div>
    </div>
</div>
<script src="/public/layui/layui.js"></script>
<script>
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
                ,toolbar:true
                ,url:'ft'

                ,page: { //支持传入 laypage 组件的所有参数（某些参数除外，如：jump/elem） - 详见文档
                    layout: ['limit', 'count', 'prev', 'page', 'next', 'skip'] //自定义分页布局
                    //,curr: 5 //设定初始在第 5 页
                    ,limit:25 //一页显示多少条
                    ,limits:[25,50,100,999999]//每页条数的选择项
                    ,groups: 6 //只显示 6 个连续页码
                    ,first: "首页" //不显示首页
                    ,last: "尾页" //不显示尾页

                }
                ,cols: [[
                    {field:'department_name', width:120, align:'center',   title: '部门'}
                    ,{field:'project_name',  align:'center', width:120,  title: '项目名称'}
                    ,{field:'manager',  align:'center',  width:120, title: '项目经理'}
                    ,{field:'plan', align:'center',   width:120,title: '项目策划'}
                    ,{field:'ftname',  align:'center',  width:120, title: '访谈人'}
                    ,{field:'bftname', align:'center',  width:120, title: '被访谈人'}
                    ,{field:'bftposts', align:'center', width:120, title: '被访谈人职位'}
                    ,{field:'fttime', align:'center',  width:120, title: '访谈时间'}
                    ,{field:'status', align:'center',  width:120, title: '工作状态'}
                    ,{field:'zxl', align:'center', width:120,  title: '执行力'}
                    ,{field:'phd', align:'center', width:120,title: '配合度'}
                    ,{field:'jy', align:'center', width:120, title: '团队建议'}
                    ,{field:'myd', align:'center',  width:120,title: '满意度'}
                    ,{field:'fk', align:'center', width:120, title: '反馈'}
                    ,{field:'enquiryer', align:'center', width:120, title: '添加人'}
                    ,{width:150,   align:'center', toolbar: '#barDemo',title:'操作'}
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
                    url: 'ft?id=1'
                    ,page: {
                        curr: 1 //重新从第 1 页开始
                    }
                    ,method: 'post'
                    ,where: {
                        search_field: demoReload.val(),
                        user_id: $('#user_id').val(),

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
            if(obj.event === 'edit'){
                var index = layer.open({
                    type: 2,
                    shade: [0.1],
                    title:"添加/编辑",
                    area: [clientWidth*1+'px', clientHeight*1+'px'],
                    maxmin: true,
                    content: 'ftEdit?id='+data.id,
                    btn: ['保存','关闭'],
                    zIndex: layer.zIndex, //重点1
                    yes: function(index){
                        var row= window["layui-layer-iframe" + index].callbackdata();
                        if(!$.trim(row)){
                            return false;
                        }
                        $.ajax({
                            url:"ftEdit",
                            type:"post",
                            dataType: "json",
                            cache: false,
                            data:row,
                            contentType: "application/x-www-form-urlencoded; charset=utf-8",
                            success:function(data){
                                layer.closeAll();
                                if(data.code==1){
                                    layer.msg(data.msg,{icon:1,time: 2000},function () {
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
                layer.full(index);

            }else if(obj.event === 'see'){
                console.log(data.id);

                var index = layer.open({
                    type: 2,
                    shade: [0.1],
                    title:"添加/编辑",
                    area: [clientWidth*0.7+'px', clientHeight*0.6+'px'],
                    maxmin: true,
                    content: 'ftSee?id='+data.id,
                    btn: ['关闭'],
                    zIndex: layer.zIndex, //重点1
                    yes: function(index){layer.closeAll();},
                    cancel: function(){
                    },
                    end: function(){ //此处用于演示
                    }
                });
                layer.full(index);

            } else if(obj.event === 'del'){
                layer.confirm('确定删除吗', function(index){
                    $.ajax({
                        url: "ftDel" ,
                        data: {'id':data.id},
                        type: "post" ,
                        dataType:'json',
                        success:function(data){
                            layer.msg(data.msg, {icon: data.code,time:500},function(){renderTable();});
                        }
                    })
                });
            }
        });
        $(document).on('click','#add',function(){
            var index = layer.open({
                type: 2,
                shade: [0.1],
                title:"添加",
                area: [clientWidth*.7+'px', clientHeight*.6+'px'],
                maxmin: true,
                content: 'ftAdd',
                btn: ['保存','关闭'],
                zIndex: layer.zIndex, //重点1
                yes: function(index){
                    var row= window["layui-layer-iframe" + index].callbackdata();
                    if(!$.trim(row)){
                        return false;
                    }
                    $.ajax({
                        url:"ftAdd",
                        type:"post",
                        dataType: "json",
                        cache: false,
                        data:row,
                        contentType: "application/x-www-form-urlencoded; charset=utf-8",
                        success:function(data){
                            if(data.code==1){
                                layer.closeAll();
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
            layer.full(index);
        });
        //#添加end
    });


</script>
{include file="public/footer" /}