
<link rel="stylesheet" href="_CSS_/layui.css">
{include file="public/header" /}


    <div class="layui-body">
            <!-- 内容主体区域 -->
            {volist name="list" id="vo"}
				父级栏目:<a href="edit_cate?id={$vo.id}">{$vo.title}</a><br>
				子栏目：
						{volist name="$vo['son']" id="vo_son"}
							 <a href="edit_cate?id={$vo_son.id}">{$vo_son.title}</a>
						{/volist}<br>
				{/volist}
        </div>
        <script src="/public/layui/layui.js"></script>
        


{include file="public/footer" /}