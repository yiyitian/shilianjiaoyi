{include file="public/header" /}
<link rel="stylesheet" href="/public/index/css/zy.css" type="text/css">
<script type="text/javascript" src="/public/layui/layui.js"></script>
<link rel="stylesheet" href="/public/layui/css/layui.css" type="text/css">
<script type="text/javascript" src="/public/index/js/lCalendar.js"></script>
<link rel="stylesheet" href="/public/index/css/lCalendar.css" type="text/css">
<style>
    .zhuc_kluang{padding:0;}
    .zhuc_kluang a{width:100%;}
    .zhuc_kluang select{border:none;background:none;}
    #anq_tuic{color:#fff;}
</style>

<body style="height: 100%;background: #eaeaea;">
<!-- 头部 -->
<div class="toub_beij toub_beij_zhuy">
    <div class="fanhui_jt"><a href="personalCenter"><i class="fanh_jiant"><img src="/public/index/images/fanh_jiant_bai.png"></i><span>返回</span></a></div>
    <div class="mingc_tb">资料设置</div>
    <div class="sy_zaix"><a href="javascript:;"><span id="anq_tuic">保存</span></a></div>
</div>

<!-- 内容 -->

<div class="nei_r_btk">
    <form id="form">
           <div class="layui-upload" style="text-align:center">
            <div class="layui-upload-drag" id="test10">
                <p><img id="avatar" src="{$info.avatar|default='/all/shop/picture/member_1.png'}" style="width:30%;border-radius:20%" alt=""/></p>
            </div>
        </div>
        <ul>
            <li>
                <a href="#">
                    <h1>员工姓名</h1>
                    <div class="xiugai">
                        <h2><input type="text" name="username"  value="{$info.username|default=''}" style="text-align:right;"/></h2>
                    </div>
                </a>
            </li>
            <input type="hidden" name="avatar" value="{$info.avatar|default='/public/index/images/toux_mor.jpg'}" id="ava"/>
            <input type="hidden" name="id" value="{$info.id}"/>
            <li>
                <a href="#">
                    <h1>工号</h1>
                    <div class="xiugai">
                        <h2><input type="text" name="work_id"  value="{$info.work_id|default=''}" style="text-align:right;"/></h2>
                    </div>
                </a>
            </li>
            <li class="zhuc_kluang">
                <a href="#">
                    <h1>性别</h1>
                    <div class="xiugai" style="padding-top: 5px;">
                        <select name="sex"  style="font-size:12px;"  dir="rtl">
                            <option style="width:10px;"  value ="1" {if condition="$info['sex'] eq 1"} selected="selected" {/if}>男</option>
                            <option style="width:10px;"  value ="-1"  {if condition="$info['sex'] eq -1"} selected="selected" {/if}>女</option>
                        </select>
                    </div>
                </a>
            </li>
            <li>
                <a href="#">
                    <h1>手机号码</h1>
                    <div class="xiugai">
                        <h2><input type="text" name="phone" value="{$info.phone|default=''}" style="text-align:right;"/></h2>
                    </div>
                </a>
            </li>
            <li style="display: none;">
                <a href="#">
                    <h1>已学课程</h1>
                    <div class="xiugai">
                        <h2><input id="add" type="text" readonly required="required" placeholder="点击可编辑，未学可忽略"  value="" /></h2>
                        <input id="classid" name="classid" type="hidden" value="" />
                    </div>
                </a>
            </li>

            <li>
                <a href="#">
                    <h1>出生日期</h1>
                    <div class="xiugai">
                        <h2> <input id="demo1" type="text" readonly="" name="birthday" placeholder="请选择出生日期"  value="{$info.birthday|default=''}" style="text-align:right;" /></h2>
                    </div>
                </a>
            </li>
            <li>
                <a href="#">
                    <h1>入职日期</h1>
                    <div class="xiugai">
                        <h2> <input id="demo2" type="text" readonly="" name="start_time" placeholder="请选择入职日期"  value="{$info.start_time|default=''}" style="text-align:right;" /></h2>
                    </div>
                </a>
            </li>
            <li class="zhuc_kluang">
                <a href="#">
                    <h1>婚姻状况</h1>
                    <div class="xiugai" style="padding-top: 5px;">
                        <select name="marriage"  style="font-size:12px;"  dir="rtl">
                            <option style="width:10px;" value ="-1" {if condition="$info['marriage'] eq -1"} selected="selected" {/if} >未婚</option>
                            <option style="width:10px;"  value ="1" {if condition="$info['marriage'] eq 1"} selected="selected" {/if}>已婚</option>
                        </select>
                    </div>
                </a>
            </li>
            <li>
                <a href="#">
                    <h1>户籍所在地</h1>
                    <div class="xiugai">
                        <h2><input type="text" name="domicile" value="{$info.domicile|default=''}" style="text-align:right;"/></h2>
                    </div>
                </a>
            </li>
            <li>
                <a href="#">
                    <h1>毕业院校</h1>
                    <div class="xiugai">
                        <h2><input type="text" name="universit" value="{$info.universit|default=''}" style="text-align:right;"/></h2>
                    </div>
                </a>
            </li>
            <li>
                <a href="#">
                    <h1>最高学历</h1>
                    <div class="xiugai">
                        <h2><input type="text" name="education" value="{$info.education|default=''}" style="text-align:right;"/></h2>
                    </div>
                </a>
            </li>
            <li>
                <a href="#">
                    <h1>所学专业</h1>
                    <div class="xiugai">
                        <h2><input type="text" name="major" value="{$info.major|default=''}" style="text-align:right;"/></h2>
                    </div>
                </a>
            </li>
             <li>
                <a href="#">
                    <h1>地区</h1>
                    <div class="xiugai" style="padding-top: 20px;">
                        <select id="region" name="region" lay-filter="region">
                            <option></option>
                            {volist name="region" id="vo"}
                        
                            <option value="{$vo.id}" {if condition="$vo.id eq $info.region"}selected{/if}>{$vo.name}</option>
                        
                            {/volist}
                       </select>
                    </div>
                </a>
            </li>
            <li>
                <a href="#">
                    <h1>部门</h1>
                    <div class="xiugai" style="padding-top: 20px;">
                         <select id="department" name="department" lay-filter="department" placeholder="请选择部门">
               
                
                <option value="{$info.department}" > {$info.departments}</option>
                
            </select>
                    </div>
                </a>
            </li>
            <li>
                <a href="#">
                    <h1>所属岗位</h1>
                    <div class="xiugai" style="padding-top: 20px;">
                        <select id="station" name="station" lay-filter="station" placeholder="请选择岗位">
             
                <option value="{$info.station}" >{$info.stations}</option>
               
            </select>
                    </div>
                </a>
            </li>
            
            <li>
                <a href="#">
                    <h1>所属项目</h1>
                    <div class="xiugai" style="padding-top: 20px;">
                        <select id="projectname" name="projectname" lay-filter="projectname" placeholder="请选择岗位">
                               <option value="{$info.projectname}" >{$info.projectnames}</option>


            </select>
                    </div>
                </a>
            </li>

        </ul>
    </form>
</div>



<script>
    layui.use('upload', function() {
        var $ = layui.jquery
            , upload = layui.upload;
        //添加课程start
        var clientWidth=$(window).width();
        var clientHeight=$(window).height();
        $(document).on('click','#add',function(){
            var index = layer.open({
                type: 2,
                shade: [0.1],
                title:"添加/编辑",
                area: [clientWidth*.7+'px', clientHeight*.6+'px'],
                maxmin: true,
                content: '/index/login/class_add?id=1',
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
                        url:"/index/login/class_add",
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
        //添加课程end
        upload.render({
            elem: '#test10'
            ,url: 'uploads'
            ,done: function(res){
                layer.msg('上传成功');
                document.getElementById('avatar').src = res.src;
                document.getElementById('ava').value = res.src;
            }
        });
        $("#anq_tuic").click(function()
        {
            var i = $("form").serialize();
            $.ajax({
                url: "setUser" ,
                data: i ,
                type: "post" ,
                dataType:'json',
                success:function(data){
                    if(data.code == 2)
                    {
                        alert(data.msg);
                    }else{
                        layer.msg(data.msg,{time:1000},function () {
                        window.location.replace('/index/User/personalCenter');
                    });
                    }
                    

                }
            })
            return false;
        })
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
                url: "/index/login/getCate",
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
                url: "/index/login/getProject",
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
        
    });
   
</script>
</body>
</html>
