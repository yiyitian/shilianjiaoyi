{include file="public/header" /}
<link rel="stylesheet" href="/public/layui/formSelects-v4.css"  media="all">
<div class="layui-body">
    <div class="layui-main">
    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 30px;">
        <legend>回访查询</legend>
    </fieldset>
    <form class="layui-form" action="" id="formid"  style="margin-top: 20px;">
        <div class="layui-form-item">
            <label class="layui-form-label">选择部门</label>
            <div class="layui-input-inline">
                <select name="department" xm-select="select7_0" xm-select-skin="danger" xm-select-search="">
                    {volist name="framework_pid" id="vo_pid"}
                    <optgroup label="{$vo_pid.name}">
                        {volist name="framework" id="vo"}
                        {if condition="$vo.pid eq $vo_pid.id"}
                        <option value="{$vo.id}">{$vo.name}</option>
                        {/if}
                        {/volist}
                    </optgroup>
                    {/volist}

                </select>
            </div>
        </div>
       <div class="layui-form-item">
            <label class="layui-form-label">选择项目</label>
            <div class="layui-input-inline">
                <select name="department" xm-select="select7_1" xm-select-skin="danger" xm-select-search="">
                   
                        <option value="">请选择</option>
                      
                </select>
            </div>
        </div>
 
        <div class="layui-form-item">
            <label class="layui-form-label">客户姓名</label>
            <div class="layui-input-inline">
                <input type="text"  id="customer"  name="customer" value=""  placeholder="请输入客户姓名" class="layui-input">
            </div>
            <div class="layui-inline layui-word-aux"></div>
        </div>
         <div class="layui-form-item">
            <label class="layui-form-label">抽查人</label>
            <div class="layui-input-inline">
                <select name="xunpan" xm-select="select7_3" xm-select-skin="danger" xm-select-search="">
                    {volist name="userInfo" id="vo"}
                        <option value="{$vo.id}">{$vo.user_name}</option>
                    </optgroup>
                    {/volist}

                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">抽查时间</label>
            <div class="layui-input-inline">
                <input type="text"  id="time_code"  name="time_code" value=""  placeholder="请选择时间" class="layui-input">
            </div>
        </div>
<script type="text/html" id="barDemo">
            {if condition="($_SESSION['think']['role_title'] eq '项目负责人')OR($_SESSION['think']['role_title'] eq '项目经理')"}
            <a class="layui-btn layui-btn-xs layui-btn-normal" lay-event="see">查看</a>
            {else /}
            <a class="layui-btn layui-btn-xs layui-btn-normal" lay-event="see">查看</a>
            <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
            <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
            {/if}
        </script>

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
<script src="/public/layui/formSelects-v4.js" charset="utf-8"></script>
<!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->
<script>
    //全局定义一次, 加载formSelects
    layui.config({
        base: './' //此处路径请自行处理, 可以使用绝对路径
    }).extend({
        formSelects: 'formSelects-v4'
    });

        var callbackdata;
        layui.use(['layer','table', 'form','element','laydate','jquery'], function(){
            var table = layui.table
                ,layer = layui.layer
                ,$=layui.jquery
                ,form = layui.form
                ,laydate = layui.laydate;
            laydate.render({
                elem: '#time_code'
                ,range: true
                ,done: function(value, date, endDate){
                    console.log(value); //得到日期生成的值，如：2017-08-18
                    console.log(date); //得到日期时间对象：{year: 2017, month: 8, date: 18, hours: 0, minutes: 0, seconds: 0}
                    console.log(endDate); //得结束的日期时间对象，开启范围选择（range: true）才会返回。对象成员同上。
                    if(value==''){
                        layer.msg('请选择时间范围',{icon:0,time:500})
                        return false;
                    }
                }
            });

//监听select start
            layui.formSelects.opened('select7_1', function(id){
           
            val=layui.formSelects.value('select7_0', 'val');    //取值val字符串
            $.ajax({
                url: "/rackstage/Getinfo/getProject" ,
                data: {'pid':val} ,
                type: "get" ,
                dataType:'json',
                success:function(data){
                    console.log(data);
                    project=data;
                    var formSelects = layui.formSelects;
                    formSelects.data('select7_1', 'local', {
                        arr: data
                    });
                }
            });
        });

            table.on('tool(test)', function(obj){


    var data = obj.data;
            if(obj.event === 'edit'){
                console.log(data.id);

                var index = layer.open({
                    type: 2,
                    shade: [0.1],
                    title:"添加/编辑",
                    area: ['100%', '100%'],
                    maxmin: true,
                    content: 'review_add?id='+data.id,
                    btn: ['保存','关闭'],
                    zIndex: layer.zIndex, //重点1
                    yes: function(index){
                        var row= window["layui-layer-iframe" + index].callbackdata();
                        if(!$.trim(row)){
                            return false;
                        }
                        console.log(11111);
                        $.ajax({
                            url:"review_add",
                            type:"post",
                            dataType: "json",
                            cache: false,
                            data:row,
                            contentType: "application/x-www-form-urlencoded; charset=utf-8",
                            success:function(data){
                                layer.closeAll();
                                if(data.code==1){
                                    layer.msg(data.msg,{icon:1,time: 500},function () {
                                        renderTable();//location.reload();
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
            }else if(obj.event === 'see'){
                console.log(data.id);

                var index = layer.open({
                    type: 2,
                    shade: [0.1],
                    title:"添加/编辑",
                    area: ['100%', '100%'],
                    maxmin: true,
                    content: 'review_see?id='+data.id,
                    btn: ['关闭'],
                    zIndex: layer.zIndex, //重点1
                    yes: function(index){layer.closeAll();},
                    cancel: function(){
                    },
                    end: function(){ //此处用于演示
                    }
                });
            } else if(obj.event === 'del'){
                layer.confirm('确定删除吗', function(index){
                    $.ajax({
                        url: "review_del" ,
                        data: {'id':data.id},
                        type: "post" ,
                        dataType:'json',
                        success:function(data){
                            layer.msg(data.msg, {icon: data.code,time:500},function(){renderTable();});
                        }
                    })
                });
            }
})



            //所属岗位开始
            form.on('select(region)', function(data){
                $.ajax({
                    url: "/rackstage/Personnel/getCate" ,
                    data: {'pid':data.value} ,
                    type: "get" ,
                    dataType:'json',
                    success:function(data){
                        console.log(data);
                        framework=data.framework
                        $("#department").empty();
                        $("#department").append("<option value=''>请选择</option>");//新增
                        for(var i = 0; i < framework.length; i++){
                            $("#department").append("<option value='"+framework[i].id+"'>"+framework[i].name+"</option>");//新增
                        }

                        post=data.post
                        $("#station").empty();
                        $("#station").append("<option value=''>请选择</option>");//新增
                        for(var i = 0; i < post.length; i++){
                            $("#station").append("<option value='"+post[i].id+"'>"+post[i].posts+"</option>");//新增
                        }
                        form.render('select');
                    }
                })
            });
            form.on('select(department)', function(data){
                
                $.ajax({
                    url: "/rackstage/Organizational/getProject" ,
                    data: {'pid':data.value} ,
                    type: "post" ,
                    dataType:'json',
                    success:function(data){
                        var lists=data;
                        $("#project").empty();
                        $("#project").append("<option value=''>请选择</option>");
                        for(var i=0;i<lists.length;i++){
                            console.log(i+": "+lists[i]['name'])
                            $('#project').append('<option value="'+lists[i]['id']+'">'+lists[i]['name']+'</option>');
                        }
                        form.render('select');
                        //layer.msg(data.msg, {icon: data.code},function(){$(".layui-laypage-btn").click();});
                    }
                })
            });




            //监听select end
            //触发搜索
            $(document).on('click','#statistics',function(){
                //部门和岗位不能为空，课程二级分类不能为空
                var department=layui.formSelects.value('select7_0', 'val'),//部门
                    project=layui.formSelects.value('select7_1', 'val'),
                                        enquiryer = layui.formSelects.value('select7_3', 'val'),

                    time_code=$('#time_code').val(),//时间范围
                    customer=$('#customer').val();




                table.render({
                    id: 'test'
                    ,toolbar: true
                    ,elem: '#test'
                    , url: 'review_search'
                    ,method:'post'
                    ,where: {
                        project: project,
                        department: department,
                        time_code: time_code,
                        customer:customer,
                        enquiryer:enquiryer
                    }
                    , page: { //支持传入 laypage 组件的所有参数（某些参数除外，如：jump/elem） - 详见文档
                        layout: ['limit', 'count', 'prev', 'page', 'next', 'skip'] //自定义分页布局
                        //,curr: 5 //设定初始在第 5 页
                        , limit: 25 //一页显示多少条
                        , limits: [25, 50, 100, 999999]//每页条数的选择项
                        , groups: 6 //只显示 6 个连续页码
                        , first: "首页" //不显示首页
                        , last: "尾页" //不显示尾页
                    }
                    , cols: [[
                        {type:'numbers',  title: '编号'}
                        ,{field:'department_name', align:'center',  title: '部门'}
                        ,{field:'project_name',  align:'center',  title: '项目名称'}
                        ,{field:'customer',  align:'center',  title: '客户姓名'}
                        ,{field:'phone', align:'center',  title: '客户电话'}
                        ,{field:'salesman',  align:'center',  title: '业务员'}
                        ,{field:'positive', align:'center',  title: '是否主动接待客户(是1分，否0分)'}
                        ,{field:'patient', align:'center',  title: '是否耐心回答客户的问题（是1分，否0分）'}
                        ,{field:'lucid', align:'center',  title: '客户是否清楚了解所需楼盘情况（是1分，否0分）'}
                        ,{field:'dissent', align:'center',  title: '对销售代表在接待过程中介绍的购房所产生的费用有无异议?（无1分，有0分）'}
                        ,{field:'appraise', align:'center',  title: '客户对服务评分（1-5分）'}
                        ,{field:'suggest', align:'center',  title: '对我们的服务有什么建议(包括具体的投诉和表扬，有表扬1分，无0分，投诉－1分)'}
                        ,{field:'score', align:'center',  title: '总分'}
                        ,{field:'enquirytime', align:'center',  title: '抽查时间'}
                        ,{field:'enquiryer', align:'center',  title: '抽查人'}
                        ,{field:'mark', align:'center', title: '备注'}
                        ,{width:150,   align:'center', toolbar: '#barDemo',title:'操作'}


                    ]]
                });
            });
        })



</script>
{include file="public/footer" /}