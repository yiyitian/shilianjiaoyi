{include file="public/header" /}
<link type="text/css" rel="stylesheet" href="/public/echarts/css/index.css" />
<div class="layui-body">
    <div class="layui-main">
    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 30px;">
        <legend>统计图</legend>
    </fieldset>
    <form class="layui-form" action="" id="formid"  style="margin-top: 20px;">


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


        <div class="layui-form-item">
            <label class="layui-form-label">查询条件</label>
            <div class="layui-input-block">
                <input type="radio" name="group" value="1" title="培训场次分布" checked>
                <input type="radio" name="group" value="2" title="培训人数分布">
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
        <div id="num_of_times" class="chart" style="width:70%;float:left;height:270px;"></div>
        <div id="num_of_people" class="chart" style="width:70%;float:left;height:270px;"></div>
    </div>
</div>
<script src="/public/layui/layui.js" charset="utf-8"></script>
<script type="text/javascript" src="/public/echarts/js/echarts.min.js"></script>
<script>
        layui.use(['layer','table', 'form','element','laydate','jquery'], function(){
            var layer = layui.layer
                ,$=layui.jquery

                ,laydate = layui.laydate;
            laydate.render({
    elem: '#test1'
  });
              laydate.render({
    elem: '#test2'
  });
            var clientWidth=$(window).width();
            var clientHeight=$(window).height();
            $('.chart').css('height',clientHeight*.3);
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

                

                $.ajax({
                    url: "chart" ,
                    data: {
                        createTime: createTime
                            ,endTime:endTime
                            ,group: group
                    } ,
                    type: "post" ,
                    dataType:'json',
                    success:function(data){
                        console.log(data.data);
                        if(data.data==''){
                            layer.msg('范围内无数据！',{icon:0});
                            return false;
                        }
                        //环状图start
                        if(group==1){

                            data=JSON.parse(JSON.stringify(data.data.area));
                            var ring = echarts.init(document.getElementById('num_of_times'));
                            var title_text='培训场次分布'
                        }else if (group==2){
                            data=JSON.parse(JSON.stringify(data.data.num));
                            var ring = echarts.init(document.getElementById('num_of_people'));
                            var title_text='培训人数分布'
                        }

                        ring.setOption({
                            color:["#33bb9f","#ffa259","#4cbbe6","#ffae8b","#9084ff","#fb7293","#f66bbf","#aca5ff"],
                            title : {
                                text: title_text,
                                x:'center',
                                y:'top',
                                textStyle: {
                                    fontSize: 18,
                                    fontWeight: 'bolder',
                                    color: '#333'          // 主标题文字颜色
                                },
                            },
                            tooltip : {
                                trigger: 'item',
                                formatter: "{a} <br/>{b} : {c} ({d}%)"
                            },
                            legend: {
                                type: 'scroll',
                                orient: 'vertical',
                                right: 0,
                                top: 20,
                                bottom: 20,
                                data: data,

                            },
                            series : [
                                {
                                    name: '数据分析',
                                    type: 'pie',
                                    radius : '30%',
                                    label: {
                                        normal: {
                                            formatter: '{b} :\n {c} ({d}%) ',
                                        }
                                    },
                                    data: data
                                }
                            ]
                        }) ;
///////////////////////统计图end
                    }
                })


            });


        })

</script>
{include file="public/footer" /}