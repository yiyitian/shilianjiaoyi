
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
            <div class="layui-input-inline layui-form" style="">
                <select id="userName" name="userName" lay-search>
                    <option value="">根据申请人搜索</option>
                    {volist name="userName" id="vo"}
                        <option value="{$vo.username}">{$vo.username}</option>
                    {/volist}
                </select>
            </div>
            <div class="layui-input-inline layui-form" style="">
                <select id="className" name="className" lay-search>
                    <option value="">请选择培训类型</option>
                    {volist name="className" id="vo"}
                    <option value="{$vo.className}">{$vo.className}</option>
                    {/volist}
                </select>
            </div>
            <div class="layui-input-inline layui-form" style="">
                <select id="ban" name="ban" lay-search>
                    <option value="">请选择培训人</option>
                    {volist name="ban" id="vo"}
                    <option value="{$vo.ban}">{$vo.ban}</option>
                    {/volist}

                </select>
            </div>
            <div class="layui-input-inline layui-form" style="">
                <select id="start_date" name="start_date" lay-search>
                    <option value="">培训开始时间</option>
                    {volist name="start_date" id="vo"}
                    <option value="{$vo.start_date}">{$vo.start_date}</option>
                    {/volist}

                </select>
            </div>

            <button class="layui-btn search" data-type="reload">搜索</button>
            <button type="reset" class="layui-btn" id="reset">重置</button>

        </div>
        <script type="text/html" id="oper-col">
    
                <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>


    </script>
        <table class="layui-hide"  lay-filter="test" id="test"></table>

        <div id="pages" class="text-center"></div>
    </div>
</div>
<script src="/public/layui/layui.js"></script>
<script>
    layui.use(['table','layer','jquery','laydate'], function(){
        var table = layui.table,
            $   = layui.jquery
            ,form = layui.form
            ,laydate = layui.laydate
            ,layer = layui.layer;
        laydate.render({
            elem: '#test6'
            ,range: true
        });
        var clientWidth=document.body.clientWidth;
        var clientHeight=document.body.clientHeight;
        var tableRender = function() {
            table.render({
                toolbar:true
                 ,id:'test',
                elem: '#test'
                ,url:'apply'
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
                    ,{field:'username', align:'center',width:'9.5%',  title: '申请者名称'}
                    ,{field:'work_id', align:'center',width:'9.5%',  title: '工号'}
                    ,{field:'department_name', align:'center',width:'9.5%',  title: '部门'}
                    ,{field:'station_name', align:'center',width:'9.5%',  title: '岗位'}
                    ,{field:'project', align:'center',width:'9.5%',  title: '项目'}
                    ,{field:'card', align:'center',width:'9.5%',  title: '身份证号',hide:true}
                    ,{field:'start_date', align:'center',width:'9.5%',  title: '入住时间',hide:true}
                    ,{field:'end_date', align:'center',width:'9.5%',  title: '离开时间',hide:true}
                    ,{field:'className', align:'center',width:'9.5%',  title: '培训名称'}
                    ,{field:'ban', align:'center',width:'9.5%',  title: '培训发起人'}
                    ,{field:'startime', align:'center',width:'9.5%',  title: '培训时间'}
                    ,{field:'status', title:'是否通过', width:'8.5%',align:'center', templet: '#checkboxTpl', unresize: true,event:'statusedit'}
                    ,{field:'mark', align:'center',  title: '备注'}
                                        ,{templet: '#oper-col',align:'center', title: '操作'}

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
                var userName = $('#userName').val()
                    ,ban     = $('#ban').val()
                    ,className     = $('#className').val()
                    ,start_date     = $('#start_date').val();
                table.reload('test', {
                    page: {
                        curr: 1 //重新从第 1 页开始
                    }
                    ,method: 'post'
                    ,where: {
                        username: userName,
                        ban: ban,
                        className: className,
                        start_date: start_date,
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
                        url: "delApply" ,
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
            }else if(obj.event === 'statusedit') {


                layer.confirm('确定通过吗', function(index) {
                    $.ajax({
                        url: "applyStatus",
                        data: {'id': data.id, 'status': data.status},
                        type: "post",
                        dataType: 'json',
                        success: function (data) {
                            layer.msg(data.msg, {icon: data.code}, function () {
                                $(".layui-laypage-btn").click();
                            });
                        }
                    })
                })
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