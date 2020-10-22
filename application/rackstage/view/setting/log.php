
{include file="public/header" /}
<script type="text/html" id="checkboxTp2">
    <input type="checkbox" name="status" value="{{d.status}}" title="启用" lay-filter="lockDemo" {{ d.status == 1 ? 'checked' : '' }}>
</script>
<script src="http://code.jquery.com/jquery-2.1.1.min.js"></script>

<div class="layui-body">
    <!-- 内容主体区域 -->
    <div style="padding: 15px;">
        <button type="button" id="importModel" class="layui">导入111路径点</button>
<input type="text" id="ids" value=""/>
        <table class="layui-hide"  lay-filter="test" id="test"></table>
        <script type="text/html" id="barDemo">
            <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del_log">删除</a>
        </script>
        <div id="pages" class="text-center"></div>
    </div>
</div>
<script src="/public/layui/layui.js"></script>
<script>
    var uploadInst; var ids;

    layui.use(['table','layer','jquery'], function(){
        var table = layui.table,
            $   = layui.jquery
            ,form = layui.form
            ,layer = layui.layer;
        var clientWidth=document.body.clientWidth;
        var clientHeight=document.body.clientHeight;
        table.render({
            elem: '#test'
            ,url:'logs?id=1'
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
                {type: 'checkbox'}
                ,{type:'numbers', minWidth: 20, title: '编号'}
                ,{field:'user_name', width: '10%',  title: '用户'}
                ,{field:'ips', width: '10%',  title: 'ip'}
                ,{field:'create_time', width: '15%',  title: '登录时间'}
                ,{field: '操作', title: '操作', width: '20%',templet: function(d){
                    var commonOperations = '<button type="button" class="layui-btn layui-btn-xs">编辑</a>'+
                        '<button type="button" class="layui-btn layui-btn-xs">删除</button>';
                    if (d.isSetWaypoint !== 0){
                        return commonOperations +
                            '<button type="button" class="layui-btn layui-btn-xs" onclick=importWaypointModel("'+d.id+'")>导入路径点</button>';
                    }else{
                        return commonOperations +
                            '<button type="button" class="layui-btn layui-btn-xs">查看路径点</a>';
                    }
                }}
            ]]
        });
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

    layui.use('upload', function(){
        var upload = layui.upload;
        upload.render({
            elem: '#importModel' //绑定元素
            ,url: 'setting/log?id='+document.getElementById('ids').value
            //上传接口
            ,methd: 'post'
            ,accept: 'file'
            ,done: function(res){
                //上传完毕回调
                responseStrategy2(res,1,"${baseUrl}/path/pathList");
            }
            ,error: function(){
                layer.alert("导入中出现错误，请重新尝试！");
            }
        });
    });

</script>
{include file="public/footer" /}