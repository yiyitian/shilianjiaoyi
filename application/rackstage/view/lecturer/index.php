
<link rel="stylesheet" href="_CSS_/layui.css">
{include file="public/header" /}

<script type="text/html" id="checkboxTpl">
    <input type="checkbox" name="status" value="{{d.status}}" lay-skin="switch" lay-text="是|否" lay-filter="sexDemo" {{ d.status == 1 ? 'checked' : '' }}>
</script>
<script type="text/html" id="checkboxTp2">
        <input type="checkbox" name="is_verified" value="{{d.is_verified}}" lay-skin="switch" lay-text="是|否" lay-filter="sexDemo" {{ d.is_verified == 1 ? 'checked' : '' }}>
</script>
    <div class="layui-body">
            <!-- 内容主体区域 -->
            <div style="padding: 15px;">
                <div class="demoTable">
                    <div class="layui-inline">
                        <input class="layui-input" name="contract_num" value="" id="contract_num" placeholder="请根据员工姓名进行搜索" autocomplete="off">
                    </div>
                    <div class="layui-input-inline layui-form" style="">
                        <select id="types" name="types" lay-search>
                            <option value="">请选择讲师类型</option>
                            <option value="销售讲师">销售讲师</option>
                            <option value="策划讲师">策划讲师</option>
                        </select>
                    </div>
                    <button class="layui-btn search" data-type="reload">搜索</button>
                    <button class="layui-btn" id="add">添加</button>
                                            <button type="reset" class="layui-btn" id="reset">重置</button>

                </div>
                <table class="layui-hide"  lay-filter="test" id="test"></table>
                <script type="text/html" id="barDemo">
                    
                    <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
                    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del" >删除</a>
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
                var tableRender = function() {
                table.render({
                    id:'test',
                    elem: '#test'
                    ,url:'/rackstage/lecturer/index?id=1'
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
                        ,{field:'username', align:'center',width:'8.5%',  title: '员工姓名'}
                        ,{field:'types', align:'center',width:'9.5%',  title: '类别'}
                        ,{field:'levels', align:'center',width:'9.5%',  title: '级别'}
                        ,{field:'mark', align:'center',  title: '备注'}
                        ,{fixed: 'right', width:120, align:'center', toolbar: '#barDemo',title:'操作'}
                    ]]
                });
            }
            tableRender();
            $(document).on('click','#reset',function(){
            $('input').val('');
            $('select').val('');
            tableRender();
        });

                /*搜索开始*/
                $('.demoTable .layui-btn').on('click', function(){
                    var type = $(this).data('type');
                    active[type] ? active[type].call(this) : '';
                });
                var $ = layui.$, active = {
                    reload: function(){
                        var demoReload = $('#contract_num');
                        table.reload('test', {
                            page: {
                                curr: 1 //重新从第 1 页开始
                            }
                            ,method: 'post'
                            ,where: {
                                username: demoReload.val(),
                                types: $('#types').val()
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
                                url: "del" ,
                                data: {'id':data.id} ,
                                type: "post" ,
                                dataType:'json',
                                success:function(data){
                                    layer.msg(data.msg, {icon: data.code},function(){$(".layui-laypage-btn").click();});
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
                            content: '/rackstage/Lecturer/edit?id='+data.users_id,
                            btn: ['保存','关闭'],
                            zIndex: layer.zIndex, //重点1
                            yes: function(index){
                                var row= window["layui-layer-iframe" + index].callbackdata();
                                if(!$.trim(row)){
                                    return false;
                                }
                                layer.closeAll();
                                $.ajax({
                                    url:'/rackstage/Lecturer/edit',
                                    type:"post",
                                    dataType: "json",
                                    cache: false,
                                    data:row,
                                    contentType: "application/x-www-form-urlencoded; charset=utf-8",
                                    success:function(data){
                                        if(data.code==1){
                                            layer.msg(data.msg,{icon:1,time: 500},function () {
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
                $(document).on('click','#add',function(){
                    var index = layer.open({
                        type: 2,
                        shade: [0.1],
                        title:"添加/编辑",
                        area: [clientWidth*.7+'px', clientHeight*.6+'px'],
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
                                        layer.msg(data.msg,{icon:1,time:500},function () {
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