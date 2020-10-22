{include file="public/header" /}
<style>
    #d{
        display:none;
    }
    #x{
        display:none;
    }
    #j{
        display:none;
    }
    #p{
        display:none;
    }
    #g{
        display:none;
    }
</style>
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
<div class="layui-body">
    <div class="layui-main">
        <fieldset class="layui-elem-field layui-field-title" style="margin-top: 30px;">
            <legend>统计查询</legend>
        </fieldset>
        <form class="layui-form"  >
            <div class="layui-form-item">
                <label class="layui-form-label">培训查询</label>
                <div class="layui-input-inline">
                    <select name="select" lay-filter="select">
                        <option value="d">合格培训查询</option>
                        <option value="x" >详细培训查询</option>
                        <option value="j">培训绩效</option>
                        <option value="p">培训率查询</option>
                        <option value="g">个人培训查询</option>
                    </select>
                </div>
            </div>
        </form>
        <!--  培训详细查询-->
        <div id="d">
            <form class="layui-form" action="" id="formid"  style="margin-top: 20px;">
                <div class="layui-form-item" >
                    <label class="layui-form-label">选择时间</label>
                    <div class="layui-input-inline" style="width:150px;">
                        <input style="" type="text" id="start_time" lay-verify="required" value="" placeholder="请选择开始日期" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-form-mid">~</div>
                    <div class="layui-input-inline" style="width:150px;">
                        <input type="text" id="end_time" lay-verify="required" value="" placeholder="请选择结束日期" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-inline layui-word-aux">请选择员工入职时间范围</div>

                </div>
                <div class="layui-form-item" style="display:none;">
                    <label class="layui-form-label">选择用户</label>
                    <div class="layui-input-inline" style="width:328px;">
                        <div id="demo4"></div>

                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">选择部门</label>
                    <div class="layui-input-inline" style="width:328px;">
                        <div id="demo1"></div>

                    </div>
                </div>
                <div class="layui-form-item outline online">
                    <label class="layui-form-label">选择岗位</label>
                    <div class="layui-input-inline" style="width:328px;" >
                        <div id="demo3"></div>

                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">选择项目</label>
                    <div class="layui-input-inline" style="width:328px;">
                        <div id="demo2"></div>

                    </div>
                </div>
                <div class="layui-form-item outline online">
                    <label class="layui-form-label">课程分类</label>
                    <div class="layui-input-inline" style="width:328px;" >
                        <div id="demo5"></div>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">是否培训</label>
                    <div class="layui-input-inline" style="width:328px;">
                        <input type="radio" lay-filter="levelM"  name="is_train" value="1" title="已培训" checked>
                        <input type="radio" lay-filter="levelM"  name="is_train" value="-1" title="未培训">
                    </div>
                </div>
                <div class="layui-form-item" id="show">
                    <label class="layui-form-label">是否合格</label>
                    <div class="layui-input-inline" style="width:328px;">
                        <input type="radio" name="is_qualified" checked value="1" title="合格" >
                        <input type="radio" name="is_qualified" value="-1" title="不合格">
                        <input type="radio" name="is_qualified" value="3" title="全部">
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <span class="layui-btn" id="statistics" >查询</span>
                    </div>
                </div>
            </form>
        </div>
        <div id="g">
            <form class="layui-form" action="" id="formid"  style="margin-top: 20px;">

                <div class="layui-form-item">
                    <label class="layui-form-label">工号</label>
                    <div class="layui-input-inline" >
                        <input style="" type="text" id="work_id" lay-verify="required" value="" placeholder="请输入工号" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">选择用户</label>
                    <div class="layui-input-inline" >
                        <div id="demo18"></div>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <span class="layui-btn" id="statistics123" >查询</span>
                    </div>
                </div>
            </form>
        </div>

        <!---->
        <div id="x">
            <form class="layui-form" action="" id="formid"  style="margin-top: 20px;">

                <div class="layui-form-item" >
                    <label class="layui-form-label">入职时间</label>

                    <div class="layui-input-inline" style="width:150px;">
                        <input style="" type="text" id="start_times" lay-verify="required" value="" placeholder="请选择开始日期" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-form-mid">~</div>
                    <div class="layui-input-inline" style="width:150px;">
                        <input type="text" id="end_times" lay-verify="required" value="" placeholder="请选择结束日期" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-inline layui-word-aux">请选择员工入职时间范围</div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">选择部门</label>
                    <div class="layui-input-inline">
                        <div id="demo6"></div>

                    </div>
                </div>
                <div class="layui-form-item outline online">
                    <label class="layui-form-label">选择岗位</label>
                    <div class="layui-input-inline" >
                        <div id="demo7"></div>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">课程类型</label>
                    <div class="layui-input-inline">
                        <select name="classtype" id="classtype" lay-filter="classtype">
                            {notempty name="list"}
                            <option value="{$list.classtype|default=''}">{$list.classtype_name|default=''}</option>
                            {else /}
                            <option value=""></option>
                            {/notempty}
                            {volist name="classArr" id="vo"}
                            <option value="{$vo.id}">{$vo.title}</option>
                            {/volist}
                        </select>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">课程分类</label>
                    <div class="layui-input-inline">
                        <select name="classify" id="classify" lay-filter="classify">
                            {notempty name="list"}
                            <option value="{$list.classify|default=''}">{$list.classify_name|default=''}</option>
                            {else /}
                            <option value=""></option>
                            {/notempty}

                        </select>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">是否培训</label>
                    <div class="layui-input-inline">
                        <input type="radio" name="is_trains" value="1" title="已培训" checked >
                        <input type="radio" name="is_trains" value="-1" title="未培训" >
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <span class="layui-btn" id="statistics1" >查询</span>
                    </div>
                </div>
            </form>
        </div>
        <!--培训绩效-->
        <div id="j">
            <form class="layui-form" action="" id="formid"  style="margin-top: 20px;">
                <div class="layui-form-item" >
                    <label class="layui-form-label">开课时间</label>
                    <div class="layui-input-inline" style="width:150px;">
                        <input style="" type="text" id="start_time1" lay-verify="required" value="" placeholder="请选择开始日期" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-form-mid">~</div>
                    <div class="layui-input-inline" style="width:150px;">
                        <input type="text" id="end_time1" lay-verify="required" value="" placeholder="请选择结束日期" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">选择用户</label>
                    <div class="layui-input-inline" style="width:328px;">
                        <div id="demo8"></div>
                    </div>
                </div>

                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <span class="layui-btn" id="statistics2" >查询</span>
                    </div>
                </div>
            </form>
        </div>
        <div id="p">
            <form class="layui-form" action="" id="formid"  style="margin-top: 20px;">
                <div class="layui-form-item" >
                    <label class="layui-form-label">入职日期</label>
                    <div class="layui-input-inline" style="width:150px;">
                        <input style="" type="text" id="start_time2" lay-verify="required" value="" placeholder="请选择开始日期" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-form-mid">~</div>
                    <div class="layui-input-inline" style="width:150px;">
                        <input type="text" id="end_time2" lay-verify="required" value="" placeholder="请选择结束日期" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item outline online">
                    <label class="layui-form-label">选择岗位</label>
                    <div class="layui-input-inline" style="width:328px;" >
                        <div id="demo9"></div>
                    </div>
                </div>

                <div class="layui-form-item outline online">
                    <label class="layui-form-label">课程分类</label>
                    <div class="layui-input-inline" style="width:328px;" >
                        <div id="demo10"></div>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <span class="layui-btn" id="statistics4" >查询</span>
                    </div>
                </div>
            </form>
        </div>
        <table class="layui-hide"  lay-filter="test" id="test"></table>
        <div id='priceContent' style="float:right;margin-right:8%"></div>
    </div>
</div>
<script src="/public/layui/layui.js" charset="utf-8"></script>
<script src="/public/treetable/xm-select.js" charset="utf-8"></script>
<script>
    var callbackdata;
    layui.use(['layer','table', 'form','element','laydate','jquery'], function(){
        var table = layui.table
            ,layer = layui.layer
            ,$=layui.jquery
            ,form = layui.form
            ,laydate = layui.laydate;
        $("#j").attr("style", "display:none;");
        $("#x").attr("style", "display:none;");
        $("#p").attr("style", "display:none;");
        $("#d").attr("style", "display:block;");
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
            direction:'down',
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
        direction:'down',
        data: [],
        show()
    {
        var selectArr = demo1.getValue('value');
        $.ajax({
            url: "/rackstage/Personnel/getProjects" ,
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
        filterable: false,
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
        direction:'down',
        height: '400px',
        data: {$posts1}
    })
    var demo5 = xmSelect.render({
        el: '#demo5',
        toolbar:{
            show: true,
        },
        filterable: false,
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
        direction:'down',
        height: '400px',
        data: {$classifyNew}
    })

    var demo4 = xmSelect.render({
        el: '#demo4',
        height: '400px',
        direction:'down',
        filterable: true,
        theme:{
            color:'#FF5722',
        },
        data: {$userArr}
    })

    laydate.render({
        elem: '#start_time'
    });
    laydate.render({
        elem: '#end_time'
    });
    form.on('radio(levelM)', function(data){
        if(data.value <0)
        {
            $("#show").hide();
        }else{
            $("#show").show();
        }
    });

    $(document).on('click','#statistics',function(){
        //部门和岗位不能为空，课程二级分类不能为空
        var department=demo1.getValue('valueStr'),//部门
            station=demo3.getValue('valueStr'),//岗位
            classify=demo5.getValue('valueStr'),
            project =demo2.getValue('valueStr'),//岗位
            username =demo4.getValue('valueStr'),//岗位
            start_time=$('#start_time').val(),
            end_time=$('#end_time').val(),
            is_train=$('input[name="is_train"]:checked').val();
        is_qualified=$('input[name="is_qualified"]:checked').val();

        if(start_time == ''){
            layer.msg('开始时间不能为空',{icon:0});
            return false;
        }
        if(end_time == ''){
            layer.msg('结束时间不能为空',{icon:0});
            return false;
        }
        var time_code=start_time+' - '+end_time;
        if(is_train>0)
        {
            table.render({
                id: 'test'
                ,toolbar: true
                ,elem: '#test'
                , url: 'getTrainUser'
                ,method:'post'
                ,totalRow: true
                ,where: {
                    time_code: time_code,
                    department: department,
                    project:project,
                    username:username,
                    station:station,
                    classify: classify,
                    is_train:is_train,
                    is_qualified:is_qualified,
                }

                , cols: [[
                    {type:'numbers', minWidth: 20, title: '编号'}
                    ,{field:'region_title',  align:'center',  title: '地区'}
                    ,{field:'department_title', align:'center',  title: '部门'}
                    ,{field:'station_title', align:'center', title: '岗位'}
                    ,{field:'project_title', align:'center',  title: '项目名称'}
                    ,{field:'work_id', align:'center',  title: '工号'}
                    ,{field:'username', align:'center',  title: '用户名'}
                    ,{field:'classify_title', align:'center',  title: '培训分类'}
                    ,{field:'branch', align:'center',  title: '考试成绩'}
                    ,{field:'price', align:'center',  title: '培训费用', totalRow: true}
                    ,{field:'startdate', align:'center',  title: '考试时间'}
                ]],
                done: function(res, curr, count){

                    b = $('.layui-table-total td[data-field=price] .layui-table-cell').text();
                    $('#priceContent').text('金额：'+b+'.00元');

                    this.elem.next().find('.layui-table-total').hide();

                }
            });
        }else{
            table.render({
                id: 'test'
                ,toolbar: true
                ,elem: '#test'
                , url: 'getTrainUser'
                ,method:'post'
                ,where: {
                    time_code: time_code,
                    department: department,
                    project:project,
                    username:username,
                    station:station,
                    classify: classify,
                    is_train:is_train,
                    is_qualified:is_qualified,
                }

                , cols: [[
                    {type:'numbers', minWidth: 20, title: '编号'}
                    ,{field:'region',  align:'center',  title: '地区'}
                    ,{field:'department', align:'center',  title: '部门'}
                    ,{field:'station', align:'center', title: '岗位'}
                    ,{field:'project', align:'center',  title: '项目名称'}
                    ,{field:'work_id', align:'center',  title: '工号'}
                    ,{field:'username', align:'center',  title: '用户名'}

                ]]
            });
        }

    });


    form.on('select(select)', function(data) {
        if (data.value == 'd') {
            $("#j").attr("style", "display:none;");
            $("#x").attr("style", "display:none;");
            $("#p").attr("style", "display:none;");
            $("#d").attr("style", "display:block;");


            laydate.render({
                elem: '#start_time'
            });
            laydate.render({
                elem: '#end_time'
            });
            form.on('radio(levelM)', function(data){

                if(data.value <0)
                {
                    $("#show").hide();
                }else{
                    $("#show").show();
                }


            });
            $(document).on('click','#statistics',function(){
                //部门和岗位不能为空，课程二级分类不能为空
                var department=layui.formSelects.value('select7_0', 'valStr'),//部门
                    station=layui.formSelects.value('select7_2', 'valStr'),//岗位
                    classify=layui.formSelects.value('select7_1', 'valStr'),//岗位
                    project =layui.formSelects.value('select7_4', 'valStr'),//岗位
                    username =layui.formSelects.value('select7_3', 'valStr'),//岗位
                    start_time=$('#start_time').val(),
                    end_time=$('#end_time').val(),
                    is_train=$('input[name="is_train"]:checked').val();
                is_qualified=$('input[name="is_qualified"]:checked').val();

                if(start_time == ''){
                    layer.msg('开始时间不能为空',{icon:0});
                    return false;
                }
                if(end_time == ''){
                    layer.msg('结束时间不能为空',{icon:0});
                    return false;
                }
                var time_code=start_time+' - '+end_time;
                if(is_train>0)
                {
                    table.render({
                        id: 'test'
                        ,toolbar: true
                        ,elem: '#test'
                        , url: 'getTrainUser'
                        ,method:'post'
                        ,totalRow: true
                        ,where: {
                            time_code: time_code,
                            department: department,
                            project:project,
                            username:username,
                            station:station,
                            classify: classify,
                            is_train:is_train,
                            is_qualified:is_qualified,
                        }

                        , cols: [[
                            {type:'numbers', minWidth: 20, title: '编号'}
                            ,{field:'region_title',  align:'center',  title: '地区'}
                            ,{field:'department_title', align:'center',  title: '部门'}
                            ,{field:'station_title', align:'center', title: '岗位'}
                            ,{field:'project_title', align:'center',  title: '项目名称'}
                            ,{field:'work_id', align:'center',  title: '工号'}
                            ,{field:'username', align:'center',  title: '用户名'}
                            ,{field:'classify_title', align:'center',  title: '培训分类'}
                            ,{field:'branch', align:'center',  title: '考试成绩'}
                            ,{field:'price', align:'center',  title: '培训费用', totalRow: true}
                            ,{field:'startdate', align:'center',  title: '考试时间'}
                        ]],
                        done: function(res, curr, count){

                            b = $('.layui-table-total td[data-field=price] .layui-table-cell').text();
                            this.elem.next().find('.layui-table-total td[data-field=price] .layui-table-cell').text('总计'+b+'.00元');

                        }
                    });
                }else{
                    table.render({
                        id: 'test'
                        ,toolbar: true
                        ,elem: '#test'
                        , url: 'getTrainUser'
                        ,method:'post'
                        ,where: {
                            time_code: time_code,
                            department: department,
                            project:project,
                            username:username,
                            station:station,
                            classify: classify,
                            is_train:is_train,
                            is_qualified:is_qualified,
                        }

                        , cols: [[
                            {type:'numbers', minWidth: 20, title: '编号'}
                            ,{field:'region',  align:'center',  title: '地区'}
                            ,{field:'department', align:'center',  title: '部门'}
                            ,{field:'station', align:'center', title: '岗位'}
                            ,{field:'project', align:'center',  title: '项目名称'}
                            ,{field:'work_id', align:'center',  title: '工号'}
                            ,{field:'username', align:'center',  title: '用户名'}

                        ]]
                    });
                }

            });
        }
        if (data.value == 'x') {
            $("#j").attr("style", "display:none;");
            $("#d").attr("style", "display:none;");
            $("#p").attr("style", "display:none;");
            $("#x").attr("style", "display:block;");

            laydate.render({
                elem: '#start_times'
            });
            laydate.render({
                elem: '#end_times'
            });

//监听select start
            form.on('select(classtype)', function(data){

                $.ajax({
                    url: "classinfo" ,
                    data: {'pid':data.value,'levels':'1'} ,
                    type: "post" ,
                    dataType:'json',
                    success:function(data){
                        var lists=data.data;
                        $("#classnamelist").html('');
                        $("#classify").empty();
                        $("#classname").empty();
                        $("#classify").append("<option value=''>请选择</option>");
                        for(var i=0;i<lists.length;i++){
                            console.log(i+": "+lists[i]['title'])
                            $('#classify').append('<option value="'+lists[i]['id']+'">'+lists[i]['title']+'</option>');
                        }
                        form.render('select');
                        //layer.msg(data.msg, {icon: data.code},function(){$(".layui-laypage-btn").click();});
                    }
                })
            });
            form.on('select(classify)',function(data){
                console.log(data.value);

            });
            var demo6 = xmSelect.render({
                el: '#demo6',
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
                direction:'down',
                height: '400px',
                filterable:false,
                data(){
                return {$lists1}
            }
        })

        var demo7 = xmSelect.render({
            el: '#demo7',
            toolbar:{
                show: true,
            },
            filterable: false,
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
            direction:'down',
            height: '400px',
            data: {$posts1}
        })
        //监听select end
        //触发搜索
        $(document).on('click','#statistics1',function(){
            //部门和岗位不能为空，课程二级分类不能为空
            var department=demo6.getValue('valueStr'),//部门
                station=demo7.getValue('valueStr'),//岗位
                classify=$('#classify').val(),
                start_time=$('#start_times').val(),
                end_time=$('#end_times').val(),
                is_train=$('input[name="is_trains"]:checked').val();

            if(start_time == ''){
                layer.msg('开始时间不能为空',{icon:0});
                return false;
            }
            if(end_time == ''){
                layer.msg('结束时间不能为空',{icon:0});
                return false;
            }
            var time_code=start_time+' - '+end_time;
            if(classify == ''){
                layer.msg('课程分类不能为空',{icon:0});
                return false;
            }

            table.render({
                id: 'test'
                ,toolbar: true
                ,elem: '#test'
                , url: 'assessment'
                ,method:'post'
                ,where: {
                    time_code: time_code,
                    department: department,
                    station:station,
                    classify: classify,
                    is_train:is_train,
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

                ]]
            });
        });
    }

    if (data.value == 'g') {
        $("#d").attr("style", "display:none;");
        $("#x").attr("style", "display:none;");
        $("#p").attr("style", "display:none;");
        $("#j").attr("style", "display:none;");
        $("#g").attr("style", "display:block;");

        var demo18 = xmSelect.render({
            el: '#demo18',
            height: '400px',
            direction:'down',
            filterable: true,
            theme:{
                color:'#FF5722',
            },
            data: {$userArr}
        })
        $(document).on('click','#statistics123',function(){
            //部门和岗位不能为空，课程二级分类不能为空
            var username =demo18.getValue('valueStr');//岗位
            table.render({
                id: 'test'
                ,toolbar: true
                ,elem: '#test'
                , url: 'getTrainUsers'
                ,method:'post'
                ,totalRow: true
                ,where: {
                    username:username,
                    is_train:1,
                    is_qualified:1,
                    work_id:$('#work_id').val(),
                }

                , cols: [[
                    {type:'numbers', minWidth: 20, title: '编号'}
                    ,{field:'region_title',  align:'center',  title: '地区'}
                    ,{field:'department_title', align:'center',  title: '部门'}
                    ,{field:'station_title', align:'center', title: '岗位'}
                    ,{field:'project_title', align:'center',  title: '项目名称'}
                    ,{field:'work_id', align:'center',  title: '工号'}
                    ,{field:'username', align:'center',  title: '用户名'}
                    ,{field:'classify_title', align:'center',  title: '培训分类'}
                    ,{field:'branch', align:'center',  title: '考试成绩'}
                    ,{field:'price', align:'center',  title: '培训费用', totalRow: true}
                    ,{field:'startdate', align:'center',  title: '考试时间'}
                ]],
                done: function(res, curr, count){
                    b = $('.layui-table-total td[data-field=price] .layui-table-cell').text();
                    $('#priceContent').text('金额：'+b+'.00元');
                    this.elem.next().find('.layui-table-total').hide();
                }
            });
        });

    }

    if (data.value == 'j') {
        $("#d").attr("style", "display:none;");
        $("#x").attr("style", "display:none;");
        $("#p").attr("style", "display:none;");
        $("#j").attr("style", "display:block;");
        laydate.render({
            elem: '#start_time1'
        });
        laydate.render({
            elem: '#end_time1'
        });
        var demo8 = xmSelect.render({
            el: '#demo8',
            height: '400px',
            direction:'down',
            filterable: true,
            theme:{
                color:'#FF5722',
            },
            data: {$userArr}
        })

        $(document).on('click','#statistics2',function(){
            //部门和岗位不能为空，课程二级分类不能为空
            var username =demo8.getValue('valueStr'),//岗位
                start_time=$('#start_time1').val(),
                end_time=$('#end_time1').val();

            if(start_time == ''){
                layer.msg('开始时间不能为空',{icon:0});
                return false;
            }
            if(end_time == ''){
                layer.msg('结束时间不能为空',{icon:0});
                return false;
            }
            var time_code=start_time+' - '+end_time;

            table.render({
                id: 'test'
                ,toolbar: true
                ,elem: '#test'
                , url: 'teacher'
                ,method:'post'
                ,totalRow: true
                ,where: {
                    time_code: time_code,
                    username:username,
                }

                , cols: [[
                    {type:'numbers', minWidth: 20, title: '编号'}
                    ,{field:'region_title',  align:'center',  title: '地区'}
                    ,{field:'headmaster',  align:'center',  title: '班主任'}
                    ,{field:'classify_title', align:'center',  title: '培训类型'}
                    ,{field:'startdate', align:'center',  title: '培训日期'}
                    ,{field:'username', align:'center',  title: '参训名单'}
                    ,{field:'department_title', align:'center', title: '部门'}
                    ,{field:'station_title', align:'center', title: '岗位'}
                    ,{field:'project_title', align:'center',  title: '项目名称'}
                    ,{field:'branch', align:'center',  title: '考试成绩'}
                    ,{field:'money', align:'center',  title: '绩效', totalRow: true}
                ]],
                done: function(res, curr, count){

                    b = $('.layui-table-total td[data-field=money] .layui-table-cell').text();
                    this.elem.next().find('.layui-table-total td[data-field=money] .layui-table-cell').text('总计'+b+'.00元');

                }
            });
        });
    }
    if (data.value == 'p') {
        $("#d").attr("style", "display:none;");
        $("#x").attr("style", "display:none;");
        $("#j").attr("style", "display:none;");
        $("#p").attr("style", "display:block;");
        laydate.render({
            elem: '#start_time2'
        });
        laydate.render({
            elem: '#end_time2'
        });

        var demo9 = xmSelect.render({
            el: '#demo9',
            toolbar:{
                show: true,
            },
            filterable: false,
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
            direction:'down',
            height: '400px',
            data: {$posts1}
        })
        var demo10 = xmSelect.render({
            el: '#demo10',
            toolbar:{
                show: true,
            },
            filterable: false,
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
            direction:'down',
            height: '400px',
            data: {$classifyNew}
        })

        $(document).on('click','#statistics4',function(){
            //部门和岗位不能为空，课程二级分类不能为空
            var classify=demo10.getValue('valueStr'),//岗位
                station=demo9.getValue('valueStr'),
                start_time=$('#start_time2').val(),
                end_time=$('#end_time2').val();

            if(start_time == ''){
                layer.msg('开始时间不能为空',{icon:0});
                return false;
            }
            if(station == ''){
                layer.msg('岗位不能为空',{icon:0});
                return false;
            }
            if(end_time == ''){
                layer.msg('结束时间不能为空',{icon:0});
                return false;
            }
            var time_code=start_time+' - '+end_time;

            table.render({
                id: 'test'
                ,toolbar: true
                ,elem: '#test'
                , url: 'peixun'
                ,totalRow: true
                ,method:'post'
                ,where: {
                    time_code: time_code,
                    classify: classify,
                    station:station

                }

                , cols: [[
                    {type:'numbers', minWidth: 20, title: '编号'}
                    ,{field:'department', align:'center',  title: '部门'}
                    ,{field:'studys', align:'center', title: '总培训人数（离职+在岗）', totalRow: true}
                    ,{field:'study', align:'center', title: '培训人数（在岗）', totalRow: true}
                    ,{field:'notStudy', align:'center', title: '未培训人数（在岗）', totalRow: true}
                    ,{field:'count', align:'center',  title: '总人数（在岗）', totalRow: true}
                    ,{field:'bate', align:'center',  title: '培训率'}
                ]],
                done: function(res, curr, count){

                    zai = $('.layui-table-total td[data-field=study] .layui-table-cell').text();
                    zong = $('.layui-table-total td[data-field=count] .layui-table-cell').text();
                    i = (zai/zong*100).toFixed(2);
                    $('.layui-table-total td[data-field=bate] .layui-table-cell').text(i+'%');


                }
            });


        });
    }
    })


    })

</script>
{include file="public/footer" /}