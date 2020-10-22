{include file="public/header" /}
<script type="text/html" id="checkboxTp1">
    {{# if(d.is_teacher == -1){ }}
    不是
    {{# }else{ }}
    是
    {{#}}}

</script>
<script type="text/html" id="checkboxTp2">
    <input type="checkbox" name="is_quit" value="{{d.is_quit}}" lay-skin="switch" lay-text="在职|离职" lay-filter="sexDemo" {{ d.is_quit == -1 ? 'checked' : '' }}>
</script>
<script type="text/html" id="sex">
    {{# if(d.sex == 1){d.sex="男"}}
    {{d.sex}}
    {{# }else{d.sex="女"}}
    {{d.sex}}
    {{#}}}
</script>
<script type="text/html" id="marriage">
    {{# if(d.marriage == -1){d.marriage="未婚"}}
    {{d.marriage}}
    {{# }else{d.marriage="已婚"}}
    {{d.marriage}}
    {{#}}}
</script>
<style>
    .layui-input-inline{margin-bottom:10px;}
</style>
<div class="layui-body">
    <!-- 内容主体区域 -->
    <div style="padding: 15px;">
        <div class="demoTable layui-form">
            <form class="layui-form" action="">

                <div class="layui-input-inline"  style="width:230px;">
                    <input class="layui-input" name="search_field" value="" id="search_field" placeholder="请输入姓名/手机号/工号" autocomplete="off">
                </div>

                <div class="layui-input-inline"  style="width:230px;">
                    <div id="demo1"></div>
                </div>
                <div class="layui-input-inline"  style="width:230px;">
                    <div id="demo2"></div>
                </div>
                <div class="layui-input-inline"  style="width:230px;">
                    <div id="demo3"></div>
                </div>
 <div class="layui-input-inline"  style="width:230px;">
                        <select name="isQuit" id="isQuit" lay-filter="isQuit">
                            <option value="1" >离职</option>
                            <option value="-1" selected="selected" >在职</option>
                        </select>
                    </div>

                <div class="layui-input-inline">
                    <button class="layui-btn search" data-type="reload" type="button" style="">搜索用户</button>
                    <button class="layui-btn" id="add" type="button" >增加用户</button>
                    <button type="reset" class="layui-btn" id="reset">重置</button>
                    <span style="color:red;">注：无工号默认为SD888888</span>
                </div>
            </form>
        </div>
        <table class="layui-hide"  lay-filter="test" id="test"></table>
        <script type="text/html" id="barDemo">
            {eq name="admins" value="1"}
            <a class="layui-btn layui-btn-xs layui-btn-normal" lay-event="class">课程</a>
            {/eq}
            <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
            {eq name="admins" value="1"}
            <a class="layui-btn layui-btn-xs layui-btn-danger" lay-event="del">删除</a>
            {/eq}
        </script>

        <div id="pages" class="text-center"></div>
    </div>
</div>
<script src="/public/layui/layui.js"></script>
<script src="/public/treetable/xm-select.js" charset="utf-8"></script>
<!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->
<script>
    var demo1 = xmSelect.render({
        el: '#demo1',
        tree: {
            show: true,
            showFolderIcon: true,
            showLine: true,
            indent: 20,
            expandedKeys: [ -3 ],
        },
        model: {
            label: {
                type: 'block',
                block: {
                    //最大显示数量, 0:不限制
                    showCount: 1,
                    //是否显示删除图标
                    showIcon: true,
                }
            }
        },
        theme:{
            color:'#FF5722',
        },
        toolbar: {
            show: true,
            list: ['ALL', 'REVERSE', 'CLEAR']
        },
        filterable: true,
        height: '400px',
        filterable:false,
        data(){
        return {$lists1}
    }
    })
    var demo2 = xmSelect.render({
        el: '#demo2',
        toolbar:{
            show: true,
        },
        filterable: true,
        model: {
            label: {
                type: 'block',
                block: {
                    //最大显示数量, 0:不限制
                    showCount: 1,
                    //是否显示删除图标
                    showIcon: true,
                }
            }
        },
        theme:{
            color:'#FF5722',
        },
        height: '400px',
        data: [],
        show()
    {
        var selectArr = demo1.getValue('value');
        $.ajax({
            url: "getProjects" ,
            data: {'pid':selectArr} ,
            type: "post" ,
            dataType:'json',
            success:function(data){
                demo2.update({
                    data: data.data,
                    autoRow: true,
                })
            }
        })
    },
    })


    var demo3 = xmSelect.render({
        el: '#demo3',
        toolbar:{
            show: true,
        },
        filterable: true,
        model: {
            label: {
                type: 'block',
                block: {
                    //最大显示数量, 0:不限制
                    showCount: 1,
                    //是否显示删除图标
                    showIcon: true,
                }
            }
        },
        theme:{
            color:'#FF5722',
        },
        height: '400px',
        data: {$posts}
    })
    layui.use(['table','layer','jquery'], function(){
        var table = layui.table,
            $   = layui.jquery
            ,form = layui.form
            ,layer = layui.layer;

        var renderTable=function(){
            table.render({
                id:'test'
                ,toolbar:true
                ,elem: '#test'
                ,url:'index?id=1'
                ,page: {
                    layout: ['limit', 'count', 'prev', 'page', 'next', 'skip']
                    ,limit:25
                    ,limits:[25,50,100,99999]
                    ,groups: 6
                    ,first: "首页"
                    ,last: "尾页"

                }
                ,cols: [[
                    {type:'numbers', minWidth: 20, title: '编号'}
                    ,{field:'work_id',  align:'center',  title: '工号'}
                    ,{field:'username',  align:'center',  title: '姓名'}
                    // ,{field:'phone',  align:'center',  title: '手机号'}
                    ,{field:'sex', align:'center',  title: '性别'}
                    ,{field:'marriage', align:'center', title: '婚姻',hide:true}
                    ,{field:'domicile', align:'center',  title: '户籍地',hide:true}
                    ,{field:'universit', align:'center',  title: '毕业学校',hide:true}
                    ,{field:'education', align:'center',  title: '最高学历',hide:true}
                    ,{field:'major', align:'center',  title: '专业',hide:true}
                    ,{field:'region', align:'center',  title: '地区'}
                    ,{field:'department', align:'center',  title: '部门'}
                    ,{field:'station', align:'center',  title: '岗位'}
                    ,{field:'projectname', align:'center',  title: '项目名称'}
                    ,{field:'start_time', align:'center',  title: '入职时间'}
                    ,{field:'is_teacher', align:'center',title:'是否教师',hide:true}
                    ,{field:'is_quit', align:'center',title:'是否在职',hide:true,width: '8.5%', templet: '#checkboxTp2', unresize: true,event:'is_quit'}
                    ,{ width:150, align:'center', toolbar: '#barDemo',title:'操作'}
                ]]
            });
        };
        renderTable();
         var clientWidth=$(window).width();
        var clientHeight=$(window).height();
        /*搜索开始*/
        var $ = layui.$, active = {
            reload: function(){
                var demoReload = $('#search_field');
                //执行重载
                table.reload('test', {
                    url: 'search'
                    ,page: {
                        curr: 1 //重新从第 1 页开始
                    }
                    ,method: 'post'
                    ,where: {
                        search_field: demoReload.val(),
                        department: demo1.getValue('value'),
                        project: demo2.getValue('value'),
                        station: demo3.getValue('value'),
                        isQuit:$('#isQuit').val(),

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
            $('select').val('');
            renderTable();
        });

        table.on('tool(test)', function(obj){
            var data = obj.data;
            if(obj.event === 'del'){
                layer.confirm('确定删除吗', function(index){
                    $.ajax({
                        url: "users_del" ,
                        data: {'id':data.id} ,
                        type: "post" ,
                        dataType:'json',
                        success:function(data){
                            layer.msg('删除成功', {icon:1,time:500},function(){$(".layui-laypage-btn").click();});
                            if(data.code==1){
                                layer.msg(data.msg,{ icon:1,time: 500},function () {
                                    //renderTable();//location.reload();
                                });
                            }else{
                                layer.msg(data.msg, { icon: 0});
                            }
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
                    content: 'users_edit?id='+data.id,
                    btn: ['保存','关闭'],
                    zIndex: layer.zIndex, //重点1
                    yes: function(index){
                        var row= window["layui-layer-iframe" + index].callbackdata();
                        if(!$.trim(row)){
                            return false;
                        }
                        layer.closeAll();
                        $.ajax({
                            url:"users_edit",
                            type:"post",
                            dataType: "json",
                            cache: false,
                            data:row,
                            contentType: "application/x-www-form-urlencoded; charset=utf-8",
                            success:function(data){
                                if(data.code==1){
                                    layer.msg(data.msg,{icon:1,time:500},function(){$(".layui-laypage-btn").click();});
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
            }else if(obj.event === 'class'){
                var index = layer.open({
                    type: 2,
                    shade: [0.1],
                    title:"添加/编辑",
                    area: [clientWidth*.7+'px', clientHeight*.6+'px'],
                    maxmin: true,
                    content: 'users_class?id='+data.id,
                    btn: ['保存','关闭'],
                    zIndex: layer.zIndex, //重点1
                    yes: function(index){
                        var row= window["layui-layer-iframe" + index].callbackdata();
                        if(!$.trim(row)){
                            return false;
                        }
                        layer.closeAll();
                    },
                    cancel: function(){
                    },
                    end: function(){ //此处用于演示
                    }
                });
                layer.full(index);
            }else if(obj.event === 'is_quit'){
                layer.confirm('确认操作？', function(index){
                    $.ajax({
                        url: "checkQuitStatus" ,
                        data: {'id':data.id,'is_quit':data.is_quit} ,
                        type: "post" ,
                        dataType:'json',
                        success:function(data){
                            layer.msg(data.msg, {icon: data.code,time:500},function(){$(".layui-laypage-btn").click();});
                        }
                    })
                });
            }
        });
        $(document).on('click','#add',function(){
            var index = layer.open({
                type: 2,
                shade: [0.1],
                title:"添加/编辑",
                area: [clientWidth*.7+'px', clientHeight*.6+'px'],
                maxmin: true,
                content: 'users_add',
                btn: ['保存','关闭'],
                zIndex: layer.zIndex, //重点1
                yes: function(index){
                    var row= window["layui-layer-iframe" + index].callbackdata();

                    if(!$.trim(row)){
                        return false;
                    }
                    layer.closeAll();
                    $.ajax({
                        url:"users_add",
                        type:"post",
                        dataType: "json",
                        cache: false,
                        data:row,
                        contentType: "application/x-www-form-urlencoded; charset=utf-8",
                        success:function(data){
                            console.log(data);
                            if(data.code==1){
                                layer.msg(data.msg,{icon:1,time:500},function(){$(".layui-laypage-btn").click();});
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
    });
</script>
{include file="public/footer" /}