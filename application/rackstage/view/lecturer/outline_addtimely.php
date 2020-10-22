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
        <script type="text/javascript" charset="utf-8" src="/public/uedit/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="/public/uedit/ueditor.all.min.js"> </script>
    <!-- 注意：如果你直接复制所有代码到本地，上述css路径需要改成你本地的 -->
</head>
<style>



    #classtable + div{margin-left:50px;}
    #userstable + div{margin-left:50px;}
    #station_table + div{margin-left:50px;}
    .layui-table td, .layui-table th{text-align: center;}
</style>
<body>


<form class="layui-form" action="" id="formid"  style="margin-top: 20px;">
	<input type="hidden" name="id" value="{$list.id|default=''}" >
<!--	<input type="hidden" name="department" value="{$list.department|default=''}" >-->
<!--	<input type="hidden" name="station" value="{$list.station|default=''}" >-->

    <input type="hidden" name="times" value="{$times}" >
    <input type="hidden" name="types" value="2"/>
	{notempty name="list"}
	<div class="layui-form-item">
        <label class="layui-form-label">实际上课人数</label>
        <div class="layui-input-inline">
            <input type="text" name='real_number' value="{$list.real_number|default='0'}" class="layui-input">
        </div>
    </div>
              {/notempty}
    <div class="layui-form-item">
        <label class="layui-form-label">地区标签</label>
        <div class="layui-input-inline">
            <select name="area" id="area" lay-filter="area" placeholder="请选择地区标签">
                <option value="{$list.area|default=''}">{$list.area|default=''}</option>
                <option value="济南">济南</option>
                <option value="潍坊">潍坊</option>
                <option value="临沂">临沂</option>
                <option value="青岛">青岛</option>
                <option value="烟台">烟台</option>
                <option value="集团">集团</option>
            </select>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">班主任</label>
        <div class="layui-input-inline">
            {empty name="list"}
            <input type="text" value="{$_SESSION.think.user_name}" class="layui-input" style="color:#9c9c9c;" readonly>
            {else /}
            <input type="text" value="{$list.username|default=''}" class="layui-input" style="color:#9c9c9c;" readonly>
            {/empty}
        </div>
    </div>
        <img id="qrcode" style="position: absolute;right: 20px;top: 50px;display: none;" src="{$list.qrcode|default=''}">

    <!--<div class="layui-form-item">
        <label class="layui-form-label">问卷调查题目</label>
        <div class="layui-input-inline">
            <select name="question" id="question" lay-filter="question" placeholder="选择问卷调查题目">
                <option></option>
                {volist name='question' id='vo'}
                    {notempty name="list.question"}
                        <option value="{$vo.id}"{if condition="$vo.id eq $list.question"} selected{/if}>{$vo.title}</option>
                    {else /}
                        <option value="{$vo.id}">{$vo.title}</option>
                    {/notempty}
                {/volist}

            </select>
        </div>
    </div>-->
    <input type="hidden" name="is_outline" value="线上课程" class="layui-input" style="color:#9c9c9c;" readonly>

	<!--线上选项 start-->

	<div class="layui-form-item online">
        <label class="layui-form-label">视频地址</label>
        <div class="layui-input-inline">
            <input type="text" id="video_url" name="video_url" lay-verify="required" value="{$list.video_url|default='/public/shipin/'}" placeholder="请勿忽略“http://”" autocomplete="off" class="layui-input">
        </div>
    </div>
	<!--线上选项 end-->


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
    <!--线上选项 end-->
    <div class="layui-form-item outline online">
        <label class="layui-form-label">开课日期</label>
        <div class="layui-input-inline" style="width:150px;">
            <input style="" type="text" id="startdate" name="startdate" lay-verify="required" value="{$list.startdate|default=''}" placeholder="请选择开课日期" autocomplete="off" class="layui-input">
        </div>
        <div class="layui-form-mid">~</div>
        <div class="layui-input-inline" style="width:150px;">
           <input type="text" id="enddate" name="enddate" lay-verify="required" value="{$list.enddate|default=''}" placeholder="请选择结束日期" autocomplete="off" class="layui-input">
        </div>
    </div>
<div id="choosepost">
    <div class="layui-form-item">
        <label class="layui-form-label">选择部门</label>
        <div class="layui-input-inline">
            <select name="department" xm-select="select7_0" xm-select-skin="danger" xm-select-search="" xm-select-show-count="1" >
                {volist name="framework_pid" id="vo_pid"}
                <optgroup label="{$vo_pid.name}">
                    {volist name="framework" id="vo"}
                    {if condition="$vo.pid eq $vo_pid.id"}
                    <option value="{$vo.id}" {range name="vo.id" value="$list.department|default='0'" type="in"}selected{/range}>{$vo.name}</option>
                    {/if}
                    {/volist}
                </optgroup>
                {/volist}

            </select>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">选择岗位</label>
        <div class="layui-input-inline" >
            <select id="station" name="station" lay-filter="station" xm-select="select7_2" xm-select-skin="danger" xm-select-search=""  xm-select-show-count="1">
                {volist name="posts_pid" id="vo_pid"}
                <optgroup label="{$vo_pid.posts}">
                    {volist name="posts" id="vo"}
                    {if condition="$vo.pid eq $vo_pid.id"}
                    <option value="{$vo.id}" {range name="vo.id" value="$list.station|default='0'" type="in"}selected{/range}>{$vo.posts}</option>
                    {/if}
                    {/volist}
                </optgroup>
                {/volist}

            </select>
        </div>
    </div>
</div>

    <div class="layui-form-item" style="">
        <label class="layui-form-label"></label>
        <div class="layui-input-block">
            <span class="layui-btn layui-btn-danger " id="getstation">确认筛选</span>
            <span class="layui-btn layui-btn-normal " id="resetnotice">清空筛选</span>
        </div>
    </div>
   
    <div class="layui-form-item layui-form-text">
        <label class="layui-form-label">备注</label>
        <div class="layui-input-block">
            <textarea placeholder="请输入内容"   name="mark" style='width:1250px;height:300px;'>{$list.mark|default=''}</textarea>
        </div>
    </div>
     <div class="layui-form-item layui-form-text">
        <label class="layui-form-label">内容</label>
        <div class="layui-input-block">
            <textarea placeholder="请输入内容"  id='editor' name="remark" style='width:1250px;margin-left:30px;height:200px;'>{$list.remark|default=''}</textarea>
        </div>
    </div>
    <!--<img id="qrcode" style="position: absolute;right: 20px;top: 50px;display: none;" src="{$list.qrcode|default=''}">-->
</form>
<fieldset class="layui-elem-field layui-field-title outline online" style="margin-top: 30px;">
    <legend>通知人员</legend>
</fieldset>
<div class="outline online">
    <table class="layui-table outline online"  lay-filter="userstable" id="userstable" align="center"></table>
</div>

{notempty name="browse"}
<fieldset class="layui-elem-field layui-field-title" style="margin-top: 30px;">
    <legend>问卷调查</legend>
</fieldset>
<div class="layui-form addclass" id="answer">
    {notempty name="answer_user"}
    <table lay-filter="demo">
        <thead>
        <tr>
            <th lay-data="{field:'a'}">姓名</th>
            {volist name="question_title" id="vo" key='k'}
            <th lay-data="{field:'{$k}'}">{$vo.title}</th>
            {/volist}

        </tr>
        </thead>
        <tbody>
        <tr>
            {volist name="answer_user" id="vo"}
                <td>{$vo.username}</td>
                {volist name="question_title" id="voq" key='k'}
                    <td>{$vo[$voq.id]}</td>
                {/volist}
            {/volist}

        </tr>

        </tbody>
    </table>
    {else /}
    <p style="text-align: center;color:#ccc;">暂无数据</p>
    {/notempty}
</div>
{/notempty}

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
	layui.use(['laydate','table','layer', 'form','element','jquery'], function(){
		var table = layui.table
            ,layer = layui.layer
			,$=layui.jquery
			,form = layui.form
            ,laydate = layui.laydate;
//转换静态表格
        table.init('demo', {
            toolbar: true
        });

        laydate.render({
            elem: '#startdate'
            ,type: 'datetime'
        });
        laydate.render({
            elem: '#enddate'
            ,type: 'datetime'
        });
        laydate.render({
            elem: '#start_time'
            ,type: 'datetime'
            ,range: true
        });
        var renderTable= function (){
            table.render({
                id:'userstable'
                ,toolbar: true
                ,width:$(window).width()*.9
                ,initSort: {
                    field: 'is_done' //排序字段，对应 cols 设定的各字段名
                    ,type: 'asc' //排序方式  asc: 升序、desc: 降序、null: 默认排序
                }
                ,elem: '#userstable'
                ,url: "noticeusers_timely"
                ,where: {
                    'get_list':'{$list.station|default=""}',
                    'get_lists':'{$list.department|default=""}',
                    'classname':'{$list.classname|default=""}',
                    }
                ,cols: [[
                    {type:'numbers',  title: '编号'}
                    ,{field:'region_name', align:'center',  title: '地区'}
                    ,{field:'department_name', align:'center',  title: '部门'}
                    ,{field:'project_name', align:'center',  title: '项目'}
                    ,{field:'station_name', align:'center',  title: '岗位'}
                    ,{field:'username', align:'center',  title: '姓名'}
                    ,{field:'is_done', align:'center',  title: '是否上课'}
                    ,{field:'xinde', align:'center',  title: '学习心得'}

                ]]
            });
        };
   renderTable();

        $(document).on('click','#getstation',function(){
          
 
            var station=layui.formSelects.value('select7_2', 'val'),
            posts =layui.formSelects.value('select7_0', 'val');
            if(station==''){
                layer.msg('请先选择岗位！',{icon:0,time:1000});
                return false;
            }
            var station_id=$('input[name="station"]').val();  
            table.render({
                id:'userstable'
                ,width:$(window).width()*.9
                ,method:'post'
                ,autoSort: true
                ,elem: '#userstable'
                ,url: "getPost"
                ,where: {
                    'station':station,
                    'posts':posts
                   
                }
                ,cols: [[
                                    {type:'numbers',  title: '编号'}

                    ,{field:'region', align:'center',  title: '地区'}
                    ,{field:'department', align:'center',  title: '部门'}
                    ,{field:'project', align:'center',  title: '项目'}
                    ,{field:'station', align:'center',  title: '岗位'}
                    ,{field:'username', align:'center',  title: '姓名'}
                    
                   
                ]]
                ,parseData: function(data){ //res 即为原始返回的数据
                    console.log(data);
                    layer.msg(data.msg,{icon:data.code,time:1000});
                }
            });


        });

                     



        $(document).on('click','#resetnotice',function() {
            //清空岗位
            $('input[name="station"]').val('');

            layer.msg('数据已清空，保存后生效！',{icon:0,time:2000});
        });

       

//监听select start
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


        form.on('select(question)', function(data){
            //console.log(data.elem); //得到select原始DOM对象
            console.log(data.value); //得到被选中的值
            //console.log(data.othis); //得到美化后的DOM对象

            $.ajax({
                url: "getqrcode" ,
                data: {'question':data.value,'times':{$times},'host':window.location.host} ,
                type: "post" ,
                dataType:'json',
                success:function(data){
                    console.log(data);
                    data.qrcode
                    $("#qrcode").css('display','block');
                    $("#qrcode").attr('src',data.qrcode);
                    $("#formid").append('<input type="hidden" name="qrcode" value="'+data.qrcode+'">')
                }
            });

        });
        {notempty name="list.qrcode"}
        $("#qrcode").css('display','block');
        {/notempty}
	//所属岗位开始
//监听select  end
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
			if($('#area').val()==""){ layer.alert($('#area').attr('placeholder'));  return false;};
			if($('#startdate').val()==""){ layer.alert($('#startdate').attr('placeholder'));  return false;};
			if($('#classtype').val()==""){ layer.alert('请选择类型');  return false;};
			if($('#classify').val()==""){ layer.alert('请选择分类');  return false;};
			if($('#classname').val()==""){ layer.alert('请选择课程名称');  return false;};
			if($('input[name="station"]').val()==""){ layer.alert('请选择通知岗位');  return false;};

			//if($('#classname').val()==""){ layer.alert('请选择课程名称');  return false;};
			
			return true;

		}





	})


   var ue = UE.getEditor('editor');

   

</script>
</body>
</html>