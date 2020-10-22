<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>layui</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="/public/layui/css/layui.css"  media="all">
    <script type="text/javascript" src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/public/webuploader/webuploader/webuploader1.css">
    <script type="text/javascript" src="/public/webuploader/webuploader/webuploader.js"></script>
    <!-- 注意：如果你直接复制所有代码到本地，上述css路径需要改成你本地的 -->
</head>
<style>
    .layui-upload-img{width: 92px;  height: 92px;  margin: 0 10px 10px 0; }
</style>
<body>
<form class="layui-form" action="" id="formid"  style="margin-top: 20px;">
    <div class="layui-form-item">
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">名称</label>
                <div class="layui-input-inline">
                    <input type="text" name="title" autocomplete="off" value="{$list.title|default=''}" class="layui-input">
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">级别</label>
            <div class="layui-input-inline">
                <select name="levels" lay-filter="aihao">
                    <option value="1" {if condition="isset($list)&&($list.levels eq 1)"} selected="" {/if} >一级分类</option>
                    <option value="2"  {if condition="isset($list)&&($list.levels eq 2)"} selected="" {/if} >二级课程</option>
                </select>
            </div>
        </div>

        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">上传视频</label>
            <div class="layui-input-block">
                <div class="btns">
                    <button type="button" class="layui-btn layui-btn-normal" id="picker" style="float:left;margin-right:30px;">选择文件</button>
                    <div id="thelist" class="uploader-list"  style="float:left;margin-right:30px;"></div>
                    <button type="button" class="layui-btn" id="ctlBtn">开始上传</button>
                </div>
            </div>
        </div>
        {notempty name="list"}
        <input type="hidden" name='id' value="{$list.id}" />
        {/notempty}

        <input type="hidden" name="url" id="url"/>
        <input type="hidden" name="pid" value="{$pid}"/>
        <input type="hidden" name="add" value="1"/>
        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">分类备注</label>
            <div class="layui-input-block">
                <textarea placeholder="请输入备注内容" class="layui-textarea" name="mark" style="width:80%">{$list.mark|default=''}</textarea>
            </div>
        </div>
</form>
<script src="/public/layui/layui.js" charset="utf-8"></script>
<!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->
<script>
    $(function(){
        var $list=$("#thelist");
        var $btn =$("#ctlBtn");

        var uploader = WebUploader.create({
            auto: false,
            swf: '/webuploader/Uploader.swf',
            server: "uploads12",
            pick: '#picker',
            chunked: true,//开启分片上传
            threads: 1,//上传并发数
            method:'POST',
        });
        uploader.on( 'fileQueued', function( file ) {
            $list.append( '<div id="' + file.id + '" class="item">' +
                '<h4 class="info">' + file.name + '</h4>' +
                '<p class="state">等待上传...</p>' +
                '</div>' );
        });
        uploader.on( 'uploadProgress', function( file, percentage ) {
            var $li = $( '#'+file.id ),
                $percent = $li.find('.progress .progress-bar');
            if ( !$percent.length ) {
                $percent = $('<div class="progress progress-striped active">' +
                    '<div class="progress-bar" role="progressbar" style="width: 0%">' +
                    '</div>' +
                    '</div>').appendTo( $li ).find('.progress-bar');
            }
            $li.find('p.state').text('上传中');
            $percent.css( 'width', percentage * 100 + '%' );
        });

        uploader.on( 'uploadSuccess', function( file ) {
            $( '#'+file.id ).addClass('upload-state-done');
        });
        uploader.on( 'uploadError', function( file ) {
            $( '#'+file.id ).find('p.state').text('上传出错');
        });
        uploader.on( 'uploadComplete', function( file ) {
            $( '#'+file.id ).find('.progress').remove();
            $( '#'+file.id ).find('p.state').text('已上传');
            $('#url').val('/public/shipin/'+file.name);
        });
        $btn.on( 'click', function() {
            if ($(this).hasClass('disabled')) {
                return false;
            }
            uploader.upload();
        });
    });

    var callbackdata;
    layui.use(['layer', 'form','element','jquery'], function(){
        var layer = layui.layer
            ,$=layui.jquery
            ,form = layui.form;
        form.on('select(cate)', function(data){
            $.ajax({
                url: "getCate" ,
                data: {'pid':data.value} ,
                type: "get" ,
                dataType:'json',
                success:function(data){
                    $("#date").empty();
                    $("#date").append("<option value=''>请选择</option>");//新增
                    for(var i = 0; i < data.length; i++){
                        $("#date").append("<option value='"+data[i].id+"'>"+data[i].title+"</option>");//新增
                    }
                    form.render('select');
                }
            })
        });
        form.on('select(date)', function(data){
            $.ajax({
                url: "getCate" ,
                data: {'pid':data.value} ,
                type: "get" ,
                dataType:'json',
                success:function(data){
                    $("#city").empty();
                    $("#city").append("<option value=''>请选择</option>");//新增
                    for(var i = 0; i < data.length; i++){
                        $("#city").append("<option value='"+data[i].id+"'>"+data[i].title+"</option>");//新增
                    }
                    form.render('select');
                }
            })
        });
        //返回值
        callbackdata=function () {
            if(!verifycontent()){
                false;
            }else {
                var data =$("#formid").serialize();
                return data;
            }
        }
        //自定义验证规则
        function verifycontent() {
            //if($('#contract_num').val()==""){ layer.alert('合同编号不能为空'); return false;};
            return true;

        }

    })

</script>
</body>
</html>