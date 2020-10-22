{include file="public/header" /}
<div class="layui-body">
    <div class="layui-main">
    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 30px;">
        <legend>数据筛选--时间范围内‘已授课’课程的上课情况</legend>
    </fieldset>
    <form class="layui-form" action="" id="formid"  style="margin-top: 20px;">


        <div class="layui-form-item">
    <div class="layui-inline">
      <label class="layui-form-label">开始时间  </label>
      <div class="layui-input-inline">
        <input type="text" class="layui-input" id="test1" name="createTime" placeholder="请输入开始时间"> 
    </div>
    <div class="layui-inline">
      <label class="layui-form-label">结束时间</label>
      <div class="layui-input-inline">
        <input type="text" class="layui-input" id="test2" name="endTime"  placeholder="请输入结束时间 ">
      </div>
    </div>
  </div>

        <div class="layui-form-item">
            <label class="layui-form-label">分组依据</label>
            <div class="layui-input-block">
                <input type="radio" name="group" value="1" title="地区分类" checked>
                <input type="radio" name="group" value="2" title="全部分类">
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
    elem: '#test1'
  });
              laydate.render({
    elem: '#test2'
  });
            //触发搜索
            $(document).on('click','#statistics',function(){
                //部门和岗位不能为空，课程二级分类不能为空
                var createTime =$('#test1').val()//岗位
                ,endTime = $('#test2').val()
                ,group=$("input[name='group']:checked").val();//岗位


                if(createTime == ''){
                    layer.msg('请输入开始时间！',{icon:0});
                    return false;
                }
                if(endTime == ''){
                    layer.msg('请输入结束时间！',{icon:0});
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
                        , url: 'datascreens'
                        ,method:'post'
                        ,where: {
                            createTime: createTime
                            ,endTime:endTime
                            ,group: group
                        }

                        , cols: [[
                            {type:'numbers',  title: '编号'}
                            ,{field:'classtype', align:'center',  title: '课程类型'}
                            ,{field:'area', align:'center',  title: '地区分组', sort: true}
                            ,{field:'classify', align:'center',  title: '课程分类'}
                            ,{field:'number', align:'center',  title: '培训次数',totalRow: true}
                            ,{field:'renumber',  align:'center',  title: '问卷填写人数',totalRow: true}
                            ,{field:'real_number', align:'center',  title: '培训人数',totalRow: true}
                            ,{field:'count',  align:'center',  title: '通知人数',totalRow: true}

                        ]],
                        totalRow: true,

                    });


                }else if(group==2){
                     $('#area').next('div').hide();
                    $('#classtype').next('div').hide();
                    $('#classify').next('div').show();
                    table.render({
                        id: 'classify'
                        ,toolbar: true
                        ,elem: '#classify'
                        , url: 'datascreens'
                        ,method:'post'
                        ,where: {
                            createTime: createTime
                            ,endTime:endTime
                            ,group: group
                        }
                        , cols: [[
                            {type:'numbers',  title: '编号'}

                            ,{field:'classtype', align:'center',  title: '课程分类'}
                            ,{field:'classify', align:'center',  title: '课程类型'}
                            ,{field:'number', align:'center',  title: '培训次数',totalRow: true}
                            ,{field:'renumber',  align:'center',  title: '问卷填写人数',totalRow: true}
                            ,{field:'real_number', align:'center',  title: '培训人数',totalRow: true}
                            ,{field:'count',  align:'center',  title: '通知人数',totalRow: true}

                        ]]
                        ,                        totalRow: true,

                    });
                }


            });



        })

</script>
{include file="public/footer" /}