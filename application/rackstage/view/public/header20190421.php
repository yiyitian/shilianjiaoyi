<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>山东世联交易业务运营平台</title>
    <link rel="stylesheet" href="_CSS_/layui.css?v=2.3">


</head>
<style>
    .layui-table-cell {
        font-size:14px;
        padding:0 5px;
        height:auto;
        overflow:visible;
        text-overflow:inherit;
        white-space:normal;
        word-wrap: break-word;
    }
    .layui-logo img{
        margin-top:0px;
        margin-left:20px;
    }
    .layui-layout-admin .layui-logo{font-size:32px;font-family: "Microsoft Yahei", "微软雅黑", Arial, "宋体", "sans-serif";width:auto;
        line-height:70px;color:#f5f5f5;
    }
	.layui-nav-itemed>a{background:#4e5465;}
</style>
<body class="layui-layout-body">
<div class="layui-layout layui-layout-admin">
    <div class="layui-header" >
        <div class="layui-logo"><img src="/logos.png"  alt="" /> 山东世联交易业务运营平台</div>

        <ul class="layui-nav layui-layout-right">
            <li class="layui-nav-item">
                <a href="javascript:;" style="padding-right: 25px;">
                    <img src="{$head_img}" class="layui-nav-img">
{$user_name}
                </a>
                <dl class="layui-nav-child" style="top:88px">
                    <dd id="edit_pwd"><a href="#">修改密码</a></dd>
                    <dd id="edit_head"><a href="#">更换头像</a></dd>
                    <dd><a href="/rackstage/login/login_out">退出登录</a></dd>
                </dl>
            </li>

        </ul>
    </div>

    <div class="layui-side layui-bg-black" style="top:80px;">
        <div class="layui-side-scroll">
            <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
            <ul class="layui-nav layui-nav-tree "  lay-filter="test" >
              {volist name="lists" id="vo"}
                <?php if(isset($vo['son'])){?>
                    <li class="layui-nav-item {eq name=':request()->controller()' value='$vo["cont"]'}layui-nav-itemed{/eq} ">
                        <a href="javascript:;"><i class="layui-icon {$vo.icon}"></i> {$vo.title}</a>
                        {volist name="$vo.son" id="son"}
                            <dl class="layui-nav-child ">

                                <dd {eq name=':request()->action()' value='$son["act"]'} {eq name=':request()->controller()' value='$vo["cont"]'} class="layui-this" {/eq} {/eq} ><a href="/rackstage/{$son.cont}/{$son.act}"><i class="layui-icon {$son.icon}"></i> {$son.title}</a></dd>

                            </dl>
                        {/volist}
                    </li>
                <?php }else{?>
                    <li class="layui-nav-item {eq name=':request()->controller()' value='$vo["cont"]'}layui-this{/eq} "><a href="/rackstage/{$vo.cont}/{$vo.act}">{$vo.title}</a></li>
                <?php }?>
              {/volist}

            </ul>
        </div>
    </div>