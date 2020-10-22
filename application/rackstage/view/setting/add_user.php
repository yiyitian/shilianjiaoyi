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


<form class="layui-form" action="" id="formid" style="margin-top: 20px;">
	{empty name="list"}
    <div class="layui-form-item">
        <label class="layui-form-label">用户名</label>
        <div class="layui-input-inline">
            <input type="text" id="user_name" name="user[user_name]" value="{$list.user_name|default=''}" placeholder="请尽量使用员工的真实姓名,不可更改"  autocomplete="off" class="layui-input">
        </div>
        <div class="layui-inline layui-word-aux">
            真实姓名，输入后不可更改
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">登录密码</label>
        <div class="layui-input-inline">
            <input type="password" id="pwd" name="user[pwd]" lay-verify="required" value="{$list.pwd|default=''}" placeholder="请输入用户密码" autocomplete="off" class="layui-input">
        </div>
    </div>
	{else /}
		<input type="hidden" id="id" name="user[id]" value="{$list.id|default=''}" />
	{/empty}
    
	
    <div class="layui-form-item">
        <label class="layui-form-label">角色权限</label>
        <div class="layui-input-inline">
            <select name="user[role]" id="role" lay-filter="role">
                <option value=""></option>
                {volist name="role" id="vo"}
                    <option value="{$vo.id}" {if condition="isset($list)&&($list['role']==$vo['id'])"} selected {/if}>{$vo.role_name}</option>
                {/volist}
            </select>
        </div>
        <input type="hidden" name="department" value="" id="department"/>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">部门</label>
        <div class="layui-input-block">
            <div id="xtree3" class="xtree_contianer " style="padding-left:20px;"></div>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">选择员工</label>
        <div class="layui-input-inline">
            <div class="search">
                {notempty name='list.username'}
                <input type="text" id="search_text" name="users_id" class="layui-input" value="{$list.username}--{$list.work_id}" readonly placeholder="请务必从列表中选择员工"/>
                {else /}
                <input type="text" id="search_text" name="users_id" class="layui-input" value="" placeholder="请务必从列表中选择员工"/>
                {/notempty}
                <div id="auto_div">

                </div>
            </div>
        </div>
        <div class="layui-form-mid layui-word-aux">若列表中没有，请先添加员工，选择后不可更改</div>
    </div>

    <div class="layui-form-item layui-form-text">
        <label class="layui-form-label">备注</label>
        <div class="layui-input-block">
            <textarea placeholder="请输入备注" class="layui-textarea" name="user[mark]" style="width:80%">{$list.mark|default=''}</textarea>
        </div>
    </div>

</form>
<script src="/public/layui/layui.js" charset="utf-8"></script>
<!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->
<script src="/public/layui/layui-xtree.js" charset="utf-8"></script>
<!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->
<script>
    //全局定义一次, 加载formSelects

    var callbackdata;
    layui.use(['layer', 'form','element','jquery','laydate'], function(){
        var layer = layui.layer
            ,$=layui.jquery
            ,form = layui.form
			,laydate=layui.laydate
		laydate.render({
			elem:"#birthday",
		})
		laydate.render({
			elem:"#start_time",
		})

        var xtree3 = new layuiXtree({
            elem: 'xtree3'
            , form: form
            , data: 'getDepartment?id='+{$id}
            , isopen: true
            , ckall: true
            , ckallback: function () { } //全选框状态改变后执行的回调函数
            , icon: {
                open: "&#xe7a0;"
                , close: "&#xe622;"
                , end: "&#xe621;"
            }
            , color: {
                open: "#EE9A00"
                , close: "#EEC591"
                , end: "#828282"
            }
            , click: function (data) {
                console.log(data.elem);

            }
        });
		//联动选择地区和部门
        form.on('select(province)', function(data){
            $.ajax({
                url: "/rackstage/Personnel/get_city_area" ,
                data: {'pid':data.value} ,
                type: "get" ,
                dataType:'json',
                success:function(data){
                    $("#city").empty();
                    $("#city").append("<option value=''>请选择</option>");//新增
                    for(var i = 0; i < data.length; i++){
                        $("#city").append("<option value='"+data[i].codes+"'>"+data[i].name_se+"</option>");//新增
                    }
                    form.render('select');
                }
            })
        })
        form.on('select(city)', function(data){
            $.ajax({
                url: "/rackstage/Personnel/get_city_area" ,
                data: {'pid':data.value} ,
                type: "get" ,
                dataType:'json',
                success:function(data){
					//console.log(data);
                    $("#area").empty();
                    $("#area").append("<option value=''>请选择</option>");//新增
                    for(var i = 0; i < data.length; i++){
                        $("#area").append("<option value='"+data[i].codes+"'>"+data[i].name_se+"</option>");//新增
                    }
                   
                    form.render('select');
                }
            })
        })
		//所属岗位开始
		form.on('select(region)', function(data){
            $.ajax({
                url: "/rackstage/Personnel/getCate" ,
                data: {'pid':data.value} ,
                type: "get" ,
                dataType:'json',
                success:function(data){
					console.log(data);
					framework=data.framework
                    $("#department").empty();
                    $("#department").append("<option value=''>请选择</option>");//新增
                    for(var i = 0; i < framework.length; i++){
                        $("#department").append("<option value='"+framework[i].id+"'>"+framework[i].name+"</option>");//新增
                    }
					
					post=data.post
					$("#station").empty();
                    $("#station").append("<option value=''>请选择</option>");//新增
                    for(var i = 0; i < post.length; i++){
                        $("#station").append("<option value='"+post[i].id+"'>"+post[i].posts+"</option>");//新增
                    }
                    form.render('select');
                }
            })
        })
		
        //返回值
        callbackdata=function () {
            if(!verifycontent()){
                false;
            }else {
                var _allck = xtree3.GetAllCheckBox();
                var arr = new Array();
                var arrIndex = 0;
                for (var i = 0; i < _allck.length; i++) {
                    if (_allck[i].checked) {
                        arr[arrIndex] = _allck[i].value;

                        arrIndex++;
                    }
                }
                $('#department').val(arr.join(","));
                var data =$("#formid").serialize();
                return data;
            }
        }
        //自定义验证规则
        function verifycontent() {
            var pPattern =/^[\S]{6,12}$/;
            if($('#id').val==''){
                if($("#user_name").val()==''||$("#user_name").val().length < 2)
                {
                    layer.alert( '用户名不能为空,且不少于2个字');
                    return false;
                }
                if(!pPattern.test($("#pwd").val()))
                {
                    layer.alert( '密码必须6到12位，且不能出现空格');
                    return false;
                }
            }
            if($("#role").val()=='')
            {
                layer.alert( '角色权限不能为空');
                return false;
            }
            if($('#search_text').val() == '')
            {
                layer.alert( '关联员工不能为空');
                return false;
            }

            return true;

        }
        //测试用的数据，这里可以用AJAX获取服务器数据
        var test_list = [{empty name='list.username'}{volist name="users" id="vo"}"{$vo.username}--{$vo.work_id}", {/volist}{/empty}];
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