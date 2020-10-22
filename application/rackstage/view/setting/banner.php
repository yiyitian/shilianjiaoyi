<link rel="stylesheet" href="_CSS_/layui.css">
{include file="public/header" /}
<div class="layui-body">
    <div style="padding: 15px;">
        <button class="layui-btn"  id="tel">添加轮播</button>
         <table class="layui-hide"  lay-filter="test" id="test"></table>
        <script type="text/html" id="barDemo">
                <a class="layui-btn  layui-btn-xs" lay-event="bannerEdit">编辑</a>

        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="bannerDel">删除</a>
        </script>
        <div id="pages" class="text-center"></div>
    </div>
       
</div>
</div>
<script src="/public/layui/layui.js"></script>
<script>
    layui.use(['table','layer','jquery'], function(){
        var table = layui.table,
            $   = layui.jquery
            ,form = layui.form
            ,layer = layui.layer;
     
        table.render({
            elem: '#test'
            ,url:'banner?id=1'

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
                ,{field:'url',align:'center',title:'轮播图',templet:'<div><img src="{{ d.url}}"></div>'}
                ,{field:'img',align:'center',title:'轮播链接'}
                                ,{field:'sort',align:'center',title:'排序'}

                ,{fixed: 'right', width:187, align:'center', toolbar: '#barDemo',title:'操作'}
            ]]
        });
        table.on('tool(test)', function(obj){
            var data = obj.data;
            if(obj.event === 'bannerDel'){
                layer.confirm('确定删除吗', function(index){
                    $.ajax({
                        url: "bannerDel" ,
                        data: {'id':data.id} ,
                        type: "post" ,
                        dataType:'json',
                        success:function(data){
                            layer.msg(data.msg, {icon: data.code,time:1000},function(){$(".layui-laypage-btn").click();});
                        }
                    })
                });
            }else if(obj.event === 'bannerEdit'){
                var index = layer.open({
                    type: 2,
                    shade: [0.1],
                    title:"添加/编辑",
                    area: ['900px', '600px'],
                    maxmin: true,
                    content: 'bannerEdit?id='+data.id,
                    btn: ['保存','关闭'],
                    zIndex: layer.zIndex, //重点1
                    yes: function(index){
                        var row= window["layui-layer-iframe" + index].callbackdata();
                        if(!$.trim(row)){
                            return false;
                        }
                        layer.closeAll();
                        $.ajax({
                            url:"bannerEdit",
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
            }
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
                content: 'bannerAdd',
                btn: ['保存','关闭'],
                zIndex: layer.zIndex, //重点1
                yes: function(index){
                    var row= window["layui-layer-iframe" + index].callbackdata();
                    if(!$.trim(row)){
                        return false;
                    }
                    layer.closeAll();
                    $.ajax({
                        url:"bannerAdd",
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
        });
    });
</script>
{include file="public/footer" /}