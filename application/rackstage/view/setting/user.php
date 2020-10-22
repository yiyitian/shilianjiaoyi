
{include file="public/header" /}

<script type="text/html" id="checkboxTp2">
    
	<input type="checkbox" name="status" value="{{d.status}}" lay-skin="switch" lay-text="在职|离职" lay-filter="lockDemo" {{ d.status == 1 ? 'checked' : '' }}>
</script>
<div class="layui-body">
    <!-- 内容主体区域 -->
    <div style="padding: 15px;">
        <div class="demoTable">
            <div class="layui-input-inline" style="">
                <input class="layui-input" name="search_field" value="" id="search_field" placeholder="请根据用户名搜索" autocomplete="off">
            </div>
            <button class="layui-btn search" data-type="reload" style="">搜索用户</button>
            <button class="layui-btn"  id="add">添加用户</button>
                                                <button type="reset" class="layui-btn" id="reset">重置</button>

        </div>
        <table class="layui-hide"  lay-filter="test" id="test"></table>
        <script type="text/html" id="barDemo">
            <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
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
        var clientWidth=$(window).width();
        var clientHeight=$(window).height();
		var renderTable = function(){
        table.render({
            elem: '#test'
            ,url:'user?id=1'
            
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
                 {type:'numbers',align:'center', title: '编号'}
                ,{field:'user_name',align:'center',  title: '用户名'}
                ,{field:'username',align:'center',  title: '员工姓名'}
                ,{field:'station',align:'center',  title: '岗位'}
                ,{field:'work_id',align:'center',  title: '员工工号'}
                ,{field:'role_title', align:'center', title: '角色'}
                ,{field:'mark',align:'center', title: '备注'}
                ,{field:'status',align:'center',  title:'启用', templet: '#checkboxTp2', unresize: true,event:'is_status'}
                ,{fixed: 'right',align:'center', toolbar: '#barDemo',title:'操作'}
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
                    url: 'user?id=1'
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
        /*搜索结束*/
        table.on('tool(test)', function(obj){
            var data = obj.data;
            if(obj.event === 'del'){
                layer.confirm('确定删除吗', function(index){
                    $.ajax({
                        url: "del_user" ,
                        data: {'id':data.id} ,
                        type: "post" ,
                        dataType:'json',
                        success:function(data){
                            layer.msg('删除成功', {icon: 1},function(){
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
                    content: 'edit_user?id='+data.id,
                    btn: ['保存','关闭'],
                    zIndex: layer.zIndex, //重点1
                    yes: function(index){
                        var row= window["layui-layer-iframe" + index].callbackdata();
                        if(!$.trim(row)){
                            return false;
                        }
                        layer.closeAll();
                        $.ajax({
                            url:"edit_user",
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
            }else if(obj.event === 'is_status'){
                if(data.is_technology==='1'){layer.msg('已经通过审核，无需再次操作');return false;}
                layer.confirm('确认启用操作？', function(index){
                    $.ajax({
                        url: "edit_user_status" ,
                        data: {'id':data.id,'status':data.status} ,
                        type: "post" ,
                        dataType:'json',
                        success:function(data){
                            layer.msg(data.info, {icon: data.msg},function(){
								renderTable();//$(".layui-laypage-btn").click();
								});
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
                content: 'add_user',
                btn: ['保存','关闭'],
                zIndex: layer.zIndex, //重点1
                yes: function(index){
                    var row= window["layui-layer-iframe" + index].callbackdata();
                    if(!$.trim(row)){
                        return false;
                    }

                    $.ajax({
                        url:"add_user",
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
        });
		//添加end
    });

    layui.use(['table','layer','jquery'], function(){
        var $ = layui.jquery, layer = layui.layer,table= layui.table;
        
    });
</script>
{include file="public/footer" /}