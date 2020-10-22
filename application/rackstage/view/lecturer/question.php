{include file="public/header" /}
    <div class="layui-body">
            <!-- 内容主体区域 -->
            <div style="padding: 15px;">
                
                <table class="layui-hide"  lay-filter="test" id="test"></table>
                <script type="text/html" id="barDemo">
                    <a class="layui-btn layui-btn-warm layui-btn-xs" lay-event="lists">查看试题</a>
                   
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
                    id:'test',
                    elem: '#test'
                    ,url:'question'
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
                        {type:'numbers', width: '5%', title: '编号'}
                        ,{field:'title', align:'center',  title: '标题'}
                        ,{field:'times', align:'center',  title: '创建日期'}
                       
                        ,{fixed: 'right', width:210, align:'center', toolbar: '#barDemo',title:'操作'}
                    ]]
                });

                /*搜索开始*/
                $('.demoTable .layui-btn').on('click', function(){
                    var type = $(this).data('type');
                    active[type] ? active[type].call(this) : '';
                });
                var $ = layui.$, active = {
                    reload: function(){
                        var demoReload = $('#contract_num');
                        //执行重载
                        table.reload('test', {
                            page: {
                                curr: 1 //重新从第 1 页开始
                            }
                            ,where: {
                                title: demoReload.val()
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

                        layer.confirm('确定删除吗', function(index){
                            $.ajax({
                                url: "tests_del" ,
                                data: {'id':data.id} ,
                                type: "post" ,
                                dataType:'json',
                                success:function(data){
                                    layer.msg(data.msg, {icon: data.code},function(){$(".layui-laypage-btn").click();});
                                }
                            })
                        });
                    }  else if(obj.event === 'lists'){
                        console.log(data.times);
                        var index = layer.open({
                            title:"列表",
                            type: 2,
                            content: "wtList?id="+data.id,
                            area: [clientWidth*0.9+'px', '650px'],
                            maxmin: true
                        });
                        layer.full(index);
                    }
                });
            });

        

        </script>


{include file="public/footer" /}