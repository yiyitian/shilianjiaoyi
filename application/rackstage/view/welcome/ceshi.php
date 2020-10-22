<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="/public/webuploader/webuploader/webuploader.css">
    <link rel="stylesheet" href="/public/layui/css/layui.css">
    <!--引入JS-->
    <script type="text/javascript" src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
    <script type="text/javascript" src="/public/webuploader/webuploader/webuploader.js"></script>
    <style>
        body{
            background-image:url("../../../img/8.jpg");
            background-size:100% 100% ;
            /*width:100%;
            height: 100%;*/
            font-family: 'Oleo Script', cursive;
        }
    </style>
</head>
<body>
<center>
    <div id="uploader" style="width: 800px;margin: auto;margin-top:100px; ">
        <h1 style="color: #00a7d0">视频(切片)上传</h1>
        <div id="thelist" class="uploader-list"></div>
        <div class="btns">
            <table style="width: 300px;" border="1">
                <tr align="right">
                    <td>
                        <div id="picker" style="float:left">选择文件</div>
                    </td>
                    <td>
                        <button id="ctlBtn" class="btn btn-default" style="padding:8px 15px;">开始上传</button>
                    </td>
                </tr>
            </table>
        </div>

    </div>
</center>
<script type="text/javascript">
    $(function(){
        var $list=$("#thelist");   //这几个初始化全局的百度文档上没说明，好蛋疼。  
        var $btn =$("#ctlBtn");   //开始上传  

        var uploader = WebUploader.create({
            // 选完文件后，是否自动上传。  
            auto: false,

            // swf文件路径  
            swf: '/webuploader/Uploader.swf',

            // 文件接收服务端。  
            server: "uploads",

            // 选择文件的按钮。可选。  
            // 内部根据当前运行是创建，可能是input元素，也可能是flash.  
            pick: '#picker',

            chunked: true,//开启分片上传  
            threads: 1,//上传并发数  

            method:'POST',
        });
        // 当有文件添加进来的时候  
        uploader.on( 'fileQueued', function( file ) {
            // webuploader事件.当选择文件后，文件被加载到文件队列中，触发该事件。等效于 uploader.onFileueued = function(file){...} ，类似js的事件定义。  
            $list.append( '<div id="' + file.id + '" class="item">' +
                '<h4 class="info">' + file.name + '</h4>' +
                '<p class="state">等待上传...</p>' +
                '</div>' );
        });
        // 文件上传过程中创建进度条实时显示。  
        uploader.on( 'uploadProgress', function( file, percentage ) {
            var $li = $( '#'+file.id ),
                $percent = $li.find('.progress .progress-bar');

            // 避免重复创建  
            if ( !$percent.length ) {
                $percent = $('<div class="progress progress-striped active">' +
                    '<div class="progress-bar" role="progressbar" style="width: 0%">' +
                    '</div>' +
                    '</div>').appendTo( $li ).find('.progress-bar');
            }

            $li.find('p.state').text('上传中');

            $percent.css( 'width', percentage * 100 + '%' );
        });

        // 文件上传成功，给item添加成功class, 用样式标记上传成功。  
        uploader.on( 'uploadSuccess', function( file ) {
            $( '#'+file.id ).addClass('upload-state-done');
        });

        // 文件上传失败，显示上传出错。  
        uploader.on( 'uploadError', function( file ) {
            $( '#'+file.id ).find('p.state').text('上传出错');
        });

        // 完成上传完了，成功或者失败，先删除进度条。  
        uploader.on( 'uploadComplete', function( file ) {
            // alert(file.id)
            // alert(file.error);
            // alert(file);
            $( '#'+file.id ).find('.progress').remove();
            $( '#'+file.id ).find('p.state').text('已上传');
            // location.href="http://www.xiaosan.com/tp5/public/index.php/index/backstage/vioshow";
        });
        $btn.on( 'click', function() {
            if ($(this).hasClass('disabled')) {
                return false;
            }
            uploader.upload();
        });
    });
</script>

</body>

</html>  