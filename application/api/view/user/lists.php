<!doctype html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, maximum-scale=1.0, initial-scale=1.0, user-scalable=0" />
    <title>我的网盘</title>
    <link type="text/css" rel="stylesheet" href="/public/api/css/style.css">
    <link type="text/css" rel="stylesheet" href="/public/api/css/top.css">
    <script type="text/javascript" src="/public/index/layer_mobile/layer.js"></script>
    <link rel="stylesheet" href="/public/layui/css/layui.css" type="text/css">
    <script type="text/javascript" src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>

    <link rel="stylesheet" type="text/css" href="/public/webuploader/webuploader/webuploader.css">
    <script type="text/javascript" src="/public/webuploader/webuploader/webuploader.js"></script>
    <style>
        .search {
            height: 33px;
            border: 1px solid #ccc;
            background-color: #f2f2f5;
            margin: 10px;
        }
        .search_input {
            float: left;
            height: 32px;
            line-height: 28px \9;
            padding: 0 8px;
            width: 79%;
        }
        .search_btn {
            width: 12%;
            height: 33px;
            background: url(../../public/api/images/search.png) center no-repeat;
            background-size: 100%;
            float: right;
            margin-right: 10px;
        }
    </style>

</head>

<body>

<div class="clear"></div>
<div class="header">
    <div class="box">
        <div class="L"><a onClick="javascript:history.back(-1)" class="goback"><i class="go-left"></i></a></div>
        <div class="C"><p>详情</p></div>
        <div class="R" style="position: absolute;right: 10px;top: 0;color: #fff;line-height: 39px;" id="picker"><p>上传文件</p></div>
    </div>
</div>
<div class="courseBox" style="padding-top:50px;">
    <div class="search">
        <input type="text" class="search_input" placeholder="请输入搜索词"/>
        <input type="button" class="search_btn"/>
    </div>
    <ul class="ul_5">
        {volist name="list" id="vo"}
        <li>
            <a class="ul-5-img">
                <img src="/public/api/images/file.png" />
            </a>
            <a href="{$vo.urls}">
                <div class="R">
                    <div class="tit">{$vo.name}</div>
                    <div class="sub">
                        <span>{$vo.times}</span>&nbsp;&nbsp;-
                        <span>{$vo.size}k</span>
                    </div>
                </div>
            </a>
        </li>
        {/volist}

    </ul>
</div>



<div style="width:100%;text-align:center;">
    <div id="uploader" style=" ">
        <div id="thelist" class="uploader-list"></div>


    </div>
</div>

<script type="text/javascript">

    $('.search_btn').click(function(){
        window.location.href="lists?id={$id}&search="+$('.search_input').val();
    })
    $(function(){
        var $list=$("#thelist");
        var $btn =$("#ctlBtn");

        var uploader = WebUploader.create({
            auto: false,
            swf: '/webuploader/Uploader.swf',
            server: "uploads12?cid={$id}",
            pick: '#picker',
            chunked: true,//开启分片上传
            threads: 1,//上传并发数
            method:'POST',
        });
        uploader.on( 'fileQueued', function() {

            layer.open({
                type: 2
                ,content: '上传中'
            });
            uploader.upload();

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
            location.reload();
        });
        $btn.on( 'click', function() {
            if ($(this).hasClass('disabled')) {
                return false;
            }
            uploader.upload();
        });
    });
</script>


{include file="layouts/footer" /}