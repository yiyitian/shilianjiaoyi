<link rel="stylesheet" href="_CSS_/layui.css">
{include file="public/header" /}

<script type="text/html" id="checkboxTp2">
    <input type="checkbox" name="status" value="{{d.status}}" lay-skin="switch" lay-text="显示|隐藏" lay-filter="sexDemo" {{ d.status == 1 ? 'checked' : '' }}>
</script>
<div class="layui-body">
    <!-- 内容主体区域 -->
    <div style="padding: 15px;">
        <div class="demoTable">
            <div class="layui-input-inline" style="">
                <input class="layui-input" name="search_field" value="" id="search_field" placeholder="请根据项目名称搜索" autocomplete="off">
            </div>
            <button class="layui-btn search" data-type="reload" style="">搜索项目</button>
                                                <button type="reset" class="layui-btn" id="reset">重置</button>

            {if condition="($_SESSION['think']['role_title'] eq '总管理员') OR ($_SESSION['think']['role_title'] eq '数据收集（胡月）') OR ($_SESSION['think']['role_title'] eq '王丹')"}
            <button class="layui-btn layui-btn-danger" id="settime" >设置收集时间</button>
            {/if}
        </div>
        <table class="layui-hide"  lay-filter="test" id="test"></table>
        <script type="text/html" id="barDemo">
            <a class="layui-btn layui-btn-xs" lay-event="weekinfo">周报列表</a>
            <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="monthinfo">月报列表</a>
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
				id:'test'
				,elem: '#test'
				,url:'pro_list?id=1'

				,page: { //支持传入 laypage 组件的所有参数（某些参数除外，如：jump/elem） - 详见文档
					layout: ['limit', 'count', 'prev', 'page', 'next', 'skip'] //自定义分页布局
					//,curr: 5 //设定初始在第 5 页
					,limit:25 //一页显示多少条
					,limits:[25,50,100]//每页条数的选择项
					,groups: 5 //只显示 2 个连续页码
					,first: "首页" //不显示首页
					,last: "尾页" //不显示尾页

				}
				,cols: [[
					{type:'numbers', minWidth: 20, title: '编号'}
					,{field:'name',  align:'center',  title: '项目名称'}
					,{field:'department', align:'center',  title: '部门'}
					,{field:'mark', align:'center', title: '备注'}
					,{fixed: 'right', width:222, align:'center', toolbar: '#barDemo',title:'操作'}
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
                    url: 'pro_list?id=1'
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
            if(obj.event === 'weekinfo'){
                console.log(data.id);
                var index = layer.open({
                    title:"列表",
                    type: 2,
                    content: "weekinfo?pro_id="+data.id,
                    area: [clientWidth*0.9+'px', '650px'],
                    maxmin: true
                });
                layer.full(index);

            }else if(obj.event === 'monthinfo'){
                console.log(data.id);
                var index = layer.open({
                    title:"列表",
                    type: 2,
                    content: "monthinfo?pro_id="+data.id,
                    area: [clientWidth*0.9+'px', '650px'],
                    maxmin: true
                });
                layer.full(index);

            }else if(obj.event === 'checkStatusPosts'){
                $.ajax({
                    url: "checkStatusPosts" ,
                    data: {'id':data.id,'status':data.status} ,
                    type: "post" ,
                    dataType:'json',
                    success:function(data){
                        layer.msg(data.msg, {icon: data.code},function(){renderTable();});
                    }
                })
            }
        });
		$(document).on('click','#settime',function(){
            var index = layer.open({
                type: 2,
                shade: [0.1],
                title:"设置",
                area: ['750px', '550px'],
                maxmin: true,
                content: 'settime?type=1',
                btn: ['保存','关闭'],
                zIndex: layer.zIndex, //重点1
                yes: function(index){
                    var row= window["layui-layer-iframe" + index].callbackdata();
                    if(!$.trim(row)){
                        return false;
                    }
                    layer.closeAll();
                    $.ajax({
                        url:"settime",
                        type:"post",
                        dataType: "json",
                        cache: false,
                        data:row,
                        contentType: "application/x-www-form-urlencoded; charset=utf-8",
                        success:function(data){
                            if(data.code==1){
                                layer.msg(data.msg,{time: 2000},function () {
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