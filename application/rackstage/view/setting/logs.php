
{include file="public/header" /}
<script type="text/html" id="checkboxTp2">
    <input type="checkbox" name="status" value="{{d.status}}" title="启用" lay-filter="lockDemo" {{ d.status == 1 ? 'checked' : '' }}>
</script>
<div class="layui-body">
    <!-- 内容主体区域 -->
    <div style="padding: 15px;">

        <table class="layui-hide"  lay-filter="test" id="test"></table>
        <script type="text/html" id="barDemo">
            <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del_log">删除</a>
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
        var clientWidth=document.body.clientWidth;
        var clientHeight=document.body.clientHeight;
        table.render({
            elem: '#test'
            ,url:'logs?id=1'
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
                ,{field:'user_name', width: '10%',  title: '用户'}
                ,{field:'ips', width: '10%',  title: 'ip'}
                ,{field:'create_time', width: '15%',  title: '登录时间'}
                 ,{fixed: 'right', width:87, align:'center', toolbar: '#barDemo',title:'操作'}

            ]]
        });
        table.on('tool(test)', function(obj){
            var data = obj.data;
            if(obj.event === 'del_log'){
                layer.confirm('确定删除吗', function(index){
                    $.ajax({
                        url: "del_log" ,
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
                    type: 2,
                    shade: [0.1],
                    title:"添加/编辑",
                    area: ['900px', '600px'],
                    maxmin: true,
                    content: 'edit?id='+data.id,
                    btn: ['保存','关闭'],
                    zIndex: layer.zIndex, //重点1
                    yes: function(index){
                        var row= window["layui-layer-iframe" + index].callbackdata();
                        if(!$.trim(row)){
                            return false;
                        }
                        layer.closeAll();
                        $.ajax({
                            url:"edit",
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
            } else if(obj.event === 'detail'){
                var index = layer.open({
                    type: 2,
                    shade: [0.1],
                    title:"添加/编辑",
                    area: ['900px', '600px'],
                    maxmin: true,
                    content: 'task_list?id='+data.id,
                    btn: ['保存','关闭'],
                    zIndex: layer.zIndex, //重点1
                    yes: function(index){
                        var row= window["layui-layer-iframe" + index].callbackdata();

                        if(!$.trim(row)){
                            return false;
                        }
                        layer.closeAll();
                        $.ajax({
                            url:"task_list",
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
            }else if(obj.event === 'showImg'){
                var img = "<img src='"+data.src_img+"' />";
                var index=layer.open({
                    type:1,
                    shift: 2,
                    shade:0,
                    title:'查看合同',
                    shadeClose:true,
                    content:img,
                    maxmin: true

                });
                layer.full(index);
            }else if(obj.event === 'is_back'){
                if(data.status==='1'){layer.msg('已经回款，无需再次操作');return false;}
                layer.confirm('确认操作？', function(index){
                    $.ajax({
                        url: "edit_back_money" ,
                        data: {'id':data.id,'status':data.status} ,
                        type: "post" ,
                        dataType:'json',
                        success:function(data){
                            layer.msg(data.info, {icon: data.msg},function(){$(".layui-laypage-btn").click();});
                        }
                    })
                });

            }else if(obj.event === 'is_status'){
                if(data.is_technology==='1'){layer.msg('已经通过审核，无需再次操作');return false;}
                layer.confirm('确认启用操作？', function(index){
                    $.ajax({
                        url: "edit_status" ,
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
                content: 'add',
                btn: ['保存','关闭'],
                zIndex: layer.zIndex, //重点1
                yes: function(index){
                    var row= window["layui-layer-iframe" + index].callbackdata();
                    if(!$.trim(row)){
                        return false;
                    }
                    layer.closeAll();
                    $.ajax({
                        url:"add",
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