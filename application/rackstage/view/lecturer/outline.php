
<link rel="stylesheet" href="/public/layui/formSelects-v4.css" media="all">
<link rel="stylesheet" href="_CSS_/layui.css">
<script src="http://code.jquery.com/jquery-2.1.1.min.js"></script>

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
                    <div class="layui-input-inline" style="width:200px;">
                        <select id="ids" lay-filter="ids" xm-select="select7_0" xm-select-skin="danger" xm-select-search=""
                                xm-select-show-count="1">
                            <option value="">班主任</option>
                            {volist name="users" id="vo"}
                            <option value="{$vo.username}">{$vo.username}</option>
                            {/volist}
                        </select>
                    </div>
                    <div class="layui-input-inline" style="width:200px;">
                        <select id="ids" lay-filter="ids" xm-select="select7_1" xm-select-skin="danger" xm-select-search=""
                                xm-select-show-count="1">
                            <option value="">区域</option>
                            {volist name="area" id="vo"}
                            <option value="{$vo.area}">{$vo.area}</option>
                            {/volist}
                        </select>
                    </div>
                    <div class="layui-input-inline" style="width:300px;">
                        <select id="ids" lay-filter="ids" xm-select="select7_2" xm-select-skin="danger" xm-select-search=""
                                xm-select-show-count="1">
                            <option value="">培训类型</option>
                            {volist name="classify" id="vo"}
                            <option value="{$vo.id}">{$vo.title}</option>
                            {/volist}
                        </select>
                    </div>

                    <div class="layui-input-inline" style="">
                        <input class="layui-input" name="create_at" value="" id="test6" placeholder="请选择日期" autocomplete="off">
                    </div>
                    <button class="layui-btn search" data-type="reload">搜索</button>
                                        <button type="reset" class="layui-btn" id="reset">重置</button>

                    <button class="layui-btn" id="add">添加课程</button>

                </div>
                <button type="button" id="importModel" class="layui-hide">导入111路径点</button>
                <button type="button" id="importModels" class="layui-hide">导入111路径点</button>

                <table class="layui-hide" lay-filter="test" id="test"></table>

                <script type="text/html" id="barDemo">

                    {{#  if(d.types !== '2'){ }}

                        {{#  if(d.status=='-1'){ }}
                    {{#  if(d.files=='-1'){ }}
                    <a class="layui-btn layui-btn-xs" lay-event="updateFile">更新试卷</a>
                    {{#  }else{ }}
                    <a class="layui-btn layui-btn-xs layui-btn-disabled" lay-event="updateFiles">试卷已更新</a>

                    {{#  } }}
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
<script src="/public/layui/formSelects-v4.js" charset="utf-8"></script>
<script>
    layui.config({
        base: './' //此处路径请自行处理, 可以使用绝对路径
    }).extend({
        formSelects: 'formSelects-v4'
    });
            function uploads() {
                layui.use('upload', function () {
                    var upload = layui.upload;
                    var uploadInst = upload.render({
                        elem: '#test3'
                        , url: '/rackstage/Employee/upload?type=1' //改成您自己的上传接口
                        , accept: 'file' //普通文件
                        , exts: 'xls|csv|xlsx' //只允许上传压缩文件
                        , done: function (res) {
                            layer.msg(res.msg, {icon: res.code, time: 3000}, function () {
                                setTimeout(function () {
                                    window.location.reload();
                                }, 666)

                            });
                            console.log(res)
                        }
                    })
                })
            }

            layui.use(['table','layer','jquery','laydate'], function(){
                var table = layui.table,
                    $   = layui.jquery
                    , laydate = layui.laydate

                    ,form = layui.form
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
                        ,url:'/rackstage/Lecturer/outline?id=1'
                            ,totalRow: true
                            ,toolbar: true

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
                            ,{field:'username', align:'center',width:'8.5%',  title: '班主任'}
                            ,{field:'classtype', align:'center', title: '课程类型'}
                            ,{field:'classify', align:'center',  title: '课程分类'}
                            ,{field:'status', title:'是否授课', width:'8.5%',align:'center', templet: '#checkboxTpl', unresize: true,event:'statusedit'}
                            ,{field:'is_zheng', align:'center',  title: '提交身份证'}
                            ,{field:'real_number', align:'center', edit: 'text',  title: '实际上课数'}
//                            ,{field:'feedbacks', align:'center',width:'10%',  title: '通知反馈',templet: function(d){
//                                    var commonOperations = '';
//                                    if (d.feedbacks == 0){
//                                        return commonOperations +
//                                            '<button type="button" class="layui-btn layui-btn-xs" onclick=importWaypointModel("'+d.id+'")>上传反馈</button>';
//                                    }else{
//                                        return commonOperations +
//                                            '<button type="button" class="layui-btn layui-btn-xs layui-btn-warm"  onclick=viewPpt("'+d.feedbacks+'")>查看反馈</a>';
//                                    }
//                                }}
//                                ,{field:'reports', align:'center',width:'10%',  title: '回访报告',templet: function(d){
//                                    var commonOperations = '';
//                                    if (d.reports == 0){
//                                        return commonOperations +
//                                            '<button type="button" class="layui-btn layui-btn-xs" onclick=importWaypointModels("'+d.id+'")>上传报告</button>';
//                                    }else{
//                                        return commonOperations +
//                                            '<button type="button" class="layui-btn layui-btn-xs layui-btn-warm"  onclick=viewPpt("'+d.reports+'")>查看报告</a>';
//                                    }
//                                }}
                            {eq name="show" value="1"}
                             ,{field:'price', align:'center',  title: '培训单价' ,edit: 'text'}
                            {/eq}
                                                        ,{field:'mark', align:'center', edit: 'text', title: '备注'}

                            ,{fixed: 'right', width:'15%', align:'center', toolbar: '#barDemo',title:'操作'}
                        ]]
                    });
                }
                renderTable();
            table.on('edit(test)', function(obj){
               var value = obj.value //得到修改后的值
                , data = obj.data //得到所在行所有键值
                , field = obj.field; //得到字段
                layer.confirm('确定更新吗?', function(index){
                    $.ajax({
                        url: "editPrice" ,
                        data: { 'id': data.id,
                            'field': field,
                            'value': value,
                        } ,
                        type: "post" ,
                        dataType:'json',
                        success:function(data){
                            layer.msg(data.msg, {icon: data.code},function(){$(".layui-laypage-btn").click();});
                        }
                    })

                });

            });
            $(document).on('click','#reset',function(){
        $('input').val('');
        layui.formSelects.value('select7_1', [0]);
        layui.formSelects.value('select7_0', [0]);
        layui.formSelects.value('select7_2', [0]);
        renderTable();
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
                            url: 'classSearchInfo'
                            , page: {
                                curr: 1 //重新从第 1 页开始
                            }
                            , method: 'post'
                            ,where: {
                                username: layui.formSelects.value('select7_0', 'val'),
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
                    } else if(obj.event === 'updateFile'){
                        layer.confirm('确定更新试题吗？', function(index){
                            $.ajax({
                                url: "updateQuestion" ,
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
    importWaypointModel = function(pathId)
    {
        var btn = document.getElementById("importModel");
        $.ajax({
            url: "setFid" ,
            data: {'id':pathId} ,
            type: "get" ,
            dataType:'json',
            success:function(data){
            }
        })
        btn.click();
    }

    importWaypointModels = function(pathId)
    {
        var btn = document.getElementById("importModels");
        $.ajax({
            url: "setRid" ,
            data: {'id':pathId} ,
            type: "get" ,
            dataType:'json',
            success:function(data){
            }
        })
        btn.click();
    }
    viewPpt = function(url)
    {
        window.open("https://view.officeapps.live.com/op/view.aspx?src=http://app.sz-senox.com/"+url);
    }

    layui.use('upload', function(){
        var upload = layui.upload;
        upload.render({
            elem: '#importModels' //绑定元素
            ,url: 'setReport'
            //上传接口
            ,methd: 'post'
            ,accept: 'file'
            ,done: function(res){
                //上传完毕回调
                layer.alert(res.msg);
            }
            ,error: function(){
                layer.alert("导入中出现错误，请重新尝试！");
            }
        });
    });

    layui.use('upload', function(){
        var upload = layui.upload;
        upload.render({
            elem: '#importModel' //绑定元素
            ,url: 'setFeedback'
            //上传接口
            ,methd: 'post'
            ,accept: 'file'
            ,done: function(res){
                //上传完毕回调
                layer.alert(res.msg);
            }
            ,error: function(){
                layer.alert("导入中出现错误，请重新尝试！");
            }
        });
    });
        </script>


{include file="public/footer" /}