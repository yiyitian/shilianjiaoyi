{include file="public/header" /}
<div class="layui-body">
    <div class="layui-main">
        <fieldset class="layui-elem-field layui-field-title" style="margin-top: 30px;">
            <legend>讲师课程列表</legend>
        </fieldset>
        <div class="demoTable">
            <div class="layui-input-inline" >
                <input class="layui-input" name="startTime" value="" id="test3" placeholder="起始日期" autocomplete="off">
            </div>
            <div class="layui-input-inline" >
                <input class="layui-input" name="endTime" value="" id="test4" placeholder="结束日期" autocomplete="off">
            </div>
            <button class="layui-btn" id="statistics">搜索</button>
        </div>
        <script type="text/html" id="barDemo">
            <a class="layui-btn layui-btn-xs" lay-event="details">查看详情</a>
        </script>
        <table class="layui-hide"  lay-filter="test" id="test"></table>
    </div>
</div>
<script src="/public/layui/layui.js" charset="utf-8"></script>
<script>
    layui.use(['layer','table', 'form','element','laydate','jquery'], function(){
        var table = layui.table
            ,layer = layui.layer
            ,$=layui.jquery
            ,laydate = layui.laydate;
        laydate.render({
            elem: '#test3'
        });
        laydate.render({
            elem: '#test4'
        });

        table.on('tool(test)', function(obj){
            var data = obj.data;
            if(obj.event === 'details'){
                var index = layer.open({
                    type: 2,
                    shade: [0.1],
                    title:"添加/编辑",
                    area: ['100%', '100%'],
                    maxmin: true,
                    content: '/rackstage/Lecturer/teacherDetails?id='+data.lecturer+'&time_code='+$('#test3').val()+' - '+$('#test4').val(),
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
            }
        });
        $(document).on('click','#statistics',function(){
            var sTime = $('#test3').val(),
                eTime = $('#test4').val(),
                time_code=sTime+' - '+eTime;
            if(sTime == ''){
                layer.msg('请选择时间！',{icon:0});
                return false;
            }
            if(eTime == ''){
                layer.msg('请选择时间！',{icon:0});
                return false;
            }
            table.render({
                id: 'test'
                ,toolbar: true
                ,elem: '#test'
                , url: 'teacherLog'
                ,method:'post'
                ,where: {
                    time_code: time_code
                }
                , cols: [[
                    {type:'numbers',  title: '编号'}
                    ,{field:'department', align:'center',  title: '部门', sort: true}
                    ,{field:'work_id', align:'center',  title: '工号'}
                    ,{field:'0', align:'center',  title: '姓名'}
                    ,{field:'1', align:'center',  title: '类型'}
                    ,{field:'chang', align:'center',  title: '上课时长', sort: true}
                    ,{field:'num', align:'center',  title: '上课次数', sort: true}
                    ,{field:'a',  align:'center',  title: '专业知识',hide:true}
                    ,{field:'b',  align:'center',  title: '授课技巧',hide:true}
                    ,{field:'c', align:'center',  title: '课堂气氛',hide:true}
                    ,{field:'d',  align:'center',  title: '理论案例',hide:true}
                    ,{field:'e',  align:'center',  title: '反应解答',hide:true}
                    ,{field:'f',  align:'center',  title: '节奏把控',hide:true}
                    ,{field:'g',  align:'center',  title: '教材相符',hide:true}
                    ,{field:'count',  align:'center',  title: '总分', sort: true}
                    ,{fixed: 'right', width:'15%', align:'center', toolbar: '#barDemo',title:'操作'}
                ]]
            });
        });
    })
</script>
{include file="public/footer" /}