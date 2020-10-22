
{include file="public/header" /}

<script type="text/html" id="checkboxTp2">
    <input type="checkbox" name="status" value="{{d.status}}" title="启用" lay-filter="lockDemo" {{ d.status == 1 ? 'checked' : '' }}>
</script>
<div class="layui-body">
    <!-- 内容主体区域 -->
    <div style="padding: 15px;">
        <div class="demoTable">
            <div class="layui-inline">
                <input class="layui-input" name="contract_num" value="" id="title" placeholder="根据标题搜索" autocomplete="off">
            </div>
            <div class="layui-input-inline layui-form" style="">
                <select id="types" name="types" lay-search>
                    <option value="">分类</option>
                    {volist name="type" id="vo"}
                        <option value="{$vo.id}">{$vo.posts}</option>
                    {/volist}
                </select>
            </div>
            <button class="layui-btn search" data-type="reload">搜索</button>
            <button class="layui-btn"  id="tel">添加公告</button>
                                                <button type="reset" class="layui-btn" id="reset">重置</button>

        </div>

        <table class="layui-hide"  lay-filter="test" id="test"></table>
        <script type="text/html" id="barDemo">
            <a class="layui-btn layui-btn-xs" lay-event="article_edit">编辑</a>
                        <a class="layui-btn layui-btn-xs" lay-event="article_detail">确认详情</a>
                                    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="article_del">删除</a>


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
        var renderTable = function(){table.render({
            elem: '#test'
            ,url:'article?id=1'
           
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
                {field:'title', align:'center', minWidth: 120, title: '标题'}
                ,{field:'pname',align:'center', minWidth: 120, title: '分类'}
                ,{field:'mark', align:'center', minWidth: 120, title: '简介'}
                ,{field:'departments', align:'center', minWidth: 120, title: '发送部门'}
                ,{field:'username', align:'center', minWidth: 120, title: '发送人'}
                ,{field:'createtime',align:'center',  minWidth: 120, title: '发布时间'}
               // ,{field:'status', title:'推荐', width:110, templet: '#checkboxTp2', unresize: true,event:'is_status'}
                ,{fixed: 'right', width:187, align:'center', toolbar: '#barDemo',title:'操作'}
            ]]
        });
    }
    renderTable();
        table.on('tool(test)', function(obj){
            var data = obj.data;
            if(obj.event === 'article_del'){
                layer.confirm('确定删除吗', function(index){
                    $.ajax({
                        url: "article_del" ,
                        data: {'id':data.id} ,
                        type: "post" ,
                        dataType:'json',
                        success:function(data){
                            layer.msg(data.msg, {icon: data.code,time:1000},function(){$(".layui-laypage-btn").click();});
                        }
                    })
                });
            } else if(obj.event === 'article_detail'){
                var index = layer.open({
                    title:"公告确认列表",
                    type: 2,
                    content: "articleDetail?id="+data.id,
                    area: [clientWidth*0.9+'px', '650px'],
                    maxmin: true
                });
                layer.full(index);
            }else if(obj.event === 'article_edit'){
                var index = layer.open({
                    type: 2,
                    shade: [0.1],
                    title:"添加/编辑",
                    area: ['900px', '600px'],
                    maxmin: true,
                    content: 'article_edit?id='+data.id,
                    btn: ['保存','关闭'],
                    zIndex: layer.zIndex, //重点1
                    yes: function(index){
                        var row= window["layui-layer-iframe" + index].callbackdata();
                        if(!$.trim(row)){
                            return false;
                        }
                        layer.closeAll();
                        $.ajax({
                            url:"article_edit",
                            type:"post",
                            dataType: "json",
                            cache: false,
                            data:row,
                            contentType: "application/x-www-form-urlencoded; charset=utf-8",
                            success:function(data){
                                if(data.code==1){
                                    layer.msg(data.msg, {icon: data.code,time:1000},function(){$(".layui-laypage-btn").click();});
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

            }else if(obj.event === 'is_status'){
                layer.confirm('确认启用操作？', function(index){
                    $.ajax({
                        url: "is_status" ,
                        data: {'id':data.id,'status':data.status} ,
                        type: "post" ,
                        dataType:'json',
                        success:function(data){
                            layer.msg(data.info, {icon: data.msg},function(){$(".layui-laypage-btn").click();});
                        }
                    })
                });
            }
        });

        var $ = layui.$, active = {
            reload: function(){
                table.reload('test', {
                    url: 'search'
                    ,page: {
                        curr: 1 //重新从第 1 页开始
                    }
                    ,method: 'post'
                    ,where: {
                        title:$('#title').val(),
                        types:$('#types').val()
                    }
                });
            }
        };
        $('.demoTable .layui-btn').on('click', function(){
            var type = $(this).data('type');
            active[type] ? active[type].call(this) : '';
        });
    });

    layui.use(['table','layer','jquery'], function(){
        var $ = layui.jquery, layer = layui.layer;
        $(document).on('click','#tel',function(){
            var index = layer.open({
                type: 2,
                shade: [0.1],
                title:"添加/编辑",
                area: ['900px', '600px'],
                maxmin: true,
                content: 'article_add',
                btn: ['保存','关闭'],
                zIndex: layer.zIndex, //重点1
                yes: function(index){
                    var row= window["layui-layer-iframe" + index].callbackdata();

                    if(!$.trim(row)){
                        return false;
                    }
                    layer.closeAll();
                    $.ajax({
                        url:"article_add",
                        type:"post",
                        dataType: "json",
                        cache: false,
                        data:row,
                        contentType: "application/x-www-form-urlencoded; charset=utf-8",
                        success:function(data){
                            if(data.code==1){
                                layer.msg(data.msg,{time: 1000},function () {
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
                            layer.full(index);

        });
    });
</script>
{include file="public/footer" /}