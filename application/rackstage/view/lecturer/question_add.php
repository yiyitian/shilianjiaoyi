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
<body>


<form class="layui-form" action="" id="formid"  style="margin-top: 20px;">
    <input type="hidden" name="id" value="{$id|default=''}">
    <input type="hidden" name="is_choose" value="1">
<!--    <div class="layui-form-item">-->
<!--        <label class="layui-form-label">问题类型</label>-->
<!--        <div class="layui-input-block">-->
<!--            {notempty name="list"}-->
<!--                <input type="radio" name="is_choose" value="1" title="选择题" {if condition="isset($list.is_choose)&&($list.is_choose eq 1)"}checked{/if}>-->
<!--                <input type="radio" name="is_choose" value="-1" title="问答题" {if condition="isset($list.is_choose)&&($list.is_choose eq -1)"}checked{/if}>-->
<!--            {else /}-->
<!--                <input type="radio" name="is_choose" value="1" title="选择题" checked>-->
<!--                <input type="radio" name="is_choose" value="-1" title="问答题" >-->
<!--            {/notempty}-->
<!--        </div>-->
<!--    </div>-->
    <div class="layui-form-item">
        <label class="layui-form-label">课程类型</label>
        <div class="layui-input-inline">
            <select name="classtype" id="classtype" lay-filter="classtype">
                {notempty name="list"}
                <option value="{$list.classtype|default=''}">{$list.classtype_name|default=''}</option>
                {else /}
                <option value=""></option>
                {/notempty}
                {volist name="classArr" id="vo"}
                <option value="{$vo.id}">{$vo.title}</option>
                {/volist}
            </select>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">课程分类</label>
        <div class="layui-input-inline">
            <select name="classify" id="classify" lay-filter="classify">
                {notempty name="list"}
                <option value="{$list.classify|default=''}">{$list.classify_name|default=''}</option>
                {else /}
                <option value=""></option>
                {/notempty}
            </select>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">课程名称</label>
        <div class="layui-input-inline">
            <select name="classname" id="classname" lay-filter="classname">
                {notempty name="list"}
                <option value="{$list.classname|default=''}">{$list.classname_name|default=''}</option>
                {else /}
                <option value=""></option>
                {/notempty}

            </select>
        </div>
    </div>
   
    <div class="layui-form-item">
        <label class="layui-form-label">问题</label>
        <div class="layui-input-inline">
            <input type="text"  id="question"  name="question" value="{$list.question|default=''}"  placeholder="请输入内容" class="layui-input">
        </div>
        <div class="layui-inline layui-word-aux"></div>
    </div>
    <div class="layui-form-item xuanze">
        <label class="layui-form-label">选项A</label>
        <div class="layui-input-inline">
            <input type="text"  id="option_a"  name="option_a" value="{$list.option_a|default=''}"  placeholder="请输入内容" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item xuanze">
        <label class="layui-form-label">选项B</label>
        <div class="layui-input-inline">
            <input type="text"  id="option_b"  name="option_b" value="{$list.option_b|default=''}"  placeholder="请输入内容" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item xuanze">
        <label class="layui-form-label">选项C</label>
        <div class="layui-input-inline">
            <input type="text"  id="option_c"  name="option_c" value="{$list.option_c|default=''}"  placeholder="请输入内容" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item xuanze">
        <label class="layui-form-label">选项D</label>
        <div class="layui-input-inline">
            <input type="text"  id="option_d"  name="option_d" value="{$list.option_d|default=''}"  placeholder="请输入内容" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item xuanze">
        <label class="layui-form-label">正确答案</label>
        <div class="layui-input-inline">
            <input type="text"  id="true_option"  name="true_option" value="{$list.true_option|default=''}"  placeholder="选择题，请复制粘贴答案内容到此处！！！" class="layui-input"  >
        </div>
    </div>

</form>
<script src="/public/layui/layui.js" charset="utf-8"></script>
<script>
    function toUpperCase(obj)
    {
        if(obj.value.length>1){
            alert('此处只能输入一个字母：A/B/C/D');
            obj.value='';
            obj.value.focus();
            return false;
        }
        obj.value = obj.value.toUpperCase()
    }
        var callbackdata;
        layui.use(['layer', 'form','element','jquery'], function(){
            var layer = layui.layer
                ,$=layui.jquery
                ,form = layui.form;

            $(".layui-form-radio").click(function(){
                var con=$(this).children('div').html();
                if(con == '问答题'){
                    $('.xuanze').css('display','none');
                }else if(con == '选择题'){
                    $('.xuanze').css('display','block');
                }
                console.log($(this).children('div').html());
            })
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

                if($('#classtype').val()==""){ layer.alert('请选择课程类型');  return false;};
                if($('#classify').val()==""){ layer.alert('请选择课程分类');  return false;};
                if($('#classname').val()==""){ layer.alert('请选择课程名称');  return false;};
                if($('#question').val()==""){ layer.alert('请输入问题');  return false;};

                

                return true;

            }
            //监听 select start
            form.on('select(classtype)', function(data){
                console.log(data.elem); //得到select原始DOM对象
                console.log(data.value); //得到被选中的值
                console.log(data.othis); //得到美化后的DOM对象
                $.ajax({
                    url: "classinfo" ,
                    data: {'pid':data.value,'levels':'1'} ,
                    type: "post" ,
                    dataType:'json',
                    success:function(data){
                        var lists=data.data;
                        $("#classify").empty();
                        $("#classname").empty();
                        $("#classify").append("<option value=''>请选择</option>");
                        for(var i=0;i<lists.length;i++){
                            console.log(i+": "+lists[i]['title'])
                            $('#classify').append('<option value="'+lists[i]['id']+'">'+lists[i]['title']+'</option>');
                        }
                        form.render('select');
                        //layer.msg(data.msg, {icon: data.code},function(){$(".layui-laypage-btn").click();});
                    }
                })
            });
            form.on('select(classify)', function(data){
                console.log(data.elem); //得到select原始DOM对象
                console.log(data.value); //得到被选中的值
                console.log(data.othis); //得到美化后的DOM对象
                $.ajax({
                    url: "classinfo" ,
                    data: {'pid':data.value,'levels':'2'} ,
                    type: "post" ,
                    dataType:'json',
                    success:function(data){
                        var lists=data.data;
                        $("#classname").empty();
                        $("#classname").append("<option value=''>请选择</option>");
                        for(var i=0;i<lists.length;i++){
                            console.log(i+": "+lists[i]['title'])
                            $('#classname').append('<option value="'+lists[i]['id']+'">'+lists[i]['title']+'</option>');
                        }
                        form.render('select');
                        //layer.msg(data.msg, {icon: data.code},function(){$(".layui-laypage-btn").click();});
                    }
                })
            });
            //监听  select end

        })

</script>
</body>
</html>