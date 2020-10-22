{include file="public/header" /}

<style>
    .layui-table-cell{height:auto;white-space: normal;}
</style>
<div class="layui-body">
    <!-- 内容主体区域 -->
    <div style="padding: 15px;">
        <div class="demoTable">
            <div class="layui-input-inline layui-form" style="">
                <input class="layui-input" id="search_field" name="search_field" placeholder="根据姓名搜索" />

            </div>
            <button class="layui-btn search" data-type="reload" style="">搜索</button>
            <button class="layui-btn" id="add" >添加</button>
                                                <button type="reset" class="layui-btn" id="reset">重置</button>

        </div>
        <table class="layui-hide"  lay-filter="test" id="test"></table>
        <script type="text/html" id="barDemo">
                <a class="layui-btn layui-btn-xs layui-btn-normal" lay-event="see">查看</a>
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
        var clientWidth=$(window).width();
        var clientHeight=$(window).height();
        $(document).on('click','#reset',function(){
            $('input').val('');
            $('select').val('');
            renderTable();
        });
		var renderTable = function(){
			table.render({
				id:'test'
				,elem: '#test'
                ,toolbar:true
				,url:'?id=1'

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
					{type:'numbers',  title: '编号'}
                    ,{field:'area',width:80, align:'center',  title: '地区'}
                    ,{field:'createtime',width:120,  align:'center',  title: '提报日期'}
                    ,{field:'username',width:120,  align:'center',  title: '姓名'}
					,{field:'lastweek',   title: '本周工作'}
					,{field:'thisweek',   title: '下周计划'}
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
                    url: '?id=1'
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
            if(obj.event === 'edit'){
                console.log(data.id);

                var index = layer.open({
                    type: 2,
                    shade: [0.1],
                    title:"添加/编辑",
                    area: [clientWidth*0.7+'px', clientHeight*0.6+'px'],
                    maxmin: true,
                    content: 'work_add?id='+data.id,
                    btn: ['保存','关闭'],
                    zIndex: layer.zIndex, //重点1
                    yes: function(index){
                        var row= window["layui-layer-iframe" + index].callbackdata();
                        if(!$.trim(row)){
                            return false;
                        }
                        console.log(data.id);
                        $.ajax({
                            url:"work_add",
                            type:"post",
                            dataType: "json",
                            cache: false,
                            data:row,
                            contentType: "application/x-www-form-urlencoded; charset=utf-8",
                            success:function(data){
                                layer.closeAll();
                                if(data.code==1){
                                    layer.msg(data.msg,{icon:1,time: 1000},function () {
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

            }else if(obj.event === 'see'){
                console.log(data.id);

                var index = layer.open({
                    type: 2,
                    shade: [0.1],
                    title:"添加/编辑",
                    area: [clientWidth*0.7+'px', clientHeight*0.6+'px'],
                    maxmin: true,
                    content: 'work_see?id='+data.id,
                    btn: ['关闭'],
                    zIndex: layer.zIndex, //重点1
                    yes: function(index){layer.closeAll();},
                    cancel: function(){
                    },
                    end: function(){ //此处用于演示
                    }
                });

            } else if(obj.event === 'del'){
                layer.confirm('确定删除吗', function(index){
                    $.ajax({
                        url: "work_del" ,
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
                area: [clientWidth*0.7+'px', clientHeight*0.6+'px'],
                maxmin: true,
                content: 'work_add',
                btn: ['保存','关闭'],
                zIndex: layer.zIndex, //重点1
                yes: function(index){
                    var row= window["layui-layer-iframe" + index].callbackdata();
                    if(!$.trim(row)){
                        return false;
                    }
                    $.ajax({
                        url:"work_add",
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
        });
		//#添加end
    });

    
</script>
{include file="public/footer" /}