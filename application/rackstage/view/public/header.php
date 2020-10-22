<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>山东世联交易业务赋能平台2.0</title>
    <link rel="stylesheet" href="_CSS_/layui.css?v=2.3">


</head>
<style>
    .layui-logo a{color: #fff;}
    .layui-logo img{
        margin-top:0px;
        margin-left:20px;
    }
    .layui-layout-admin .layui-logo{font-size:22px;font-family: "Microsoft Yahei", "微软雅黑", Arial, "宋体", "sans-serif";width:auto;
        line-height:80px;color:#f5f5f5;
    }
    .layui-layout-admin .layui-side{width:190px;}
    .layui-side-scroll,.layui-nav-tree{width:100%;}
    .layui-body,.layui-layout-admin .layui-footer{left:190px;}
	.layui-nav-tree{text-align:left;}
</style>
<script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>

<script>
    $(function(){
        $("#urls li").click(function() {
            $(this).siblings('li').removeClass('layui-nav-itemed');  // 删除其他兄弟元素的样式
        });
    });
</script>
<body class="layui-layout-body">
<div class="layui-layout layui-layout-admin">
    <div class="layui-header" >
        <div class="layui-logo"><a href="/"><img src="/logos.png"   alt="" /> <strong>山东世联交易业务赋能平台</strong></a><div style="text-align: center;margin-top: 2px;background: #262626;float: right;height: 0;margin-right: -50px;font-size: 18px;" onclick="iconHide()"><i class="icon-color layui-icon layui-icon-shrink-right" style="color:#859bf5;font-size:20px;" id="hide"></i></div></div>

        <ul class="layui-nav layui-layout-right">
            <li class="layui-nav-item">
                <a href="javascript:;" style="padding-right: 25px;color: #fff;">
                    <img src="{$head_img}" class="layui-nav-img">
{$user_name}
                </a>
                <dl class="layui-nav-child" style="top:88px;background:#fff">
                    <dd id="edit_pwd"><a href="#">修改密码</a></dd>
                    <dd id="edit_head"><a href="#">更换头像</a></dd>
                    <dd><a href="/rackstage/login/login_out">退出登录</a></dd>
                </dl>
            </li>

        </ul>
    </div>
    <div style="width: 100%;height: 10px;background:#F2F5FF; "></div>

    <div class="layui-side" style="top:90px;background-color:#FFF;border-right: 1px solid #f0f0f0;">
        <div class="layui-side-scroll">
            
            <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
            <ul class="layui-nav layui-nav-tree "  lay-filter="test"  id="urls">

                {volist name="lists" id="vo"}
                <?php if(isset($vo['son'])){?>
                    <li class="layui-nav-item 
                    {eq name=':request()->controller()' value='$vo["cont"]'}
                    {eq name=':request()->controller()' value='Setting'}
{in name=":request()->action()" value="user,index,config,xieyi"}
                    layui-nav-itemed
                    {/in}
                    {else/}
                                        layui-nav-itemed

                    {/eq}
                    {/eq} ">
                        <a href="javascript:;"><i class="layui-icon {$vo.icon}"></i>&nbsp; &nbsp; {$vo.title}</a>
                        {volist name="$vo.son" id="son"}
                            <dl class="layui-nav-child ">

                                <dd {eq name=':request()->action()' value='$son["act"]'} {eq name=':request()->controller()' value='$vo["cont"]'} class="layui-this" {/eq} {/eq} ><a href="/rackstage/{$son.cont}/{$son.act}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="layui-icon {$son.icon}"></i>&nbsp;  {$son.title}</a></dd>

                            </dl>
                        {/volist}
                    </li>
                <?php }else{?>
                    <li class="layui-nav-item {eq name=':request()->controller()' value='Setting'}{eq name=':request()->action()' value='$vo["act"]'}layui-this{/eq} {/eq}"><a href="/rackstage/{$vo.cont}/{$vo.act}"><i class="layui-icon {$vo.icon}"></i>&nbsp; &nbsp;{$vo.title}</a></li>
                <?php }?>
                {/volist}

            </ul>
        </div>



    </div>