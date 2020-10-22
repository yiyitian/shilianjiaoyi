<!doctype html>
<html>
<head>
    <meta name="format-detection" content="telephone=no" />
    <meta charset="utf-8">
    <meta content="山东世联交易业务运营平台" http-equiv="keywords">
    <meta name="description" content="山东世联交易业务运营平台">
    <meta name="viewport" content="width=device-width,user-scalable=no, initial-scale=1">
    <title>山东世联交易业务运营平台</title>
    <link rel="stylesheet" href="/public/index/css/index.css" type="text/css">
    <link rel="stylesheet" href="/public/index/css/zy.css" type="text/css">
    <link rel="stylesheet" href="/public/index/css/swiper.min.css" type="text/css">
    <script type="text/javascript" src="/public/index/js/swiper.min.js"></script>
    <script type="text/javascript" src="/public/index/js/jquery-1.4.4.min.js"></script>
    <script type="text/javascript" src="/public/index/layer_mobile/layer.js"></script>
    <script type="text/javascript" src="/public/index/js/lCalendar.js"></script>
    <link rel="stylesheet" href="/public/index/css/lCalendar.css" type="text/css">
    <style>
        .zhuc_kluang select{width:70%;}
        .zhuc_kluang input{width:66%;}
    </style>
</head>
<body style="height: 100%;" >
<!-- 头部 -->
<div class="toub_beij">
    <div class="fanhui_jt"><a href="http://app.sz-senox.com/api/login/login"><i class="fanh_jiant"><img src="/public/index/images/fanh_jiant_hei.png"></i><span>返回</span></a></div>
    <div class="mingc_tb">注册</div>
    <div class="sy_zaix"><a href="http://app.sz-senox.com/api/login/login">有账号<span>登录</span></a></div>
</div>
<script type="text/javascript">
    //滑动头部透明（针对首页头部用）
    window.onscroll=function(){

        var autoheight=document.body.scrollTop||document.documentElement.scrollTop;
        if(autoheight>20){
            $(".toub_beij").css("position" ,"fixed")
        }else{
            $(".toub_beij").css("position" ,"relative")
        }
    }
</script>
<!-- 内容 -->
<div class="zhuc_img">
    <img src="/public/index/images/zhuc_img.jpg">
</div>

<div class="dengl_nr_k">


    <form id="formid" action="register" method="post">

        <div class="zhuc_kluang">
            <p><em></em>工号：</p>
            <input type="text" name="work_id" id="work_id" placeholder="请输入您的工号" autocomplete="off">
        </div>
        <div class="zhuc_kluang">
            <p><em>*</em>员工姓名：</p>
            <input type="text" name="username" id='username' required="required" placeholder="重要：输入真实姓名,不可更改" autocomplete="off">
        </div>
        <div class="zhuc_kluang">
            <p><em>*</em>设置密码：</p>
            <input type="password" name="pass" id="pass" required="required" placeholder="请设置您的登录密码" autocomplete="off">
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label"></label>
            <div class="layui-input-inline" style="width:200px;">

            </div>
            <div class="layui-input-inline" style="width:200px;">

            </div>
            <div class="layui-input-inline" style="width:200px;">

            </div>
        </div>


        <div class="zhuc_kluang">
            <p><em>*</em>地区：</p>
            <select id="region" name="region" lay-filter="region">
                <option></option>
                {volist name="region" id="vo"}
                {notempty name="list.region"}
                <option value="{$vo.id}" {if condition="$vo.id eq $list.region"}selected{/if}>{$vo.name}</option>
                {else /}
                <option value="{$vo.id}">{$vo.name}</option>
                {/notempty}
                {/volist}
            </select>
        </div>
        <div class="zhuc_kluang">
            <p><em>*</em>部门：</p>
            <select id="department" name="department" lay-filter="department" placeholder="请选择部门">
                <option></option>
                {notempty name="list.department"}
                <option value="{$list.department}" selected>{$list.department_name}</option>
                {/notempty}
            </select>
        </div>
        <div class="zhuc_kluang">
            <p><em>*</em>所属岗位：</p>
            <select id="station" name="station" lay-filter="station" placeholder="请选择岗位">
                <option></option>
                {notempty name="list.station"}
                <option value="{$list.station}" selected>{$list.station_name}</option>
                {/notempty}
            </select>
        </div>
        <div class="zhuc_kluang">
            <p><em>*</em>所属项目：</p>
            <select id="projectname" name="projectname" lay-filter="projectname" placeholder="请选择岗位">
                <option></option>

            </select>
        </div>
        <div class="zhuc_kluang" style="display:black;">
            <p><em></em>已学课程：</p>
            <input id="add" type="text" readonly required="required" placeholder="点击可编辑，未学可忽略"  value="" />
            <input id="classid" name="classid" type="hidden" value="" />
        </div>
        <div class="zhuc_kluang">
            <p><em>*</em>性别：</p>
            <select name="sex"  style="font-size:12px;" >
                <option style="width:10px;"  value ="1" selected="selected" >男</option>
                <option style="width:10px;"  value ="-1">女</option>
            </select>
        </div>
        <div class="zhuc_kluang">
            <p><em>*</em>出生日期：</p>
            <input id="demo1" type="text" readonly="" required="required" name="birthday" placeholder="请选择出生日期"  value="" />
        </div>
        <div class="zhuc_kluang">
            <p><em>*</em>入职日期：</p>
            <input id="demo2" type="text" readonly="" required="required" name="start_time" placeholder="请选择入职日期"  value="" />
        </div>
        <div class="zhuc_kluang">
            <p><em>*</em>手机号码：</p>
            <input type="text" name="phone" id="phone" required="required" placeholder="请设置您的手机号码" autocomplete="off">
        </div>

        <div class="zhuc_kluang">
            <p><em>*</em>婚姻状况：</p>
            <select name="marriage"  style="font-size:12px;" >
                <option style="width:10px;" value ="-1" selected="selected">未婚</option>
                <option style="width:10px;"  value ="1" >已婚</option>
            </select>
        </div>
        <div class="zhuc_kluang">
            <p><em>*</em>籍贯：</p>
            <input type="text" id="domicile" name="domicile" value='' placeholder="请设置您的籍贯" required="required" autocomplete="off"/>
        </div>
        <div class="zhuc_kluang">
            <p><em>*</em>毕业院校：</p>
            <input type="text" id="universit" name="universit" value="" placeholder="请设置您的毕业学校" required="required" autocomplete="off"/>
        </div>
        <div class="zhuc_kluang">
            <p><em>*</em>最高学历：</p>
            <input type="text" name="education" id="education" required="required" autocomplete="off" placeholder="请设置您的最高学历">
        </div>
        <div class="zhuc_kluang">
            <p><em>*</em>所学专业：</p>
            <input type="text" name="major" id="major" required="required" autocomplete="off" placeholder="请设置您的所学专业">
        </div>




        <div class="zhuzhong_tx" id="xuanz" >
            <input id="button" type="button" class="dengl_anniu dengl_anniu_zcy" value="注 册">
        </div>
    </form>



</div>

</body>
</html>
<script src="/public/layui/layui.js" charset="utf-8"></script>
<script type="text/javascript">
    layui.use(['upload','laydate','table','layer', 'form','element','jquery'], function() {
        var $ = layui.jquery
            , upload = layui.upload
            , table = layui.table
            , layer = layui.layer
            , form = layui.form
            , laydate = layui.laydate;
//所属岗位开始
        var clientWidth=$(window).width();
        var clientHeight=$(window).height();
        $(document).on('change','#region',function(){
            console.log($(this).val());
            $.ajax({
                url: "getCate",
                data: {'pid': $(this).val()},
                type: "get",
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    framework = data.framework
                    $("#department").empty();
                    $("#department").append("<option value=''>请选择</option>");//新增
                    for (var i = 0; i < framework.length; i++) {
                        $("#department").append("<option value='" + framework[i].id + "'>" + framework[i].name + "</option>");//新增
                    }

                    post = data.post
                    $("#station").empty();
                    $("#station").append("<option value=''>请选择</option>");//新增
                    for (var i = 0; i < post.length; i++) {
                        $("#station").append("<option value='" + post[i].id + "'>" + post[i].posts + "</option>");//新增
                    }
                    form.render('select');
                }
            })
        });
        $(document).on('change','#department',function(){
            console.log($(this).val());
            $.ajax({
                url: "getProject",
                data: {'pid': $(this).val()},
                type: "get",
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    $("#projectname").empty();
                    $("#projectname").append("<option value=''>请选择</option>");//新增
                    if(data==''){
                        layer.msg('暂无项目', {icon:0});
                        $("#projectname").append("<option value='0'>暂无项目</option>");
                        return false;
                    }
                    for (var i = 0; i < data.length; i++) {
                        $("#projectname").append("<option value='" + data[i].id + "'>" + data[i].name + "</option>");//新增
                    }
                    form.render('select');
                }
            })
        });
        $(document).on('click','#add',function(){
            var index = layer.open({
                type: 2,
                shade: [0.1],
                title:"添加/编辑",
                area: [clientWidth*.7+'px', clientHeight*.6+'px'],
                maxmin: true,
                content: 'class_add',
                btn: ['保存','关闭'],
                zIndex: layer.zIndex, //重点1
                yes: function(index){
                    var row= window["layui-layer-iframe" + index].callbackdata();
                    if(!$.trim(row)){
                        return false;
                    }
                    console.log(row);
                    //layer.closeAll();
                    $.ajax({
                        url:"class_add",
                        type:"post",
                        dataType: "json",
                        cache: false,
                        data:row,
                        contentType: "application/x-www-form-urlencoded; charset=utf-8",
                        success:function(data){
                            console.log(data);
                            layer.closeAll();
                            if(data.code==1){
                                $('#classid').val(data.msg);
                            }else{
                                layer.msg(data.msg, {icon:0});
                            }
                        }
                    });
                },
                cancel: function(){
                },
                end: function(){ //此处用于演示
                }
            });
            layer.full(index);
        });

    });
    $('#button').click(function()
    {
        var username = $('#username').val()
            ,pass = $('#pass').val()
            ,work_id = $('#work_id').val()
            ,demo1 = $('#demo1').val()
            ,phone = $('#phone').val()
            ,domicile = $('#domicile').val()
            ,universit = $('#universit').val()
            ,education = $('#education').val()
            ,major = $('#major').val()
            ,region = $('#region').val()
            ,department = $('#department').val()
            ,station = $('#station').val()
            ,projectname = $('#projectname').val()


       
           var reg = new RegExp("[\\u4E00-\\u9FFF]+","g");
            if (reg.test(work_id)){
                alert( "工号不能包含汉字" );
                return false ;
            }
        
		// 验证用户名是否含有特殊字符
		function check_other_char(str)
		{
			var arr = ["&", "\\", "/", "*", ">", "<", "@", "!", " "];
			for (var i = 0; i < arr.length; i++)
			{
				for (var j = 0; j < str.length; j++)
				{
					if (arr[i] == str.charAt(j))
					{
						return true;
					}
				}
			}   
			return false;
		}
		if (check_other_char(username))
    {
        $('#username').focus();
		alert('用户名不能包含特殊字符或空格');
		return false;
    }


        var regs = /[A-Za-z]+/;
        if (regs.test(username))
        {
            alert('用户名不能包含字母');
        }
        var date =$("#formid").serialize();
        if(username==''||username.length<2){
            $('#username').focus();
            alert('请填写真实姓名,且不少2个字');
            return false;
        }
		if(username=='admin'){
			$('#username').focus();
			alert('请填写真是姓名');
			return false;
		}
        if(''==pass||pass.length<6){
            $('#pass').focus();
            alert('密码不能为空,且长度不小于6位');
            return false;
        }
        if(''==region){
            $('#region').focus();
            alert('地区不能为空');
            return false;
        }
        if(''==department){
            $('#department').focus();
            alert('部门不能为空');
            return false;
        }
        if(''==station){
            $('#station').focus();
            alert('岗位不能为空');
            return false;
        }
        if(''==projectname){
            $('#projectname').focus();
            alert('项目不能为空');
            return false;
        }
        if(''==demo1){
            $('#demo1').focus();
            alert('生日不能为空');
            return false;
        }
        if(''==phone||!/^0?1[3|4|5|6|7|8|9][0-9]\d{8}$/.test(phone)){
            $('#phone').focus();
            alert('请输入正确手机号');
            return false;
        }

        if(''==domicile){
            $('#domicile').focus();
            alert('籍贯不能为空');
            return false;
        }
        if(''==universit){
            $('#universit').focus();
            alert('毕业学院不能为空');
            return false;
        }
        if(''==education){
            $('#education').focus();
            alert('学历不能为空');
            return false;
        }
        if(''==major){
            $('#major').focus();
            alert('所学专业不能为空');
            return false;
        }

        console.log(date);

            $.ajax({
                url: "register" ,
                data: date ,
                type: "post" ,
                dataType:'json',
                success:function(data){
                    console.log(data);
                    alert(data.msg);
                    if(data.code==1)
                    {
                        location.href="/index/User/personalCenter";
                    }
                }
            });
        // $.ajax({
        //     url: "/index/Login/register" ,
        //     data: date ,
        //     type: "post" ,
        //     dataType:'json',
        //     success:function(data){
        //         console.log(data);
        //
        //     }
        // })



    })
    var calendar = new lCalendar();
    calendar.init({
        'trigger': '#demo1',
        'type': 'date'
    });
    var calendar2 = new lCalendar();
    calendar2.init({
        'trigger': '#demo2',
        'type': 'date'
    });

</script>
