<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>layui</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="/public/layui/css/layui.css"  media="all">
    <!-- ע�⣺�����ֱ�Ӹ������д��뵽���أ�����css·����Ҫ�ĳ��㱾�ص� -->
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
    //����Ƶ�������ز�����
    if(document.getElementById('player')!=null)
    {
        jwplayer('player').onReady(function() {});
        jwplayer('player').onPlay(function() {});
        //jwplayer('player').play(); //�Զ����ţ�
    }
</script>
