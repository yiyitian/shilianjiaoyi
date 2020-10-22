{include file="public/header" /}
<script type="text/html" id="checkboxTp2">
    <input type="checkbox" name="status" value="{{d.status}}" lay-skin="switch" lay-text="显示|隐藏" lay-filter="sexDemo" {{ d.status == 1 ? 'checked' : '' }}>
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
            

        </div>

        <div class="demo-side">
            <table id="demoTreeTb"></table>
        </div>
    </div>

    <script type="text/html" id="tbBar">


    {{# if(d.levels > 1) { }}
        <a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="questionList">试题列表</a>
        {{# } else { }}
                <a class="layui-btn layui-btn-xs" lay-event="add">增加</a>

        {{# } }}
        <a class="layui-btn  layui-btn-xs" lay-event="edit">编辑</a>
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
            url: 'Management',
            open: true,  // 默认展开
            tree: {
                iconIndex: 1,           // 折叠图标显示在第几列
                isPidData: true,  
                                Spid: 0,
      // 是否是id、pid形式数据
                idName: 'id',  // id字段名称
                pidName: 'pid'     // pid字段名称
            },
            cols: [[
                {type: 'numbers'},
                {field: 'title', title: '分类名称'},
                {field: 'url', title: '视频地址'},
                {field: 'mark', title: '备注'},
                {align: 'center',align:'center', toolbar: '#tbBar', title: '操作', width: 200}
            ]]
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
                layer.confirm('确定删除吗', function(index) {
                    $.ajax({
                        url: "class_info_del",
                        data: {'id': data.id},
                        type: "post",
                        dataType: 'json',
                        success: function (data) {
                            layer.msg(data.msg, {icon: data.code,
                                time: 1500}, function () {
            insTb.reload();
                            });
                        }
                    })
                });
            } else if (event === 'edit')
            {
                 var index = layer.open({
                    type: 2,
                    shade: [0.1],
                    title:"添加/编辑",
                    area: ['700px', '500px'],
                    maxmin: true,
                    content: 'class_info_edit?id='+data.id,
                    btn: ['保存','关闭'],
                    zIndex: layer.zIndex,
                    yes: function(index){
                        var row= window["layui-layer-iframe" + index].callbackdata();
                        if(!$.trim(row)){
                            return false;
                        }
                        layer.closeAll();
                        $.ajax({
                            url:"class_info_edit",
                            type:"post",
                            dataType: "json",
                            cache: false,
                            data:row,
                            contentType: "application/x-www-form-urlencoded; charset=utf-8",
                            success:function(data){
                                if(data.code==1){
                                    layer.msg(data.msg,{time: 1000},function () {
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
            }else if (event === 'questionList') {
                var index = layer.open({
                    title:"试题列表",
                    type: 2,
                    content: "questionList?id="+data.id,
                    area: ['100%', '100%'],
                    maxmin: true
                });

            } else if (event === 'add') {
                var index = layer.open({
                    type: 2,
                    shade: [0.1],
                    title:"添加分类",
                    area: ['700px', '500px'],
                    maxmin: true,
                    content: 'class_info_add?pid='+data.id+'&levels='+(data.levels+1),
                    btn: ['保存','关闭'],
                    zIndex: layer.zIndex, //重点1
                    yes: function(index){
                        var row= window["layui-layer-iframe" + index].callbackdata();
                        if(!$.trim(row)){
                            return false;
                        }
                        layer.closeAll();
                        $.ajax({
                            url:"class_info_add",
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