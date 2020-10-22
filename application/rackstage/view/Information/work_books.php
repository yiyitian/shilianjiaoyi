{include file="public/header" /}
<link rel="stylesheet" href="/public/layui/formSelects-v4.css" media="all">

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
            <div class="layui-input-inline" style="width:200px;">
                <select name="month" lay-filter="project" xm-select="select7_4" xm-select-skin="danger"
                        xm-select-search="" xm-select-show-count="1">
                    <option value="">请选择时间</option>
                    {volist name="timeType" id="vo"}
                    <option value="{$vo.title}">{$vo.title}</option>
                    {/volist}
                </select>
            </div>
            <div class="layui-input-inline" style="width:200px;">
                <select name="department" lay-filter="department" xm-select="select7_3" xm-select-skin="danger"
                        xm-select-search="" xm-select-show-count="1">
                    <option value="">请选择部门</option>
                    {volist name="department" id="vo"}
                    <option value="{$vo.id}">{$vo.name}</option>
                    {/volist}
                </select>
            </div>
            <div class="layui-input-inline" style="width:200px;">
                <select name="projects" lay-filter="projects" xm-select="select7_2" xm-select-skin="danger"
                        xm-select-search="" xm-select-show-count="1">
                    <option value="">请选择项目</option>

                </select>
            </div>
            <button class="layui-btn search" data-type="reload" style="">搜索</button>
                                                <button type="reset" class="layui-btn" id="reset">重置</button>

        </div>
        <table class="layui-hide"  lay-filter="test" id="test"></table>
        <script type="text/html" id="barDemo">
            <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
        </script>
        <div id="pages" class="text-center"></div>
    </div>
</div>
<script src="/public/layui/layui.js"></script>
<script src="/public/layui/formSelects-v4.js" charset="utf-8"></script>

<script>
    layui.config({
        base: './' //此处路径请自行处理, 可以使用绝对路径
    }).extend({
        formSelects: 'formSelects-v4'
    });
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
        layui.formSelects.opened('select7_2', function(id){
            val=layui.formSelects.value('select7_3', 'val');    //取值val字符串
            $.ajax({
                url: "/rackstage/Getinfo/getProject" ,
                data: {'pid':val} ,
                type: "get" ,
                dataType:'json',
                success:function(data){
                    console.log(data);
                    project=data;
                    var formSelects = layui.formSelects;
                    formSelects.data('select7_2', 'local', {
                        arr: data
                    });
                }
            });
            console.log(val);
        });
        var renderTable = function(){
            table.render({
                id:'test'
                ,elem: '#test'
                ,toolbar:true
                ,url:'work_books?id=1'
                ,page: { //支持传入 laypage 组件的所有参数（某些参数除外，如：jump/elem） - 详见文档
                    layout: ['limit', 'count', 'prev', 'page', 'next', 'skip'] //自定义分页布局
                    ,limit:25 //一页显示多少条
                    ,limits:[25,50,100,999999]//每页条数的选择项
                    ,groups: 6 //只显示 6 个连续页码
                    ,first: "首页" //不显示首页
                    ,last: "尾页" //不显示尾页
                }
                ,cols: [[
                    {type:'numbers',  title: '编号'}
                    ,{field:'title', align:'center',  title: '时间'}
                    ,{field:'uname', align:'center',  title: '姓名'}
                    ,{field:'department_name',align:'center',  title: '部门'}
                    ,{field:'station_name',  align:'center',  title: '岗位'}
                    ,{field:'project_name',  align:'center',  title: '项目名称'}
                    ,{field:'content', align:'center',  title: '计划书内容'}
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
                        title: layui.formSelects.value('select7_4', 'val'),    //取值val字符串
                        department: layui.formSelects.value('select7_3', 'val'),    //取值val字符串
                        projects: layui.formSelects.value('select7_2', 'val'),    //取值val字符串
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
                        url: "WorkBookDel" ,
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