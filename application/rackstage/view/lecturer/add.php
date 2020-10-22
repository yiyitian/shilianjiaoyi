<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>layui</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="/public/layui/css/layui.css"  media="all">
    <link rel="stylesheet" href="/public/layui/formSelects-v4.css"  media="all">
    <!-- 注意：如果你直接复制所有代码到本地，上述css路径需要改成你本地的 -->
</head>
<style>
    .layui-upload-img{width: 92px;  height: 92px;  margin: 0 10px 10px 0; }
    .search
    {
        left: 0;
        position: relative;
    }
    #auto_div
    {
        display: none;
        width: 300px;
        border: 1px #74c0f9 solid;
        background: #FFF;
        position: absolute;
        top: 40px;
        left: 0;
        color: #323232;
        z-index:999;
    }

</style>
<body>


<form class="layui-form" action="" id="formid"  style="margin-top: 20px;">
	{notempty name="list.users_id"}
		<input type="hidden" id="users_id" name="users_id" value="{$list.users_id}">
    <div class="layui-form-item">
        <label class="layui-form-label">讲师姓名</label>
        <div class="layui-input-inline">
            <input class="layui-input" type="text"  value="{$list.users_name|default=''}" readonly style="color:#ccc;">
        </div>
    </div>
			{else /}
		<div class="layui-form-item">
			<label class="layui-form-label">选择员工</label>
			<div class="layui-input-inline">
                <div class="search">
                    <input type="text" id="search_text" name="users_id" class="layui-input" placeholder="请务必从列表中选择员工"/>
                    <div id="auto_div">
                    </div>
                </div>
			</div>
            <div class="layui-form-mid layui-word-aux">若列表中没有，请先添加员工</div>
		</div>
	{/notempty}
    <input type="hidden" name="id" value="{$list.id|default=''}">
    <div class="layui-form-item">
        <label class="layui-form-label">讲师类别</label>
        <div class="layui-input-inline">
            <select id="types" name="types" placeholder="请选择讲师类别">
                <option></option>
                {notempty name="list.types"}
                <option value="销售讲师" {if condition="$list.types eq '销售讲师'"}selected{/if}>销售讲师</option>
                <option value="策划讲师" {if condition="$list.types eq '策划讲师'"}selected{/if}>策划讲师</option>
                <option value="管理课讲师" {if condition="$list.types eq '管理课讲师'"}selected{/if}>管理课讲师</option>
                {else /}
                <option value="销售讲师">销售讲师</option>
                <option value="策划讲师">策划讲师</option>
                <option value="管理课讲师">管理课讲师</option>
                {/notempty}
            </select>
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">讲师级别</label>
        <div class="layui-input-inline">
            <select id="levels" name="levels" placeholder="请选择讲师级别">
                <option></option>
                {notempty name="list.levels"}
                <option value="金牌" {if condition="$list.levels eq '金牌'"}selected{/if}>金牌</option>
                <option value="银牌" {if condition="$list.levels eq '银牌'"}selected{/if}>银牌</option>
                <option value="普通" {if condition="$list.levels eq '普通'"}selected{/if}>普通</option>
                {else /}
                <option value="金牌">金牌</option>
                <option value="银牌">银牌</option>
                <option value="普通">普通</option>
                {/notempty}
            </select>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">授课时间</label>
        <div class="layui-input-inline">
            <input type="text"  id="classtime"  name="classtime" value="{$list.classtime|default=''}"  placeholder="请输入授课时间" class="layui-input">
        </div>
        <div class="layui-form-mid layui-word-aux">小时/h</div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">授课次数</label>
        <div class="layui-input-inline">
            <input type="text" id="classnum" name="classnum" value="{$list.classnum|default=''}"  placeholder="请输入授课次数" class="layui-input">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">已授课程</label>
        <div class="layui-input-inline">
            <select name="classid" xm-select="select6_5" xm-select-skin="danger"  xm-select-search="" xm-select-show-count="1">
                {volist name="classname_pid" id="vo_pid"}
                <optgroup label="{$vo_pid.title}">
                    {volist name="classname" id="vo"}
                    {notempty name="list.classid"}
                    {if condition="$vo.pid eq $vo_pid.id"}
                    <option value="{$vo.id}" {range name="vo.id" value="$list.classid|default='0'" type="in"}selected{/range}>{$vo.title}</option>
                    {/if}
                    {/volist}
                </optgroup>
                {/volist}
            </select>
        </div>
    </div>
    <div class="layui-form-item layui-form-text">
        <label class="layui-form-label">备注</label>
        <div class="layui-input-block">
            <textarea placeholder="请输入内容" class="layui-textarea" name="mark" style="width:80%">{$list.mark|default=''}</textarea>
        </div>
    </div>
</form>
<script src="/public/layui/layui.js" charset="utf-8"></script>
<script src="/public/layui/formSelects-v4.js" charset="utf-8"></script>
<!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->
<script>
    //全局定义一次, 加载formSelects
    layui.config({
        base: './' //此处路径请自行处理, 可以使用绝对路径
    }).extend({
        formSelects: 'formSelects-v4'
    });


        var callbackdata;
        layui.use(['layer', 'form','element','jquery'], function(){
            var layer = layui.layer
                ,$=layui.jquery
                ,form = layui.form;
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
                if($('#search_text').val()==""){ layer.alert($('#search_text').attr('placeholder'));  return false;};
                {empty name="list.users_id"}
                if($('#search_text').val().indexOf("--") == '-1'){ layer.alert($('#search_text').attr('placeholder'));  return false;};
                {/empty}
                if($('#types').val()==""){ layer.alert($('#types').attr('placeholder'));  return false;};
                if($('#levels').val()==""){ layer.alert($('#levels').attr('placeholder'));  return false;};
                if($('#classtime').val()==""){ layer.alert($('#classtime').attr('placeholder'));  return false;};
                if($('#classnum').val()==""){ layer.alert($('#classnum').attr('placeholder'));  return false;};
                

                return true;

            }




            //测试用的数据，这里可以用AJAX获取服务器数据
            var test_list = [
                {volist name="users" id="vo"}
                "{$vo.username}--{$vo.work_id}",
                {/volist}
                ];
            var old_value = "";
            var highlightindex = -1;   //高亮
            //自动完成
            function AutoComplete(auto, search, mylist) {
                if ($("#" + search).val() != old_value || old_value == "") {
                    var autoNode = $("#" + auto);   //缓存对象（弹出框）
                    var carlist = new Array();
                    var n = 0;
                    old_value = $("#" + search).val();
                    for (i in mylist) {
                        if (mylist[i].indexOf(old_value) >= 0) {
                            carlist[n++] = mylist[i];
                        }
                    }
                    if (carlist.length == 0) {
                        autoNode.hide();
                        return;
                    }
                    autoNode.empty();  //清空上次的记录
                    for (i in carlist) {
                        var wordNode = carlist[i];   //弹出框里的每一条内容
                        var newDivNode = $("<div>").attr("id", i);    //设置每个节点的id值
                        newDivNode.attr("style", "font:14px/25px arial;height:25px;padding:0 8px;cursor: pointer;");
                        newDivNode.html(wordNode).appendTo(autoNode);  //追加到弹出框
                        //鼠标移入高亮，移开不高亮
                        newDivNode.mouseover(function () {
                            if (highlightindex != -1) {        //原来高亮的节点要取消高亮（是-1就不需要了）
                                autoNode.children("div").eq(highlightindex).css("background-color", "white");
                            }
                            //记录新的高亮节点索引
                            highlightindex = $(this).attr("id");
                            $(this).css("background-color", "#ebebeb");
                        });
                        newDivNode.mouseout(function () {
                            $(this).css("background-color", "white");
                        });
                        //鼠标点击文字上屏
                        newDivNode.click(function () {
                            //取出高亮节点的文本内容
                            var comText = autoNode.hide().children("div").eq(highlightindex).text();
                            highlightindex = -1;
                            //文本框中的内容变成高亮节点的内容
                            $("#" + search).val(comText);
                        })
                        if (carlist.length > 0) {    //如果返回值有内容就显示出来
                            autoNode.show();
                        } else {               //服务器端无内容返回 那么隐藏弹出框
                            autoNode.hide();
                            //弹出框隐藏的同时，高亮节点索引值也变成-1
                            highlightindex = -1;
                        }
                    }
                }
                //点击页面隐藏自动补全提示框
                document.onclick = function (e) {
                    var e = e ? e : window.event;
                    var tar = e.srcElement || e.target;
                    if (tar.id != search) {
                        if ($("#" + auto).is(":visible")) {
                            $("#" + auto).css("display", "none")
                        }
                    }
                }
            }
            $(function () {
                old_value = $("#search_text").val();
                $("#search_text").focus(function () {
                    if ($("#search_text").val() == "") {
                        AutoComplete("auto_div", "search_text", test_list);
                    }
                });
                $("#search_text").keyup(function () {
                    AutoComplete("auto_div", "search_text", test_list);
                });
            });

        })
</script>
</body>
</html>