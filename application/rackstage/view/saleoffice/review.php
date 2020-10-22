<link rel="stylesheet" href="_CSS_/layui.css">
{include file="public/header" /}
<style>
    .layui-table-cell span{
        height: 2em;display:block;overflow:hidden;}
    </style>
<script type="text/html" id="suggest">
    {{d.suggest}}
</script>
<div class="layui-body">
    <!-- 内容主体区域 -->
    <div style="padding: 15px;">
        <div class="demoTable">
            <div class="layui-input-inline layui-form" style="">
                <select id="search_field" name="search_field" lay-search>
                    <option value="">可输入可选择</option>
                    {volist name="project" id="vo"}
                    <option value="{$vo.id}">{$vo.name}</option>
                    {/volist}
                </select>
            </div>
            <div class="layui-input-inline layui-form" style="">
                <select id="user_id" name="user_id" lay-search>
                    <option value="">可输入可选择</option>
                    {volist name="user" id="vo"}
                    <option value="{$vo.id}">{$vo.user_name}</option>
                    {/volist}
                </select>
            </div>
            <button class="layui-btn search" data-type="reload" style="">搜索项目</button>
            <button class="layui-btn" id="add" >添加</button>
                                                <button type="reset" class="layui-btn" id="reset">重置</button>

            <button type="button" class="layui-btn" id="test3" style="width:150px;"  ><i class="layui-icon"></i>导入数据</button>

            <button class="layui-btn layui-btn-normal" onclick="javascript:window.location.replace('/rackstage/Saleoffice/review_search');" >回访查询</button>
        </div>
        <table class="layui-hide"  lay-filter="test" id="test"></table>
        <script type="text/html" id="barDemo">
            {if condition="($_SESSION['think']['role_title'] eq '项目负责人')OR($_SESSION['think']['role_title'] eq '项目经理')"}
            <a class="layui-btn layui-btn-xs layui-btn-normal" lay-event="see">查看</a>
            {else /}
            <a class="layui-btn layui-btn-xs layui-btn-normal" lay-event="see">查看</a>
            <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
            <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
            {/if}
        </script>

        <div id="pages" class="text-center"></div>
    </div>
</div>
<script src="/public/layui/layui.js"></script>
<script>
    layui.use(['table','layer','jquery','upload'], function(){
        var table = layui.table,
            $   = layui.jquery
            ,form = layui.form
            ,upload = layui.upload
            ,layer = layui.layer;

            upload.render({
            elem: '#test3'
            ,url: 'uploads'
            ,accept: 'file' //普通文件
            ,before: function(obj){
        var loading = layer.msg('因数据量过大,请耐心等待,请勿做其他操作', {icon: 16, shade: 0.3, time:0});
            }
            ,done: function(res){

        layer.msg('上传成功', {icon: 1},function(){location.reload();});
            }
        });
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
                ,toolbar:true
                ,url:'review?id=1'

                ,page: { //支持传入 laypage 组件的所有参数（某些参数除外，如：jump/elem） - 详见文档
                    layout: ['limit', 'count', 'prev', 'page', 'next', 'skip'] //自定义分页布局
                    //,curr: 5 //设定初始在第 5 页
                    ,limit:25 //一页显示多少条
                    ,limits:[25,50,100,9999999]//每页条数的选择项
                    ,groups: 6 //只显示 6 个连续页码
                    ,first: "首页" //不显示首页
                    ,last: "尾页" //不显示尾页

                }
                ,cols: [[
                    {type:'numbers',  title: '编号'}
                    ,{field:'department_name', align:'center',  title: '部门'}
                    ,{field:'project_name',  align:'center',  title: '项目名称'}
                    ,{field:'customer',  align:'center',  title: '客户姓名'}
                    ,{field:'phone', align:'center',  title: '客户电话'}
                    ,{field:'salesman',  align:'center',  title: '业务员'}
                    ,{field:'positive', align:'center',  title: '是否主动接待客户(是1分，否0分)'}
                    ,{field:'patient', align:'center',  title: '是否耐心回答客户的问题（是1分，否0分）'}
                    ,{field:'lucid', align:'center',  title: '客户是否清楚了解所需楼盘情况（是1分，否0分）'}
                    ,{field:'dissent', align:'center',  title: '对销售代表在接待过程中介绍的购房所产生的费用有无异议?（无1分，有0分）'}
                    ,{field:'appraise', align:'center',  title: '客户对服务评分（1-5分）'}
                    ,{field:'suggest', align:'center',  title: '对我们的服务有什么建议(包括具体的投诉和表扬，有表扬1分，无0分，投诉－1分)'}
                    ,{field:'score', align:'center',  title: '总分'}
                    ,{field:'enquirytime', align:'center',  title: '抽查时间'}
                    ,{field:'enquiryer', align:'center',  title: '抽查人'}
                    ,{field:'mark', align:'center', title: '备注'}
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
                    url: 'review?id=1'
                    ,page: {
                        curr: 1 //重新从第 1 页开始
                    }
                    ,method: 'post'
                    ,where: {
                        search_field: demoReload.val(),
                        user_id: $('#user_id').val(),

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
                    content: 'review_add?id='+data.id,
                    btn: ['保存','关闭'],
                    zIndex: layer.zIndex, //重点1
                    yes: function(index){
                        var row= window["layui-layer-iframe" + index].callbackdata();
                        if(!$.trim(row)){
                            return false;
                        }
                        console.log(11111);
                        $.ajax({
                            url:"review_add",
                            type:"post",
                            dataType: "json",
                            cache: false,
                            data:row,
                            contentType: "application/x-www-form-urlencoded; charset=utf-8",
                            success:function(data){
                                layer.closeAll();
                                if(data.code==1){
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
                layer.full(index);
            }else if(obj.event === 'see'){
                console.log(data.id);

                var index = layer.open({
                    type: 2,
                    shade: [0.1],
                    title:"添加/编辑",
                    area: [clientWidth*0.7+'px', clientHeight*0.6+'px'],
                    maxmin: true,
                    content: 'review_see?id='+data.id,
                    btn: ['关闭'],
                    zIndex: layer.zIndex, //重点1
                    yes: function(index){layer.closeAll();},
                    cancel: function(){
                    },
                    end: function(){ //此处用于演示
                    }
                });
                layer.full(index);
            } else if(obj.event === 'del'){
                layer.confirm('确定删除吗', function(index){
                    $.ajax({
                        url: "review_del" ,
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
            console.log(clientHeight);
            var index = layer.open({
                type: 2,
                shade: [0.1],
                title:"添加",
                area: [clientWidth*0.7+'px', clientHeight*0.6+'px'],
                maxmin: true,
                content: 'review_add',
                btn: ['保存','关闭'],
                zIndex: layer.zIndex, //重点1
                yes: function(index){
                    var row= window["layui-layer-iframe" + index].callbackdata();
                    if(!$.trim(row)){
                        return false;
                    }
                    $.ajax({
                        url:"review_add",
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
            layer.full(index);
        });
        //#添加end
    });

    
</script>
{include file="public/footer" /}