<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>layui</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="/public/layui/css/layui.css"  media="all">
    <!-- 注意：如果你直接复制所有代码到本地，上述css路径需要改成你本地的 -->
</head>
<style>
    .layui-upload-img{width: 92px;  height: 92px;  margin: 0 10px 10px 0; }
</style>
<body>

{$list.content}

</body>
</html>

<script type="text/javascript" src="/public/kindeditor/plugins/jwplayer/jwplayer.js"></script>
<script type='text/javascript'>
    //非视频，不加载播放器
    if(document.getElementById('player')!=null)
    {
        jwplayer('player').onReady(function() {});
        jwplayer('player').onPlay(function() {});
        //jwplayer('player').play(); //自动播放？
    }
</script>
