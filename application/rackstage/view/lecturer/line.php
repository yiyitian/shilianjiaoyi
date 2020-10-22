
<link rel="stylesheet" href="_CSS_/layui.css">
{include file="public/header" /}
<input id="nowtime" type="hidden" value="{$nowtime}">
<script type="text/html" id="checkboxTpl">
    {{#  if(d.startdate >'1990-01-01 00:00:00'){ }}
        {{#  if(d.startdate < document.getElementById('nowtime').value){ }}
        <input type="checkbox" name="status" value="{{d.status}}" lay-skin="switch" lay-text="已授|未授" lay-filter="statusedit" {{ d.status == 1 ? 'checked' : '' }}>
        {{#  }else{ }}
        <input type="checkbox" disabled name="status" value="{{d.status}}" lay-skin="switch" lay-text="已授|未授" lay-filter="statusedit" {{ d.status == 1 ? 'checked' : '' }}>
        {{#  } }}
    {{#  } }}
</script>

    <div class="layui-body">
            <!-- 内容主体区域 -->
            <div style="padding: 15px;">
                <div class="demoTable">
                    <div class="layui-inline" style="display:none;">
                        <input class="layui-input" name="contract_num" value="" id="contract_num" placeholder="请根据****进行搜索" autocomplete="off">
                    </div>
                    <button class="layui-btn search" data-type="reload" style="display:none;">搜索</button>
                    <button class="layui-btn" id="addtimely">添加课程</button>

                </div>
                <table class="layui-hide" lay-filter="test" id="test"></table>

                <script type="text/html" id="barDemo">
                    {{#  if(d.types !== '2'){ }}
                        {{#  if(d.status=='-1'){ }}
                            <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
                        {{#  }else{ }}
                            <a class="layui-btn layui-btn-xs layui-btn-normal" lay-event="browse">信息</a>
                        {{#  } }}
                    {{#  }else{ }}
                        {{#  if(d.status=='-1'){ }}
                            <a class="layui-btn layui-btn-xs" lay-event="edittimely">编辑</a>
                                                                                  

                        {{#  }else{ }}
                            <a class="layui-btn layui-btn-xs layui-btn-normal" lay-event="browsetimely">信息</a>


                        {{#  } }}
                    {{#  } }}
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
                var clientWidth=document.body.clientWidth;
                var clientHeight=document.body.clientHeight;
                var renderTable = function(){
                    table.render({
                        id:'test',
                        autoSort: true,
                        elem: '#test'
                        ,url:'/rackstage/Lecturer/line?id=1'
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
                            ,{field:'is_outline', align:'center',width:'8.5%',  title: '线上线下'}
                            ,{field:'area', align:'center',width:'8.5%',  title: '地区'}
                            ,{field:'startdate', align:'center', title: '开课日期'}
                            ,{field:'enddate', align:'center',  title: '结束日期'}
                            ,{field:'username', align:'center',width:'8.5%',  title: '班主任'}
                            ,{field:'classtype', align:'center', title: '课程类型'}
                            ,{field:'classify', align:'center',  title: '课程分类'}
                            ,{field:'status', title:'是否授课', width:'8.5%',align:'center', templet: '#checkboxTpl', unresize: true,event:'statusedit'}
                            ,{field:'num_hasdone', align:'center',  title: '系统培训人数'}
                            ,{field:'mark', align:'center',  title: '备注'}
                            ,{fixed: 'right', width:'12%', align:'center', toolbar: '#barDemo',title:'操作'}
                        ]]
                    });
                }
                renderTable();
				//监听排序事件 
				table.on('sort(test)', function(obj){ //注：tool是工具条事件名，test是table原始容器的属性 lay-filter="对应的值"
				  console.log(obj.field); //当前排序的字段名
				  console.log(obj.type); //当前排序类型：desc（降序）、asc（升序）、null（空对象，默认排序）
				  console.log(this); //当前排序的 th 对象
				 
				  //尽管我们的 table 自带排序功能，但并没有请求服务端。
				  //有些时候，你可能需要根据当前排序的字段，重新向服务端发送请求，从而实现服务端排序，如：
				  table.reload('test', {
					initSort: obj //记录初始排序，如果不设的话，将无法标记表头的排序状态。
					,where: { //请求参数（注意：这里面的参数可任意定义，并非下面固定的格式）
					  field: obj.field //排序字段
					  ,order: obj.type //排序方式
					}
				  });
				  
				  //layer.msg('服务端排序。order by '+ obj.field + ' ' + obj.type);
				})
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
                                url: "outline_del" ,
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
                            content: '/rackstage/Lecturer/outline_add?id='+data.id,
                            btn: ['发布','保存','关闭'],
                            zIndex: layer.zIndex, //重点1
                            btn1: function(index){
                                var row= window["layui-layer-iframe" + index].callbackdata();
                                if(!$.trim(row)){
                                    return false;
                                }
                                $.ajax({
                                    url:'/rackstage/Lecturer/outline_add?id='+data.id,
                                    type:"post",
                                    dataType: "json",
                                    cache: false,
                                    data:'show=1&'+row,
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
                    }else if(obj.event === 'edittimely'){
                        var index = layer.open({
                            type: 2,
                            shade: [0.1],
                            title:"添加/编辑",
                            area: [clientWidth*.7+'px', clientHeight*.6+'px'],
                            maxmin: true,
                            content: '/rackstage/Lecturer/outline_addtimely?id='+data.id,
                            btn: ['发布','保存','关闭'],
                            zIndex: layer.zIndex, //重点1
                            btn1: function(index){
                                var row= window["layui-layer-iframe" + index].callbackdata();
                                if(!$.trim(row)){
                                    return false;
                                }
                                $.ajax({
                                    url:'/rackstage/Lecturer/outline_addtimely?id='+data.id,
                                    type:"post",
                                    dataType: "json",
                                    cache: false,
                                    data:'show=1&'+row,
                                    async:true,
                                    contentType: "application/x-www-form-urlencoded; charset=utf-8",
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
                                    url:'/rackstage/Lecturer/outline_addtimely?id='+data.id,
                                    type:"post",
                                    dataType: "json",
                                    cache: false,
                                    data:row,
                                    async:true,
                                    contentType: "application/x-www-form-urlencoded; charset=utf-8",
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
                    } else if(obj.event === 'browse'){
                        var index = layer.open({
                            type: 2,
                            shade: [0.1],
                            title:"添加/编辑",
                            area: [clientWidth*.7+'px', clientHeight*.6+'px'],
                            maxmin: true,
                            content: '/rackstage/Lecturer/outline_add?browse=1&id='+data.id,
                            btn: ['关闭'],
                            zIndex: layer.zIndex, //重点1
                            yes: function(index){
                                layer.closeAll();
                            },
                            cancel: function(){
                            },
                            end: function(){ //此处用于演示
                            }
                        });
                    }else if(obj.event === 'tongji'){
                        var index = layer.open({
                            type: 2,
                            shade: [0.1],
                            title:"统计信息",
                            area: [clientWidth*.7+'px', clientHeight*.6+'px'],
                            maxmin: true,
                            content: '/rackstage/Lecturer/tongji?id='+data.id,
                            btn: ['关闭'],
                            zIndex: layer.zIndex, //重点1
                            yes: function(index){
                                layer.closeAll();
                            },
                            cancel: function(){
                            },
                            end: function(){ //此处用于演示
                            }
                        });
                    }else if(obj.event === 'browsetimely'){
                        var index = layer.open({
                            type: 2,
                            shade: [0.1],
                            title:"添加/编辑",
                            area: [clientWidth*.7+'px', clientHeight*.6+'px'],
                            maxmin: true,
                            content: '/rackstage/Lecturer/outline_addtimely?browse=1&id='+data.id,
                            btn: ['关闭'],
                            zIndex: layer.zIndex, //重点1
                            yes: function(index){
                                layer.closeAll();
                            },
                            cancel: function(){
                            },
                            end: function(){ //此处用于演示
                            }
                        });
                        layer.full(index);
                    }else if(obj.event === 'statusedit') {

                        if (data.enddate > document.getElementById('nowtime').value) {
                            layer.msg('课程未结束，不可修改', {icon: 0, time: 500}, function () {
                                $(".layui-laypage-btn").click();
                            });
                            return false;
                        }
                        console.log(data.status);
                        if(data.status == 1){
                            layer.msg('课程信息已累加到各位讲师，不可修改状态',{icon:0},function(){$(".layui-laypage-btn").click();});
                            return false;
                        }
                        layer.confirm('修改后不可恢复，确定修改吗', function(index) {
                            $.ajax({
                                url: "statusedit",
                                data: {'id': data.id, 'status': '1', 'times': data.times, 'is_outline': data.is_outline},
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
                        content: '/rackstage/Lecturer/outline_addtimely',
                        btn: ['发布','保存','关闭'],
                        zIndex: layer.zIndex, //重点1
                        btn1: function(index){
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