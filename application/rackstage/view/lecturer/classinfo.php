{include file="public/header" /}
<script type="text/html" id="checkboxTp1">
    <input type="checkbox" name="status1" value="{{d.status1}}" lay-skin="switch" lay-text="是|否" lay-filter="sexDemo" {{ d.status1 == 1 ? 'checked' : '' }}>
</script>
<style>
.layui-table-view .layui-table{display:block;overflow:hidden;}
</style>
<div class="layui-body">
    <input type="hidden" id="checkAll" value="-1"/>
    <!-- 内容主体区域 -->
    <div style="padding: 15px;">
        <div class="layui-btn-container" style="display: inline-block;">

            <button id="btnExpandAll" class="layui-btn layui-btn-sm layui-btn-primary">
                <i class="layui-icon">&#xe668;</i>展开折叠
            </button>
        </div>
        <input class="layui-input" id="edtSearch" value="" placeholder="输入关键字"
               style="display: inline-block;width: 140px;height: 30px;line-height: 30px;padding: 0 5px;margin-right: 5px;"/>
        <div class="layui-btn-container" style="display: inline-block;">
            <button id="btnSearch" class="layui-btn layui-btn-sm layui-btn-primary">
                <i class="layui-icon">&#xe615;</i>搜索
            </button>
            <button id="btnClearSearch" class="layui-btn layui-btn-sm layui-btn-primary">
                <i class="layui-icon">&#x1006;</i>清除搜索
            </button>
            <button id="addAll" class="layui-btn layui-btn-sm layui-btn-primary">
                <i class="layui-icon"></i>增加总分类
            </button>
            

        </div>

        <div class="demo-side">
            <table id="demoTreeTb"></table>
        </div>
    </div>

    <script type="text/html" id="tbBar">
    {{# if(d.levels > 0) { }}
    {{# if(d.levels > 1) { }}
            <a class="layui-btn  layui-btn-xs" lay-event="editTi">编辑</a>
            {{#}else{}}
             {{# if(d.levels > 1) { }}
        <a class="layui-btn  layui-btn-xs" lay-event="addTi">增加</a>
        <a class="layui-btn  layui-btn-xs" lay-event="editTi">编辑</a>
        {{# } else { }}
 <a class="layui-btn layui-btn-xs" lay-event="addTi">增加</a>
        <a class="layui-btn  layui-btn-xs" lay-event="editClass">编辑</a>
        {{# } }}
        {{# } }}

   
        {{# } else { }}
                <a class="layui-btn layui-btn-xs" lay-event="addClass">增加</a>
                <a class="layui-btn layui-btn-xs" lay-event="editClass">编辑</a>
        {{# } }}
        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
    </script>

</div>

<script src="/public/treetable/demo/layui/layui.js"></script>
<script>
    layui.config({
        base: '/public/treetable/'
    }).use(['layer', 'util', 'treeTable'], function () {
        var $ = layui.jquery;
        var layer = layui.layer;
        var util = layui.util;
        var treeTable = layui.treeTable;

        var insTb = treeTable.render({
            elem: '#demoTreeTb',
            url: 'classinfo',
            open: true,  // 默认展开
            tree: {
                iconIndex: 1,           // 折叠图标显示在第几列
                isPidData: true,        // 是否是id、pid形式数据
                idName: 'id',  // id字段名称
                pidName: 'pid'     // pid字段名称
            },
            cols: [[
                {type: 'numbers'},
                {field: 'title', title: '分类名称'},
                {field: 'remark',align:'center', title: '备注'},
                {field:'status1', title:'是否读取',templet: '#checkboxTp1',event:'status1',align:'center'},
                {align: 'center',align:'center', toolbar: '#tbBar', title: '操作', width: 150}
            ]]
        });

        treeTable.on('row(demoTreeTb)', function (obj) {
            var data = obj.data;
            $.ajax({
                    url: "checkStatus1",
                    data: {'id':data.id,'status1':data.status1} ,
                    type: "post" ,
                    dataType:'json',
                    success:function(data){
                        layer.msg(data.msg, {icon: data.code,
                            time: 500}, function () {
                            insTb.reload();
                        });
                    }
                })
        });

        // 全部展开
        $('#btnExpandAll').click(function () {
            var checkAll = $('#checkAll').val();
            if(checkAll  == 1)
            {
                insTb.expandAll();
                $('#checkAll').val('-1');
            }else{
                insTb.foldAll();
                $('#checkAll').val('1');
            }

        });

        // 全部折叠
        $('#btnFoldAll').click(function () {
            insTb.foldAll();
        });


        // 搜索
        $('#btnSearch').click(function () {
            var keywords = $('#edtSearch').val();
            if (keywords) {
                insTb.filterData(keywords);
            } else {
                insTb.clearFilter();
            }
        });

        // 清除搜索
        $('#btnClearSearch').click(function () {
            insTb.clearFilter();
        });
        $('#addAll').click(function () {
            var index = layer.open({
                    type: 2,
                    shade: [0.1],
                    title:"添加分类",
                    area: ['80%', '55%'],
                    maxmin: true,
                    content: 'addAll?pid=0&levels=0',
                    btn: ['保存','关闭'],
                    zIndex: layer.zIndex, //重点1
                    yes: function(index){
                        var row= window["layui-layer-iframe" + index].callbackdata();
                        if(!$.trim(row)){
                            return false;
                        }
                        layer.closeAll();
                        $.ajax({
                            url:"addAll",
                            type:"post",
                            dataType: "json",
                            cache: false,
                            data:row,
                            contentType: "application/x-www-form-urlencoded; charset=utf-8",
                            success:function(data){
                                if(data.code==1){
                                    layer.msg(data.msg,{icon:1,time: 500},function () {
                                                    insTb.reload();

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
        })

        // 重载
        $('#btnReload').click(function () {
            insTb.reload();
        });
        $('#btnRefresh').click(function () {
            insTb.refresh();
        });

        treeTable.on('tool(demoTreeTb)', function (obj) {
            var data = obj.data;
            var event = obj.event;
            if (event === 'del') {
                layer.confirm('确定删除吗', function(index){
                    $.ajax({
                        url: "classinfo_del" ,
                        data: {'id':data.id} ,
                        type: "post" ,
                        dataType:'json',
                        success:function(data){
                            
                            if(data.code==1){
                                layer.msg(data.msg,{ icon:1,time: 500},function () {
                                                                            insTb.reload();

                                });
                            }else{
                                layer.msg(data.msg, { icon: 0});
                            }
                        }
                    })
                });
            }  else if (event === 'status1') {
                $.ajax({
                    url: "checkStatus1",
                    data: {'id':data.id,'status1':data.status1} ,
                    type: "post" ,
                    dataType:'json',
                    success:function(data){
                        layer.msg(data.msg, {icon: data.code,
                            time: 500}, function () {
                            insTb.reload();
                        });
                    }
                })
            }else if (event === 'editTi') {
                var index = layer.open({
                    type: 2,
                    shade: [0.1],
                    title:"添加分类",
                    area: ['80%', '55%'],
                    maxmin: true,
                    content: 'editTi?id='+data.id,
                    btn: ['保存','关闭'],
                    zIndex: layer.zIndex, //重点1
                    yes: function(index){
                        var row= window["layui-layer-iframe" + index].callbackdata();
                        if(!$.trim(row)){
                            return false;
                        }
                        layer.closeAll();
                        $.ajax({
                            url:"editTi",
                            type:"post",
                            dataType: "json",
                            cache: false,
                            data:row,
                            contentType: "application/x-www-form-urlencoded; charset=utf-8",
                            success:function(data){
                                if(data.code==1){
                                    layer.msg(data.msg,{icon:1,time: 500},function () {
                                                    insTb.reload();

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
            }else if (event === 'addTi') {
                var index = layer.open({
                    type: 2,
                    shade: [0.1],
                    title:"添加分类",
                    area: ['80%', '55%'],
                    maxmin: true,
                    content: 'classinfo_add?pid='+data.id+'&levels='+(data.levels+1),
                    btn: ['保存','关闭'],
                    zIndex: layer.zIndex, //重点1
                    yes: function(index){
                        var row= window["layui-layer-iframe" + index].callbackdata();
                        if(!$.trim(row)){
                            return false;
                        }
                        layer.closeAll();
                        $.ajax({
                            url:"classinfo_add",
                            type:"post",
                            dataType: "json",
                            cache: false,
                            data:row,
                            contentType: "application/x-www-form-urlencoded; charset=utf-8",
                            success:function(data){
                                if(data.code==1){
                                    layer.msg(data.msg,{icon:1,time: 500},function () {
                                                    insTb.reload();

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
            }else if (event === 'editClass') {
                var index = layer.open({
                    type: 2,
                    shade: [0.1],
                    title:"添加分类",
                    area: ['80%', '55%'],
                    maxmin: true,
                    content: 'editClass?id='+data.id,
                    btn: ['保存','关闭'],
                    zIndex: layer.zIndex, //重点1
                    yes: function(index){
                        var row= window["layui-layer-iframe" + index].callbackdata();
                        if(!$.trim(row)){
                            return false;
                        }
                        layer.closeAll();
                        $.ajax({
                            url:"editClass",
                            type:"post",
                            dataType: "json",
                            cache: false,
                            data:row,
                            contentType: "application/x-www-form-urlencoded; charset=utf-8",
                            success:function(data){
                                if(data.code==1){
                                    layer.msg(data.msg,{icon:1,time: 500},function () {
                                                    insTb.reload();

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
            }else if (event === 'addClass') {
               var index = layer.open({
                    type: 2,
                    shade: [0.1],
                    title:"添加分类",
                    area: ['80%', '55%'],
                    maxmin: true,
                    content: 'addClass?pid='+data.id,
                    btn: ['保存','关闭'],
                    zIndex: layer.zIndex, //重点1
                    yes: function(index){
                        var row= window["layui-layer-iframe" + index].callbackdata();
                        if(!$.trim(row)){
                            return false;
                        }
                        layer.closeAll();
                        $.ajax({
                            url:"addAll",
                            type:"post",
                            dataType: "json",
                            cache: false,
                            data:row,
                            contentType: "application/x-www-form-urlencoded; charset=utf-8",
                            success:function(data){
                                if(data.code==1){
                                    layer.msg(data.msg,{icon:1,time: 500},function () {
                                                    insTb.reload();

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
            }else if (event === 'edit')
            {
                 var index = layer.open({
                    type: 2,
                    shade: [0.1],
                    title:"添加分类",
                    area: ['80%', '55%'],
                    maxmin: true,
                    content: 'classInfoEdit?id='+data.id,
                    btn: ['保存','关闭'],
                    zIndex: layer.zIndex, //重点1
                    yes: function(index){
                        var row= window["layui-layer-iframe" + index].callbackdata();
                        if(!$.trim(row)){
                            return false;
                        }
                        layer.closeAll();
                        $.ajax({
                            url:"classinfo_add",
                            type:"post",
                            dataType: "json",
                            cache: false,
                            data:row,
                            contentType: "application/x-www-form-urlencoded; charset=utf-8",
                            success:function(data){
                                if(data.code==1){
                                    layer.msg(data.msg,{icon:1,time: 500},function () {
                                                    insTb.reload();
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
            } else if (event === 'add') {
                 var index = layer.open({
                    type: 2,
                    shade: [0.1],
                    title:"添加分类",
                    area: ['80%', '55%'],
                    maxmin: true,
                    content: 'classinfo_add?pid='+data.id+'&levels='+(data.levels+1),
                    btn: ['保存','关闭'],
                    zIndex: layer.zIndex, //重点1
                    yes: function(index){
                        var row= window["layui-layer-iframe" + index].callbackdata();
                        if(!$.trim(row)){
                            return false;
                        }
                        layer.closeAll();
                        $.ajax({
                            url:"classinfo_add",
                            type:"post",
                            dataType: "json",
                            cache: false,
                            data:row,
                            contentType: "application/x-www-form-urlencoded; charset=utf-8",
                            success:function(data){
                                if(data.code==1){
                                    layer.msg(data.msg,{icon:1,time: 500},function () {
                                                    insTb.reload();

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



    });
</script>

{include file="public/footer" /}