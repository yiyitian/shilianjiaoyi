<!doctype html>
<html>
<head>
    <meta name="format-detection" content="telephone=no" />
    <meta charset="utf-8">
    <meta content="山东世联交易业务运营平台" http-equiv="keywords">
    <meta name="description" content="山东世联交易业务运营平台">
    <meta name="viewport" content="width=device-width,user-scalable=no, initial-scale=1">
    <title>山东世联交易业务运营平台</title>
    <link rel="stylesheet" href="/public/index/css/index.css" type="text/css">
    <link rel="stylesheet" href="/public/index/css/zy.css" type="text/css">
    <link rel="stylesheet" href="/public/index/css/swiper.min.css" type="text/css">
    <script type="text/javascript" src="/public/index/js/swiper.min.js"></script>
    <script type="text/javascript" src="/public/index/js/jquery-1.4.4.min.js"></script>
    <script type="text/javascript" src="/public/index/layer_mobile/layer.js"></script>
    <script type="text/javascript" src="/public/index/js/lCalendar.js"></script>
    <link rel="stylesheet" href="/public/index/css/lCalendar.css" type="text/css">
    <style>
        .zhuc_kluang select{width:70%;}
        .zhuc_kluang input{width:66%;}
    </style>
</head>
<body style="height: 100%;" >
<!-- 头部 -->
<div class="toub_beij">
    <div class="fanhui_jt"><a href="/index/User/personalCenter"><i class="fanh_jiant"><img src="/public/index/images/fanh_jiant_hei.png"></i><span>返回</span></a></div>
    <div class="mingc_tb">修改课程</div>
    <div class="sy_zaix"></div>
</div>
<script type="text/javascript">
    //滑动头部透明（针对首页头部用）
    window.onscroll=function(){

        var autoheight=document.body.scrollTop||document.documentElement.scrollTop;
        if(autoheight>20){
            $(".toub_beij").css("position" ,"fixed")
        }else{
            $(".toub_beij").css("position" ,"relative")
        }
    }
</script>
<!-- 内容 -->

<div class="dengl_nr_k">


    <form id="formid" action="register" method="post">

        <div class="zhuc_kluang" style="display:black;">
            <p><em></em>已学课程：</p>
            <input id="add" type="text" readonly required="required" placeholder="编辑或新增课程"  value="" />
            <input id="classid" name="classid" type="hidden" value="" />
        </div>
        

        <div class="zhuzhong_tx" id="xuanz" >
            <input id="button" type="button" class="dengl_anniu dengl_anniu_zcy" value="确定修改">
        </div>
    </form>



</div>

</body>
</html>
<script src="/public/layui/layui.js" charset="utf-8"></script>
<script type="text/javascript">
    layui.use(['upload','laydate','table','layer', 'form','element','jquery'], function() {
        var $ = layui.jquery
            , upload = layui.upload
            , table = layui.table
            , layer = layui.layer
            , form = layui.form
            , laydate = layui.laydate;
//所属岗位开始
        var clientWidth=$(window).width();
        var clientHeight=$(window).height();
  
       
        $(document).on('click','#add',function(){
            var index = layer.open({
                type: 2,
                shade: [0.1],
                title:"添加/编辑",
                area: [clientWidth*.7+'px', clientHeight*.6+'px'],
                maxmin: true,
                content: 'class_add',
                btn: ['保存','关闭'],
                zIndex: layer.zIndex, //重点1
                yes: function(index){
                    var row= window["layui-layer-iframe" + index].callbackdata();
                    if(!$.trim(row)){
                        return false;
                    }
                    console.log(row);
                    //layer.closeAll();
                    $.ajax({
                        url:"class_add",
                        type:"post",
                        dataType: "json",
                        cache: false,
                        data:row,
                        contentType: "application/x-www-form-urlencoded; charset=utf-8",
                        success:function(data){
                            console.log(data);
                            layer.closeAll();
                            if(data.code==1){
                                $('#classid').val(data.msg);
                            }else{
                                layer.msg(data.msg, {icon:0});
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
    $('#button').click(function()
    {
       var date =$("#formid").serialize();
            $.ajax({
                url: "update" ,
                data: date ,
                type: "post" ,
                dataType:'json',
                success:function(data){
                    if(data.code==1)
                    {
                        location.href="/index/User/personalCenter";
                    }
                }
            });
    
    })
   
</script>
