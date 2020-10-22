{include file="public/header" /}
<style>
    .layui-upload-img{width: 92px;  height: 92px;  margin: 0 10px 10px 0; }
     .layui-table-cell {
        font-size:14px;
        padding:0 5px;
        height:auto;
        overflow:visible;
        text-overflow:inherit;
        white-space:normal;
        word-wrap: break-word;
    }
</style>


<div class="layui-body">
    <!-- 内容主体区域 -->
    <div style="padding: 15px;">
        <div class="demoTable">
            <button class="layui-btn" id="add">添加</button>

        </div>
        <table class="layui-hide"  lay-filter="test" id="test"></table>
        <script type="text/html" id="barDemo">

            <a class="layui-btn layui-btn-xs" lay-event="edit_question">编辑</a>
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
        var clientWidth=$(window).width();
        var clientHeight=$(window).height();
        table.render({
            id:'test',
            elem: '#test'
            ,url:'question_lists?list=1'
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
                {type:'numbers',  title: '编号'}
                ,{field:'question', align:'center',  title: '试卷标题'}
                ,{field:'option_a', align:'center',  title: '选项A'}
                ,{field:'option_b', align:'center',  title: '选项B'}
                ,{field:'option_c', align:'center',  title: '选项C'}
                ,{field:'option_d', align:'center',  title: '选项D'}
                ,{field:'true_option', align:'center',  title: '答案'}
                ,{fixed: 'right',width:100,  align:'center', toolbar: '#barDemo',title:'操作'}
            ]]
        });



        table.on('tool(test)', function(obj){
            var data = obj.data;

            if(obj.event === 'edit_question'){
                var index = layer.open({
                    type: 2,
                    shade: [0.1],
                    title:"修改编辑操作",
                    area: [clientWidth*.7+'px', clientHeight*.6+'px'],
                    maxmin: true,
                    content: 'question_edit?id='+data.id,
                    btn: ['保存','关闭'],
                    zIndex: layer.zIndex, //重点1
                    yes: function(index){
                        var row= window["layui-layer-iframe" + index].callbackdata();
                        if(!$.trim(row)){
                            return false;
                        }
                        layer.closeAll();
                        $.ajax({
                            url:"question_edit",
                            type:"post",
                            dataType: "json",
                            cache: false,
                            data:row,
                            contentType: "application/x-www-form-urlencoded; charset=utf-8",
                            success:function(data){
                                if(data.code==1){
                                    layer.msg(data.msg,{icon: data.code,time: 2000},function(){$(".layui-laypage-btn").click();});
                                }else{
                                    layer.msg(data.msg, { icon: data.code});
                                }
                            }
                        });
                    },
                    cancel: function(){
                    },
                    end: function(){ //此处用于演示
                    }
                });
            } else if(obj.event === 'del'){
                layer.confirm('确定删除吗', function(index){
                    $.ajax({
                        url: "question_del" ,
                        data: {'id':data.id} ,
                        type: "post" ,
                        dataType:'json',
                        success:function(data){
                            layer.msg(data.msg, {icon: data.code},function(){$(".layui-laypage-btn").click();});
                        }
                    })
                });
            }
        });

        $(document).on('click','#add',function(){
            var index = layer.open({
                type: 2,
                shade: [0.1],
                title:"添加/编辑",
                area: [clientWidth*.7+'px', clientHeight*.6+'px'],
                maxmin: true,
                content: 'question_add',
                btn: ['保存','关闭'],
                zIndex: layer.zIndex, //重点1
                yes: function(index){
                    var row= window["layui-layer-iframe" + index].callbackdata();
                    if(!$.trim(row)){
                        return false;
                    }
                    $.ajax({
                        url:"question_add",
                        type:"post",
                        dataType: "json",
                        cache: false,
                        data:row,
                        contentType: "application/x-www-form-urlencoded; charset=utf-8",
                        success:function(data){
                            layer.closeAll();
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