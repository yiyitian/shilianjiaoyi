{include file="public/header" /}
<script type="text/html" id="checkboxTp1">
    {{# if(d.is_teacher == -1){ }}
    不是
    {{# }else{ }}
    是
    {{#}}}

</script>
<script type="text/html" id="checkboxTp2">
    {{# if(d.is_quit == 1){ }}
    离职
    {{# }else{ }}
    在职
    {{#}}}
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

</style>
<div class="layui-body">
    <div class="layui-main">
        <fieldset class="layui-elem-field layui-field-title" style="margin-top: 30px;">
            <legend>统计查询</legend>
        </fieldset>
        <form class="layui-form" action="" id="formid"  style="margin-top: 20px;">


            <div class='hidden' id="hidden">
                <div class="layui-form-item">
                    <label class="layui-form-label">选择部门</label>
                    <div class="layui-input-inline">
                        <div id="demo1"></div>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">选择项目</label>
                    <div class="layui-input-inline">
                        <div id="demo2"></div>
                    </div>
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">课程类型</label>
                <div class="layui-input-inline">
                    <select name="classtype" id="classtype" lay-filter="classtype">
                        {volist name="classInfo" id="vo"}
                        <option value="{$vo.id}" >{$vo.title}</option>
                        {/volist}
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">课程分类</label>
                <div class="layui-input-inline">
                    <select name="classify" id="classify" lay-filter="classify">

                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">课程名称</label>
                <div class="layui-input-inline">
                    <select name="classname" id="classname" lay-filter="classname">

                    </select>
                </div>
            </div>

            <div class="layui-form-item">
                <div class="layui-input-block">
                    <span class="layui-btn" id="statistics" >查询</span>
                </div>
            </div>
        </form>
        <table class="layui-hide"  lay-filter="test" id="test"></table>
    </div>
</div>
<script src="/public/layui/layui.js" charset="utf-8"></script>
<script src="/public/treetable/xm-select.js" charset="utf-8"></script>
<!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->
<script>

    var callbackdata;
    layui.use(['layer','table', 'form','element','laydate','jquery'], function(){
        var table = layui.table
            ,layer = layui.layer
            ,$=layui.jquery
            ,form = layui.form
            ,laydate = layui.laydate;

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
            url: "/rackstage/personnel/getProjects" ,
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

    form.on('select(classtype)', function(data){


        $.ajax({
            url: "class_Info" ,
            data: {'pid':data.value,'levels':'1'} ,
            type: "post" ,
            dataType:'json',
            success:function(data){
                var lists=data.data;
                $("#classify").empty();
                $("#classname").empty();
                $("#classify").append("<option value=''>请选择</option>");
                for(var i=0;i<lists.length;i++){
                    $('#classify').append('<option value="'+lists[i]['id']+'">'+lists[i]['title']+'</option>');
                }
                form.render('select');
                //layer.msg(data.msg, {icon: data.code},function(){$(".layui-laypage-btn").click();});
            }
        })
    });
    form.on('select(classify)', function(data){
        console.log(data.elem); //得到select原始DOM对象
        console.log(data.value); //得到被选中的值
        console.log(data.othis); //得到美化后的DOM对象
        $.ajax({
            url: "class_info" ,
            data: {'pid':data.value,'levels':'2'} ,
            type: "post" ,
            dataType:'json',
            success:function(data){
                var lists=data.data;
                $("#classname").empty();
                $("#classname").append("<option value=''>请选择</option>");
                for(var i=0;i<lists.length;i++){
                    console.log(i+": "+lists[i]['title'])
                    $('#classname').append('<option value="'+lists[i]['id']+'">'+lists[i]['title']+'</option>');
                }
                form.render('select');
                //layer.msg(data.msg, {icon: data.code},function(){$(".layui-laypage-btn").click();});
            }
        })
    });
    $(document).on('click','#statistics',function(){
            //部门和岗位不能为空，课程二级分类不能为空
            var department =  demo1.getValue('value'),
                project =  demo2.getValue('value'),
                classType = $('#classtype').val(),
                classIfy  = $('#classify').val(),
                className = $('#classname').val();
            if(classType == null){ layer.alert('请选择类型');  return false;};
            if(classIfy == null){ layer.alert('请选择分类');  return false;};
            if(className == ""){ layer.alert('请选择课程名称');  return false;};


            table.render({
                id: 'test'
                ,toolbar: true
                ,elem: '#test'
                , url: 'chaxun'
                ,method:'post'
                ,where: {
                    project:project,
                    department: department,
                    classType:classType,
                    classIfy:classIfy,
                    className: className,
                }
                , page: { //支持传入 laypage 组件的所有参数（某些参数除外，如：jump/elem） - 详见文档
                    layout: ['limit', 'count', 'prev', 'page', 'next', 'skip'] //自定义分页布局
                    //,curr: 5 //设定初始在第 5 页
                    , limit: 25 //一页显示多少条
                    , limits: [25, 50, 100, 999999]//每页条数的选择项
                    , groups: 2 //只显示 2 个连续页码
                    , first: "首页" //不显示首页
                    , last: "尾页" //不显示尾页
                }
                , cols: [[
                    {type:'numbers', minWidth: 20, title: '编号'}
                    ,{field:'username',  align:'center',  title: '姓名'}
                    ,{field:'sex', align:'center',  title: '性别',templet:'#sex'}
                    ,{field:'marriage', align:'center', title: '婚姻',templet:'#marriage'}
                    ,{field:'domicile', align:'center',  title: '户籍地'}
                    ,{field:'universit', align:'center',  title: '毕业学校'}
                    ,{field:'education', align:'center',  title: '最高学历'}
                    ,{field:'major', align:'center',  title: '专业'}
                    ,{field:'region', align:'center',  title: '地区'}
                    ,{field:'department', align:'center',  title: '部门'}
                    ,{field:'station', align:'center',  title: '岗位'}
                    ,{field:'projectname', align:'center',  title: '项目名称'}
                    ,{field:'start_time', align:'center',  title: '入职时间'}
                    ,{field:'is_teacher', align:'center',title:'是否教师', templet: '#checkboxTp1'}
                    ,{field:'is_quit', align:'center',title:'是否在职',width: '8.5%', templet: '#checkboxTp2'}
                ]],
                totalRow: true,
            });
        });
    })

</script>
{include file="public/footer" /}