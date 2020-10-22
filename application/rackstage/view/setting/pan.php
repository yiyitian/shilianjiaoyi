<link rel="stylesheet" href="_CSS_/layui.css">
{include file="public/header" /}
<div class="layui-body">
    <!-- 内容主体区域 -->
    <div style="padding: 15px;">
    <div class="demoTable">
            <div class="layui-input-inline" style="">
                <input class="layui-input" name="search_field" value="" id="search_field" placeholder="根据文件夹名称搜索" autocomplete="off">
            </div>
            <button class="layui-btn search" data-type="reload" style="">搜索</button>
            <button class="layui-btn"  id="add">创建文件夹</button>
                                                <button type="reset" class="layui-btn" id="reset">重置</button>

        </div>

        <table class="layui-hide"  lay-filter="test" id="test"></table>
        <script type="text/html" id="barDemo">
            <a class="layui-btn layui-btn-xs" lay-event="edits">编辑</a>
                        <a class="layui-btn layui-btn-xs" lay-event="edit">查看文件</a>

            <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
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
                elem: '#test'
                ,url:'pan'
                ,page: { //支持传入 laypage 组件的所有参数（某些参数除外，如：jump/elem） - 详见文档
                    layout: ['limit', 'count', 'prev', 'page', 'next', 'skip'] //自定义分页布局
                    //,curr: 5 //设定初始在第 5 页
                    ,limit:25 //一页显示多少条
                    ,limits:[25,50,100]//每页条数的选择项
                    ,groups: 6 //只显示 6 个连续页码
                    ,first: "首页" //不显示首页
                    ,last: "尾页" //不显示尾页

                }
                ,cols: [[
                   {type:'numbers', minWidth: 20, title: '编号'}
                    ,{field:'files', align:'center', title: '文件夹名称'}
                    ,{field:'department', align:'center',  title: '查阅权限'}
                    ,{field:'uname', align:'center',  width:"10%",  title: '创建人'}
                    ,{field:'times', align:'center',  width:"10%",  title: '创建时间'}
                    ,{field:'content', align:'center', width:"10%", title: '备注'}
                    ,{fixed: 'right', width:"10%", align:'center', toolbar: '#barDemo',title:'操作'}
                ]]
            });
        }

        renderTable();
         var $ = layui.$, active = {
            reload: function(){
                var demoReload = $('#search_field');
                //执行重载
                table.reload('test', {
                    url: 'pan?id=1'
                    ,page: {
                        curr: 1 //重新从第 1 页开始
                    }
                    ,method: 'post'
                    ,where: {
                        search_field: demoReload.val(),

                    }
                });
            }
        };
        $('.demoTable .layui-btn').on('click', function(){
            var type = $(this).data('type');
            active[type] ? active[type].call(this) : '';
        });
        table.on('tool(test)', function(obj){
            var data = obj.data;
            if(obj.event === 'del'){
                layer.confirm('确定删除吗', function(index){
                    $.ajax({
                        url: "uploadDel" ,
                        data: {'id':data.id} ,
                        type: "post" ,
                        dataType:'json',
                        success:function(data){
                            layer.msg('删除成功', {icon: 1},function(){$(".layui-laypage-btn").click();});
                        }
                    })
                });
            } else if(obj.event === 'edit'){
                var index = layer.open({
                    title:"列表",
                    type: 2,
                    content: "filesList?pro_id="+data.id,
                    area: [clientWidth*0.9+'px', '650px'],
                    maxmin: true
                });
                layer.full(index);
            }else if(obj.event === 'edits') {
                var index = layer.open({
                    type: 2,
                    shade: [0.1],
                    title:"添加/编辑",
                    area: [clientWidth*.7+'px', clientHeight*.6+'px'],
                    maxmin: true,
                    content: 'panEdits?id='+data.id,
                    btn: ['保存','关闭'],
                    zIndex: layer.zIndex, //重点1
                    yes: function(index){
                        var row= window["layui-layer-iframe" + index].callbackdata();
                        if(!$.trim(row)){
                            return false;
                        }
                        layer.closeAll();
                        $.ajax({
                            url:"panEdits",
                            type:"post",
                            dataType: "json",
                            cache: false,
                            data:row,
                            contentType: "application/x-www-form-urlencoded; charset=utf-8",
                            success:function(data){
                                if(data.code==1){
                                    layer.msg(data.msg,{icon:1,time: 500},function(){$(".layui-laypage-btn").click();});
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
            }
        });
        $(document).on('click','#add',function(){
            var index = layer.open({
                type: 2,
                shade: [0.1],
                title:"添加/编辑",
                area: [clientWidth*.7+'px', clientHeight*.6+'px'],
                maxmin: true,
                content: 'panAdd',
                btn: ['保存','关闭'],
                zIndex: layer.zIndex, //重点1
                yes: function(index){
                    var row= window["layui-layer-iframe" + index].callbackdata();
                    if(!$.trim(row)){
                        return false;
                    }

                    $.ajax({
                        url:"panAdd",
                        type:"post",
                        dataType: "json",
                        cache: false,
                        data:row,
                        contentType: "application/x-www-form-urlencoded; charset=utf-8",
                        success:function(data){
                            if(data.code==1){
                                layer.closeAll();
                                layer.msg(data.msg,{time: 500},function () {
                                    //location.reload();
                                    renderTable();
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

    });


</script>
{include file="public/footer" /}