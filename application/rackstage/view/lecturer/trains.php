<link rel="stylesheet" href="/public/layui/formSelects-v4.css" media="all">

<link rel="stylesheet" href="_CSS_/layui.css">
{include file="public/header" /}
    <div class="layui-body">
            <!-- 内容主体区域 -->
            <div style="padding: 15px;">
                <div class="demoTable">
                    <div class="layui-input-inline" style="width:250px;">
                        <select id="ids" lay-filter="ids" xm-select="select7_1" xm-select-skin="danger" xm-select-search=""
                                xm-select-show-count="1">
                            <option value="">区域</option>
                            {volist name="area" id="vo"}
                            <option value="{$vo.area}">{$vo.area}</option>
                            {/volist}
                        </select>
                    </div>
                    <div class="layui-input-inline" style="width:250px;">
                        <select id="ids" lay-filter="ids" xm-select="select7_2" xm-select-skin="danger" xm-select-search=""
                                xm-select-show-count="1">
                            <option value="">课程类型</option>
                            <option value="222">岗位必修课程</option>
                            <option value="223">线上课程</option>
                            <option value="226">星星学社</option>
                            <option value="235">直销课程</option>
                        </select>
                    </div>

                    <button class="layui-btn search" data-type="reload" >搜索</button>
                    <button type="reset" class="layui-btn" id="reset">重置</button>


                    <button class="layui-btn" id="addtimely">添加课程</button>

                </div>
                <table class="layui-hide" lay-filter="test" id="test"></table>
                <script type="text/html" id="barDemo">
                    <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
                    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
                </script>
                <div id="pages" class="text-center"></div>
            </div>
        </div>
        <script src="/public/layui/layui.js"></script>
<script src="/public/layui/formSelects-v4.js" charset="utf-8"></script>

        <script>
            layui.use(['table','layer','jquery','laydate'], function(){
                var table = layui.table,
                    $   = layui.jquery
                    ,form = layui.form
                    , laydate = layui.laydate

                    ,layer = layui.layer;
                laydate.render({
                    elem: '#test6'
                    , range: true
                });
                var clientWidth=document.body.clientWidth;
                var clientHeight=document.body.clientHeight;
                var renderTable = function(){
                    table.render({
                        id:'test',
                        autoSort: true,
                        elem: '#test'
                        ,url:'Trains'
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
                            ,{field:'area', align:'center',width:'8.5%',  title: '地区'}
                            ,{field:'startdate', align:'center', title: '开课日期'}
                            ,{field:'enddate', align:'center',  title: '结束日期'}
                            ,{field:'classtype', align:'center', title: '课程类型'}
                            ,{field:'classify', align:'center',  title: '课程分类'}
                            ,{field:'classname', align:'center',  title: '课程名称'}
                            ,{field:'num_hasdone', align:'center',  title: '系统培训人数'}
                            ,{field:'num', align:'center',  title: '阅读人数'}
                            ,{field:'mark', align:'center',  title: '备注'}
                            ,{fixed: 'right', width:'12%', align:'center', toolbar: '#barDemo',title:'操作'}
                        ]]
                    });
                }
                renderTable();
                /*搜索开始*/
                $('.demoTable .layui-btn').on('click', function(){
                    var type = $(this).data('type');
                    active[type] ? active[type].call(this) : '';
                });
                var $ = layui.$, active = {
                    reload: function(){
                        table.reload('test', {
                            page: {
                                curr: 1 //重新从第 1 页开始
                            }
                            ,where: {
                                area: layui.formSelects.value('select7_1', 'val'),
                                classify: layui.formSelects.value('select7_2', 'val'),
                                date: $("#test6").val(),
                            }
                        });
                    }
                };
                $('.demoTable .layui-btn').on('click', function(){
                    var type = $(this).data('type');
                    active[type] ? active[type].call(this) : '';
                });
                /*搜索结束*/
                $(document).on('click','#reset',function(){
                    $('input').val('');
                    layui.formSelects.value('select7_1', [0]);
                    layui.formSelects.value('select7_0', [0]);
                    layui.formSelects.value('select7_2', [0]);
                    renderTable();
                });
                table.on('tool(test)', function(obj){
                    var data = obj.data;
                    if(obj.event === 'del'){
                        layer.confirm('确定删除吗', function(index){
                            $.ajax({
                                url: "outlinesDel" ,
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
                            content: 'outlineEdit?id='+data.id,
                            btn: ['发布','关闭'],
                            zIndex: layer.zIndex, //重点1
                            btn1: function(index){
                                var row= window["layui-layer-iframe" + index].callbackdata();
                                if(!$.trim(row)){
                                    return false;
                                }
                                $.ajax({
                                    url:'outlineEdit?id='+data.id,
                                    type:"post",
                                    dataType: "json",
                                    cache: false,
                                    data:row,
                                    async:true,
                                    contentType: "application/x-www-form-urlencoded; charset=utf-8",
                                    beforeSend:function()
                                    {
                                        layer.msg('努力中...', {icon: 16,shade: [0.5, '#f5f5f5'],scrollbar: false,offset: '0px', time:100000}) ;
                                    },
                                    success:function(data){
                                        if(data.code==1){
                                            layer.closeAll();
                                            layer.msg(data.msg,{icon:1,time: 1000},function () {
                                                renderTable();//location.reload();
                                            });
                                        }else{
                                            layer.msg(data.msg, { icon: 0});
                                        }
                                    }
                                });
                            },
                            btn2: function(){
                                var row= window["layui-layer-iframe" + index].callbackdata();
                                if(!$.trim(row)){
                                    return false;
                                }
                                $.ajax({
                                    url:'/rackstage/Lecturer/outline_add?id='+data.id,
                                    type:"post",
                                    dataType: "json",
                                    cache: false,
                                    data:row,
                                    async:true,
                                    contentType: "application/x-www-form-urlencoded; charset=utf-8",
                                    beforeSend:function()
                                    {
                                        layer.msg('努力中...', {icon: 16,shade: [0.5, '#f5f5f5'],scrollbar: false,offset: '0px', time:100000}) ;
                                    },
                                    success:function(data){
                                        if(data.code==1){
                                            layer.closeAll();
                                            layer.msg(data.msg,{icon:1,time: 1000},function () {
                                                renderTable();//location.reload();
                                            });
                                        }else{
                                            layer.msg(data.msg, { icon: 0});
                                        }
                                    }
                                });
                            },
                            btn3: function(){
                            },
                            end: function(){ //此处用于演示
                            }
                        });
                        layer.full(index);
                    }
                });

                $(document).on('click','#add',function(){
                    var index = layer.open({
                        type: 2,
                        shade: [0.1],
                        title:"添加/编辑",
                        area: [clientWidth*.7+'px', clientHeight*.6+'px'],
                        maxmin: true,
                        content: '/rackstage/Lecturer/outline_add',
                        btn: ['发布','保存','关闭'],
                        zIndex: layer.zIndex, //重点1不同
                        btn1: function(index){
                            var row= window["layui-layer-iframe" + index].callbackdata();
                            if(!$.trim(row)){
                                return false;
                            }

                            //
                            $.ajax({
                                url:"/rackstage/Lecturer/outline_add",
                                type:"post",
                                dataType: "json",
                                cache: false,
                                data:'show=1&'+row,
                                contentType: "application/x-www-form-urlencoded; charset=utf-8",
                                success:function(data){
                                    if(data.code==1){
                                        layer.closeAll();
                                        layer.msg(data.msg,{icon:1,time: 1000},function () {
                                            renderTable();//location.reload();
                                        });
                                    }else{
                                        layer.msg(data.msg, { icon: 0,time: 2000});
                                    }
                                }
                            });
                        },
                        btn2: function(index){
                            var row= window["layui-layer-iframe" + index].callbackdata();
                            if(!$.trim(row)){
                                return false;
                            }
                            //
                            $.ajax({
                                url:"/rackstage/Lecturer/outline_add",
                                type:"post",
                                dataType: "json",
                                cache: false,
                                data:row,
                                contentType: "application/x-www-form-urlencoded; charset=utf-8",
                                success:function(data){
                                    if(data.code==1){
                                        layer.closeAll();
                                        layer.msg(data.msg,{icon:1,time: 1000},function () {
                                            renderTable();//location.reload();
                                        });
                                    }else{
                                        layer.msg(data.msg, { icon: 0,time: 2000});
                                    }
                                }
                            });
                        },
                        btn3: function(){
                        },
                        end: function(){ //此处用于演示
                        }
                    });
                    layer.full(index);
                });
//课程添加end
                //岗位课添加start
                $(document).on('click','#addtimely',function(){
                    var index = layer.open({
                        type: 2,
                        shade: [0.1],
                        title:"添加/编辑",
                        area: [clientWidth*.7+'px', clientHeight*.6+'px'],
                        maxmin: true,
                        content: 'outlineAdds',
                        btn: ['发布','保存','关闭'],
                        zIndex: layer.zIndex, //重点1
                        btn1: function(index){
                            var row= window["layui-layer-iframe" + index].callbackdata();
                            if(!$.trim(row)){
                                return false;
                            }
                            $.ajax({
                                url:"outlineAdds",
                                type:"post",
                                dataType: "json",
                                cache: false,
                                data:row,
                                contentType: "application/x-www-form-urlencoded; charset=utf-8",
                                success:function(data){
                                    if(data.code==1){
                                        layer.closeAll();
                                        layer.msg(data.msg,{icon:1,time: 1000},function () {
                                            renderTable();
                                        });
                                    }else{
                                        layer.msg(data.msg, { icon: 0,time: 2000});
                                    }
                                }
                            });
                        },
                        btn2: function(){
                             var row= window["layui-layer-iframe" + index].callbackdata();
                            if(!$.trim(row)){
                                return false;
                            }
                            //
                            $.ajax({
                                url:"/rackstage/Lecturer/outline_addtimely",
                                type:"post",
                                dataType: "json",
                                cache: false,
                                data:row,
                                contentType: "application/x-www-form-urlencoded; charset=utf-8",
                                success:function(data){
                                    if(data.code==1){
                                        layer.closeAll();
                                        layer.msg(data.msg,{icon:1,time: 1000},function () {
                                            renderTable();//location.reload();
                                        });
                                    }else{
                                        layer.msg(data.msg, { icon: 0,time: 2000});
                                    }
                                }
                            });
                        },
                        btn3: function(){
                        },
                        end: function(){ //此处用于演示
                        }
                    });
                    layer.full(index);
                });
                //岗位课end
            });
        </script>


{include file="public/footer" /}