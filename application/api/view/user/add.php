<!DOCTYPE html>
<html style="background-color: rgb(255, 255, 255); font-size: 48px;">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="wap-font-scale" content="no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>创建文件夹</title>
    <link type="text/css" rel="stylesheet" href="/public/api/css/style.css">
    <link type="text/css" rel="stylesheet" href="/public/api/css/top.css">

    <link rel="stylesheet" href="/public/layui/css/layui.css"  media="all">
<script src="/public/layui/layui.js" charset="utf-8"></script>
<!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->
<script src="/public/layui/layui-xtree.js" charset="utf-8"></script>

</head>
<body>

<section class="aui-flexView">
    <div class="header">
        <div class="box">
            <div class="L"><a onClick="javascript:history.back(-1)" class="goback"><i class="go-left"></i></a></div>
            <div class="C"><p>创建文件夹</p></div>
        </div>
    </div>
    <section class="aui-scrollView" style="padding-top:40px;">
        <form class="layui-form" action="" id="formid" style="margin-top: 20px;">
    <div class="layui-form-item">
        <label class="layui-form-label"  style="width:80px;">文件夹名称</label>
        <div class="layui-input-inline">
            <input type="text" id="files" name="files" value="{$list.files|default=''}" placeholder="请输入文件夹名称" style="width:90%"  autocomplete="off" class="layui-input">
        </div>
        
    </div>
    {notempty name="$id"}
        <input type="hidden" id="id" name="id" value="{$id}" />
    {/notempty}
    
    <div class="layui-form-item">
        <label class="layui-form-label" style="width:80px;">查阅权限</label>
        <div class="layui-input-block" style="margin-left:80px;">
            <div id="xtree3" class="xtree_contianer " style="padding-left:20px;"></div>
        </div>
    </div>

    <div class="layui-form-item layui-form-text">
        <label class="layui-form-label"  style="width:80px;">备注</label>
        <div class="layui-input-block">
            <textarea placeholder="请输入备注" class="layui-textarea" name="content" style="width:80%">{$list.content|default=''}</textarea>
        </div>
    </div>
        <input type="hidden" name="role" value="" id="department"/>
        <div style="text-align:center;margin-bottom:30px;">
                      <button type="submit" class="layui-btn" lay-submit=""  style="background:#d0111b" lay-filter="demo1">创建文件夹</button>


        </div>
</form>
    </section>
</section>
<script>
   layui.use(['layer', 'form','element','jquery','laydate'], function(){
        var layer = layui.layer
            ,$=layui.jquery
            ,form = layui.form
            ,laydate=layui.laydate
        laydate.render({
            elem:"#birthday",
        })
        laydate.render({
            elem:"#start_time",
        })
        form.on('submit(demo1)', function(data){
                var _allck = xtree3.GetAllCheckBox();
                var arr = new Array();
                var arrIndex = 0;
                for (var i = 0; i < _allck.length; i++) {
                    if (_allck[i].checked) {
                        arr[arrIndex] = _allck[i].value;

                        arrIndex++;
                    }
                }
                if('' == arr)
                {
                    alert('查阅权限不能为空');return false;
                }
                if('' == $('#files').val())
                {
                    alert('文件夹名称不能为空');return false;
                }
                $('#department').val(arr.join(","));
                var data =$("#formid").serialize();
                $.ajax({
                        url: "Add" ,
                        data: data,
                        type: "post" ,
                        dataType:'json',
                        success:function(data){
                            if(data.code==1){
                                layer.msg(data.msg,{time: 500},function () {
                                    location.href="pan";
                                })
                            }else{
                                layer.msg(data.msg,{time: 500},function () {
                                    location.reload();
                                });
                            }
                        }
                    })
                return false;

        
      });

        var xtree3 = new layuiXtree({
            elem: 'xtree3'
            , form: form
            , data: 'getDepartments?id=-1'
            , isopen: true
            , ckall: true
            , ckallback: function () { } //全选框状态改变后执行的回调函数
            , icon: {
                open: "&#xe7a0;"
                , close: "&#xe622;"
                , end: "&#xe621;"
            }
            , color: {
                open: "#EE9A00"
                , close: "#EEC591"
                , end: "#828282"
            }
            , click: function (data) {
                console.log(data.elem);

            }
        });
    
    })
</script>

{include file="layouts/footer" /}

