
<link rel="stylesheet" href="_CSS_/layui.css">
{include file="public/header" /}
<style>
input{display:block;}
</style>

    <div class="layui-body">
            <!-- 内容主体区域 -->
            <form action="" method="post">
				栏目id：<input name="id" type="text" value="{$cate.id}" />
				父级pid：<input name="pid" type="text" value="{$cate.pid}" />
				栏目：<input name="title" type="text" value="{$cate.title}" />
				控制器con：<input name="cont" type="text" value="{$cate.cont}" />
				action：<input name="act" type="text" value="{$cate.act}" />
				排序：<input name="orderby" type="text" value="{$cate.orderby}" />
				
				
				
				<input name="add" type="submit" value="提交" />
			</form>
        </div>
        <script src="/public/layui/layui.js"></script>
        


{include file="public/footer" /}