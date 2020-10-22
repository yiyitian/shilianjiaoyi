{include file="public/header" /}
<div class="layui-body">
    <div class="layui-main">
    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 30px;">
        <legend>数据筛选--时间范围内‘已授课’课程的上课情况</legend>
    </fieldset>
    <form class="layui-form" action="" id="formid"  style="margin-top: 20px;">


        <div class="layui-form-item">
            <label class="layui-form-label">时间范围</label>
            <div class="layui-input-inline">
                <input type="text"  id="time_code"  name="time_code" value=""  placeholder="请选择" class="layui-input">
            </div>
            <div class="layui-inline layui-word-aux">此时间为“修改为‘已授课’的时间”</div>
        </div>


        <div class="layui-form-item">
            <label class="layui-form-label">分组依据</label>
            <div class="layui-input-block">
                <input type="radio" name="group" value="1" title="培训区域" checked>
                <input type="radio" name="group" value="2" title="培训类型">
                <input type="radio" name="group" value="3" title="培训内容">
            </div>
            <div class="layui-inline layui-word-aux">

            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label"></label>
            <div class="layui-input-block">
                <span class="layui-btn" id="statistics" >查询</span>
            </div>
        </div>

    </form>
        <table class="layui-hide"  lay-filter="area" id="area"></table>
        <table class="layui-hide"  lay-filter="classtype" id="classtype"></table>
        <table class="layui-hide"  lay-filter="classify" id="classify"></table>
    </div>
</div>
<script src="/public/layui/layui.js" charset="utf-8"></script>
<script>
        layui.use(['layer','table', 'form','element','laydate','jquery'], function(){
            var table = layui.table
                ,layer = layui.layer
                ,$=layui.jquery
                ,form = layui.form
                ,laydate = layui.laydate;
            laydate.render({
                elem: '#time_code'
                ,range: true
            });
            //触发搜索
            $(document).on('click','#statistics',function(){
                //部门和岗位不能为空，课程二级分类不能为空
                var time_code=$('#time_code').val()//岗位
                var group=$("input[name='group']:checked").val();//岗位


                if(time_code == ''){
                    layer.msg('请输入筛选条件！',{icon:0});
                    return false;
                }

                if(group==1){
                    $('#area').next('div').show();
                    $('#classtype').next('div').hide();
                    $('#classify').next('div').hide();
                    table.render({
                        id: 'area'
                        ,toolbar: true
                        ,elem: '#area'
                        , url: 'datascreen'
                        ,method:'post'
                        ,where: {
                            time_code: time_code
                            ,group: group
                        }

                        , cols: [[
                            {type:'numbers',  title: '编号'}
                            ,{field:'area', align:'center',  title: '地区分组', sort: true}
                            ,{field:'classtype_name', align:'center',  title: '课程类型'}
                            ,{field:'classify_name', align:'center',  title: '课程分类'}
                            ,{field:'num', align:'center',  title: '培训次数',totalRow: true}
                            ,{field:'ying',  align:'center',  title: '培训人数',totalRow: true}
                            ,{field:'notice',  align:'center',  title: '通知人数',totalRow: true}
                            ,{field:'wei', align:'center',  title: '未培训人数',totalRow: true}

                        ]],
                        totalRow: true,

                    });


                }else if(group==2){
                    $('#area').next('div').hide();
                    $('#classtype').next('div').show();
                    $('#classify').next('div').hide();
                    table.render({
                        id: 'classtype'
                        ,toolbar: true
                        ,elem: '#classtype'
                        , url: 'datascreen'
                        ,method:'get'
                        ,where: {
                            time_code: time_code
                            ,group: group
                        }

                        , cols: [[
                            {type:'numbers',  title: '编号'}
                            ,{field:'classtype_name', align:'center',  title: '课程类型', sort: true}
                            ,{field:'area', align:'center',  title: '地区标签'}
                            ,{field:'num', align:'center',  title: '培训次数',totalRow: true}
                            ,{field:'ying',  align:'center',  title: '培训人数',totalRow: true}
                            ,{field:'notice',  align:'center',  title: '通知人数',totalRow: true}
                            ,{field:'wei', align:'center',  title: '未培训人数',totalRow: true}

                        ]]
                        ,                        totalRow: true,

                    });
                }else if(group==3){
                    $('#area').next('div').hide();
                    $('#classtype').next('div').hide();
                    $('#classify').next('div').show();
                    table.render({
                        id: 'classify'
                        ,toolbar: true
                        ,elem: '#classify'
                        , url: 'datascreen'
                        ,method:'post'
                        ,where: {
                            time_code: time_code
                            ,group: group
                        }
                        , cols: [[
                            {type:'numbers',  title: '编号'}

                            ,{field:'classify_name', align:'center',  title: '课程分类'}
                            ,{field:'classtype_name', align:'center',  title: '课程类型'}
                            ,{field:'num', align:'center',  title: '培训次数',totalRow: true}
                            ,{field:'ying',  align:'center',  title: '培训人数',totalRow: true}
                            ,{field:'notice',  align:'center',  title: '通知人数',totalRow: true}
                            ,{field:'wei', align:'center',  title: '未培训人数',totalRow: true}

                        ]]
                        ,                        totalRow: true,

                    });
                }


            });



        })

</script>
{include file="public/footer" /}