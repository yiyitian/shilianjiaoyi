<!DOCTYPE html>
<html style="background-color: rgb(255, 255, 255); font-size: 48px;">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="wap-font-scale" content="no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>个人信息</title>
    <link type="text/css" rel="stylesheet" href="/public/api/css/style.css">
    <link rel="stylesheet" href="/public/api/css/pandastar.css">
    <link type="text/css" rel="stylesheet" href="/public/api/css/top.css">
    <link rel="stylesheet" type="text/css" href="/public/api/LCalendar/css/index.css" />
    <link rel="stylesheet" type="text/css" href="/public/api/LCalendar/css/LCalendar.css" />
    <script type="text/javascript" src="/public/layui/layui.js"></script>
    <link rel="stylesheet" href="/public/layui/css/layui.css" type="text/css">
</head>
<body>

<section class="aui-flexView">
    <div class="header">
        <div class="box">
            <div class="L"><a onClick="javascript:history.back(-1)" class="goback"><i class="go-left"></i></a></div>
            <div class="C"><p>更换头像</p></div>
        </div>
    </div>
    <form id="form">
        <div class='my-grzltx'>
            <div class="layui-upload" style="text-align:center">
                <div  id="test10" style="position: relative;
    padding-top: 30px;
    background-color: #fff;
    text-align: center;
    cursor: pointer;
    color: #999;">
                    <p><img id="avatar" src="{$info.avatar|default='/public/imgs/touxiang.png'}" style="border-radius:20%" alt=""/></p>
                </div>
            </div>
        </div>
    </form>
</section>

<script>
    layui.use('upload', function() {
        var $ = layui.jquery
            , upload = layui.upload;
        var clientWidth=$(window).width();
        var clientHeight=$(window).height();
        $(document).on('click','#add',function(){
            var index = layer.open({
                type: 2,
                shade: [0.1],
                title:"添加/编辑",
                area: [clientWidth*.7+'px', clientHeight*.6+'px'],
                maxmin: true,
                content: '/index/login/class_add?id=1',
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
                        url:"/index/login/class_add",
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
        upload.render({
            elem: '#test10'
            ,url: 'uploads?cid='+{$info.id}
            ,done: function(res){
                layer.msg('更换成功');
                document.getElementById('avatar').src = res.src;
                document.getElementById('ava').value = res.src;
            }
        });
        $("#anq_tuic").click(function()
        {
            var i = $("form").serialize();
            $.ajax({
                url: "personal" ,
                data: i ,
                type: "post" ,
                dataType:'json',
                success:function(data){
                    if(data.code == 2)
                    {
                        alert(data.msg);
                    }else{
                        layer.msg(data.msg,{time:1000},function () {
                            window.location.replace('/api/User/index');
                        });
                    }


                }
            })
            return false;
        })
    })
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
        $(document).on('change','#region',function(){
            console.log($(this).val());
            $.ajax({
                url: "/index/login/getCate",
                data: {'pid': $(this).val()},
                type: "get",
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    framework = data.framework
                    $("#department").empty();
                    $("#department").append("<option value=''>请选择</option>");//新增
                    for (var i = 0; i < framework.length; i++) {
                        $("#department").append("<option value='" + framework[i].id + "'>" + framework[i].name + "</option>");//新增
                    }

                    post = data.post
                    $("#station").empty();
                    $("#station").append("<option value=''>请选择</option>");//新增
                    for (var i = 0; i < post.length; i++) {
                        $("#station").append("<option value='" + post[i].id + "'>" + post[i].posts + "</option>");//新增
                    }
                    form.render('select');
                }
            })
        });
        $(document).on('change','#department',function(){
            console.log($(this).val());
            $.ajax({
                url: "/index/login/getProject",
                data: {'pid': $(this).val()},
                type: "get",
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    $("#projectname").empty();
                    $("#projectname").append("<option value=''>请选择</option>");//新增
                    if(data==''){
                        layer.msg('暂无项目', {icon:0});
                        $("#projectname").append("<option value='0'>暂无项目</option>");
                        return false;
                    }
                    for (var i = 0; i < data.length; i++) {
                        $("#projectname").append("<option value='" + data[i].id + "'>" + data[i].name + "</option>");//新增
                    }
                    form.render('select');
                }
            })
        });

    });
</script>

{include file="layouts/footer" /}
