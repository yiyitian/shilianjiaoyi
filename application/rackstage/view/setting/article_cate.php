

<link rel="stylesheet" href="_CSS_/layui.css">
{include file="public/header" /}

<script type="text/html" id="checkboxTp2">
    <input type="checkbox" name="status" value="{{d.status}}" lay-skin="switch" lay-text="显示|隐藏" lay-filter="sexDemo" {{ d.status == 1 ? 'checked' : '' }}>
</script>
<style>
    .layui-table-view .layui-table{display:block;overflow:hidden;}
</style>
<div class="layui-body">
    <!-- 内容主体区域 -->
    <div style="padding:15px ;">
        <div class="layui-btn-group">
            <button class="layui-btn" id="btn-expand">分类展开</button>
            <button class="layui-btn" id="btn-fold">分类折叠</button>
            <button class="layui-btn" id="btn-refresh">分类刷新</button>
            <button class="layui-btn" id="add" style="display:none;">新增岗位</button>
        </div>


        <table class="layui-hide"  lay-filter="test" id="test"></table>
        <script type="text/html" id="barDemo">
            {{#  if(d.pid != 0){ }}
            <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
            {{#  }else{ }}
            <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="add">增加</a>
            {{# } }}
        </script>

        <div id="pages" class="text-center"></div>
    </div>
</div>
<script src="/public/layui/layui.js"></script>
<script src="/public/treetable-lay/assets/layui/layui.js"></script>
<script>
    layui.config({
        base: '/public/treetable-lay/module/'
    }).extend({
        treetable: 'treetable-lay/treetable'
    }).use(['layer', 'table', 'treetable'], function () {
        var $ = layui.jquery;
        var table = layui.table;
        var layer = layui.layer;
        var treetable = layui.treetable;

        // 渲染表格
        var renderTable = function () {
            layer.load(2);
            treetable.render({
                treeColIndex: 1,
                treeSpid: 0,
                treeIdName: 'id',
                treePidName: 'pid',
                treeDefaultClose: false,
                treeLinkage: false,
                elem: '#test',
                url: 'article_cate?id=1',
                page: false,
                cols: [[
                    {type:'numbers', minWidth: 20, title: '编号'},
                    {field:'posts',  align:'left',  title: '岗位名称'},
                    {field:'posts',  align:'left',  title: '岗位名称',edit:"text"},
                    {field: 'remark', title: '备注',align:'center',edit: 'text'},
                    {field:'status',title:'状态',templet: '#checkboxTp2', unresize: true,event:'status',align:'center'},
                    {align:'center',toolbar: '#barDemo',title:'操作'}
                ]],
                done: function () {
                    layer.closeAll('loading');
                }
            });
        };

        renderTable();

        $('#btn-expand').click(function () {
            treetable.expandAll('#test');
        });

        $('#btn-fold').click(function () {
            treetable.foldAll('#test');
        });

        $('#btn-refresh').click(function () {
            renderTable();
        });
        //编辑表格工具
        table.on('edit(test)', function(obj){
            var value = obj.value //得到修改后的值
                ,data = obj.data //得到所在行所有键值
                ,field = obj.field; //得到字段
            //layer.msg('[ID: '+ data.id +'] ' + field + ' 字段更改为：'+ value);

            $.ajax({
                url: "postsfieldedit",
                data: {'id':data.id,'field':field,'value':value} ,
                type: "post" ,
                dataType:'json',
                success:function(data){
                    layer.msg(data.msg, {icon: data.code,time:1000},function(){
                        //renderTable();
                    });
                }
            })
        });
        //监听工具条
        table.on('tool(test)', function (obj) {
            var data = obj.data;
            var layEvent = obj.event;
            if (layEvent === 'del') {
                layer.confirm('确定删除吗', function(index){
                    $.ajax({
                        url: "postsDel" ,
                        data: {'id':data.id} ,
                        type: "post" ,
                        dataType:'json',
                        success:function(data){
                            layer.msg('删除成功', {icon: 1,time:1000},function(){
                                renderTable();
                            });
                        }
                    })
                });
            } else if (layEvent === 'status') {
                $.ajax({
                    url: "checkStatusPosts" ,
                    data: {'id':data.id,'status':data.status} ,
                    type: "post" ,
                    dataType:'json',
                    success:function(data){
                        layer.msg(data.msg, {icon: data.code,time:1000},function(){
                                renderTable();
                        });
                    }
                })
            } else if(obj.event === 'edit'){
                var index = layer.open({
                    type: 2,
                    shade: [0.1],
                    title:"添加/编辑",
                    area: ['700px', '500px'],
                    maxmin: true,
                    content: 'postsEdit?id='+data.id,
                    btn: ['保存','关闭'],
                    zIndex: layer.zIndex,
                    yes: function(index){
                        var row= window["layui-layer-iframe" + index].callbackdata();
                        if(!$.trim(row)){
                            return false;
                        }
                        layer.closeAll();
                        $.ajax({
                            url:"postsEdit",
                            type:"post",
                            dataType: "json",
                            cache: false,
                            data:row,
                            contentType: "application/x-www-form-urlencoded; charset=utf-8",
                            success:function(data){
                                if(data.code==1){
                                    layer.msg(data.msg,{time: 1000},function () {
                                        //renderTable();
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
            } else if (layEvent === 'add') {
                var index = layer.open({
                    type: 2,
                    shade: [0.1],
                    title:"添加分类",
                    area: ['700px', '500px'],
                    maxmin: true,
                    content: 'postsAdd?pid='+data.id,
                    btn: ['保存','关闭'],
                    zIndex: layer.zIndex, //重点1
                    yes: function(index){
                        var row= window["layui-layer-iframe" + index].callbackdata();
                        if(!$.trim(row)){
                            return false;
                        }
                        layer.closeAll();
                        $.ajax({
                            url:"postsAdd",
                            type:"post",
                            dataType: "json",
                            cache: false,
                            data:row,
                            contentType: "application/x-www-form-urlencoded; charset=utf-8",
                            success:function(data){
                                if(data.code==1){
                                    layer.msg(data.msg,{time: 1000},function () {
                                         renderTable();
                                        location.reload();
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
            }
        });
    })
    //////////treetable_end


    layui.use(['table','layer','jquery'], function(){
        var $ = layui.jquery, layer = layui.layer;
        $(document).on('click','#add',function(){
            var index = layer.open({
                type: 2,
                shade: [0.1],
                title:"添加/编辑",
                area: ['700px', '500px'],
                maxmin: true,
                content: 'postsAdd?type=1',
                btn: ['保存','关闭'],
                zIndex: layer.zIndex, //重点1
                yes: function(index){
                    var row= window["layui-layer-iframe" + index].callbackdata();
                    if(!$.trim(row)){
                        return false;
                    }
                    layer.closeAll();
                    $.ajax({
                        url:"postsAdd",
                        type:"post",
                        dataType: "json",
                        cache: false,
                        data:row,
                        contentType: "application/x-www-form-urlencoded; charset=utf-8",
                        success:function(data){
                            if(data.code==1){
                                layer.msg(data.msg,{time: 2000},function () {
                                    location.reload();
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
    });
</script>
{include file="public/footer" /}