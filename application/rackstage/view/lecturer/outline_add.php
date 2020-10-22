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
<style>



    #classtable + div{margin-left:50px;}
    #userstable + div{margin-left:50px;}
    #diaocha + div{margin-left:50px;}
    .layui-table td, .layui-table th{text-align: center;}
</style>
<body>


<form class="layui-form" action="" id="formid"  style="margin-top: 20px;">
    <input type="hidden" name="id" value="{$list.id|default=''}" >
    <input type="hidden" name="qrcode" value="{$list.qrcode|default=$img}">
    <input type="hidden" name="times" value="{$times}" >
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
        <label class="layui-form-label">提交身份证号</label>
        <div class="layui-input-inline">
            <select name="is_zheng" id="is_zheng" lay-filter="is_zheng" >
                <option value="{$list.is_zheng|default=''}">{$list.is_zheng|default=''}</option>
                <option value="是">是</option>
                <option value="否">否</option>

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

    <div class="layui-form-item outline online">
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
    <div class="layui-form-item outline online">
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
        <div class="layui-inline layui-word-aux">只筛选未学过此分类的员工</div>
    </div>
    <div class="layui-form-item outline online">
        <label class="layui-form-label"></label>
        <div class="layui-input-block">
            <span class="layui-btn" id="getclassname">确认分类</span>
        </div>
    </div>
    <div class="layui-form-item outline online">
        <label class="layui-form-label">地区部门</label>
        <div class="layui-input-inline">
            <div id="demo1"></div>
        </div>
    </div>
    <div class="layui-form-item outline online">
        <label class="layui-form-label">选择项目</label>
        <div class="layui-input-inline" >
            <div id="demo2"></div>

        </div>
    </div>
    <div class="layui-form-item outline online">
        <label class="layui-form-label">选择岗位</label>
        <div class="layui-input-inline" >
            <div id="demo3"></div>
        </div>
    </div>

    <div class="layui-form-item outline online">
        <label class="layui-form-label">时间范围</label>
        <div class="layui-input-inline" style="width:150px;">
            <input style="" type="text" id="start_time" lay-verify="required" value="" placeholder="请选择开始日期" autocomplete="off" class="layui-input">
        </div>
        <div class="layui-form-mid">~</div>
        <div class="layui-input-inline" style="width:150px;">
            <input type="text" id="end_time" lay-verify="required" value="" placeholder="请选择结束日期" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item outline online">
        <label class="layui-form-label"></label>
        <div class="layui-input-block">
            <span class="layui-btn layui-btn-danger " id="noticeusers">确认筛选</span>
            <span class="layui-btn layui-btn-normal " id="resetnotice">清空筛选</span>
            {notempty name="list"}
            <span class="layui-btn " id="addonemore">增加一人</span>
            {/notempty}
        </div>
    </div>
    <div class="layui-form-item layui-form-text outline online">
        <label class="layui-form-label">备注</label>
        <div class="layui-input-block">
            <textarea placeholder="请输入内容" class="layui-textarea" name="mark" style="width:80%">{$list.mark|default=''}</textarea>
        </div>
    </div>
    {empty name="browse"}
    <div style="position: absolute;right: 45%;top: 50px;text-align:center;" >
        <img id="qrcode" src="{$list.qrcode|default=$img}">
        <div>扫描二维码进行培训考试</div>
    </div>
    {/empty}
</form>

<fieldset class="layui-elem-field layui-field-title outline online" style="margin-top: 30px;">
    <legend>通知、播报、反馈</legend>
</fieldset>
<div class="layui-upload" style="margin-left:50px;" >
    <button type="button" class="layui-btn layui-btn-normal" id="testList">选择文件上传</button>
    <div class="layui-upload-list">
        <table class="layui-table">
            <thead>
            <tr><th>文件名</th>
                <th>大小</th>
                <th>状态</th>
                <th>操作</th>
            </tr></thead>
            <tbody id="demoList"></tbody>
        </table>
    </div>
    <button type="button" class="layui-btn" id="testListAction">开始上传</button>
    {notempty name="nameList"}
    {volist name="nameList" id="vo"}
    <a href="https://view.officeapps.live.com/op/view.aspx?src=http://app.sz-senox.com/{$vo.url}" ><button type="button" class="layui-btn layui-btn-warm">{$vo.name}</button></a>
    {/volist}
    {/notempty}

</div>
<fieldset class="layui-elem-field layui-field-title outline online" style="margin-top: 30px;">
    <legend>课程安排</legend>
</fieldset>
<div class="layui-form addclass outline online" id="classnames">
    <table class="layui-table"  lay-filter="classtable" id="classtable" align="center"></table>
</div>

{notempty name="count"}
<script type="text/html" id="barDemo">
    <a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="detail">查看考核试题</a>
</script>
<fieldset class="layui-elem-field layui-field-title outline online" style="margin-top: 30px;">
    <legend>考核成绩</legend>
</fieldset>
<div class="outline online">
    <table class="layui-table outline online"  lay-filter="diaocha" id="diaocha" align="center"></table>
</div>
<fieldset class="layui-elem-field layui-field-title outline online" style="margin-top: 30px;">
    <legend>通知人员</legend>
</fieldset>
<div class="outline online">
    <table class="layui-table outline online"  lay-filter="userstable" id="userstable" align="center"></table>
</div>
{else/}
<fieldset class="layui-elem-field layui-field-title outline online" style="margin-top: 30px;">
    <legend>通知人员</legend>
</fieldset>
<div class="outline online">
    <table class="layui-table outline online"  lay-filter="userstable" id="userstable" align="center"></table>
</div>
<script type="text/html" id="barDemo">
    <a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="detail">查看考核试题</a>
</script>
<fieldset class="layui-elem-field layui-field-title outline online" style="margin-top: 30px;">
    <legend>考核成绩</legend>
</fieldset>
<div class="outline online">
    <table class="layui-table outline online"  lay-filter="diaocha" id="diaocha" align="center"></table>
</div>

{/notempty}


<script src="/public/layui/layui.js"></script>
<script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>

<script src="/public/treetable/xm-select.js" charset="utf-8"></script>

<!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->
<script>

    var demo1 = xmSelect.render({
        el: '#demo1',
        tree: {
            show: true,
            showFolderIcon: true,
            showLine: true,
            indent: 20,
            expandedKeys: [ -3 ],
        },
        model: {
            label: {
                type: 'block',
                block: {
                    //最大显示数量, 0:不限制
                    showCount: 1,
                    //是否显示删除图标
                    showIcon: true,
                }
            }
        },
        theme:{
            color:'#FF5722',
        },
        toolbar: {
            show: true,
            list: ['ALL', 'REVERSE', 'CLEAR']
        },
        filterable: true,
        height: '400px',
        name:'department',
        filterable:false,
        data(){
        return {$lists1}
    }
    })

    var demo2 = xmSelect.render({
        el: '#demo2',
        toolbar:{
            show: true,
        },
        filterable: true,
        model: {
            label: {
                type: 'block',
                block: {
                    //最大显示数量, 0:不限制
                    showCount: 1,
                    //是否显示删除图标
                    showIcon: true,
                }
            }
        },
        theme:{
            color:'#FF5722',
        },
        height: '400px',
            direction: 'down',

        name:'project',
        data: [],
        show()
    {
        var selectArr = demo1.getValue('value');
        $.ajax({
            url: "/rackstage/Personnel/getProjects" ,
            data: {'pid':selectArr} ,
            type: "post" ,
            dataType:'json',
            success:function(data){
                demo2.update({
                    data: data.data,
                    autoRow: true,
                })
            }
        })
    },
    })


    var demo3 = xmSelect.render({
        el: '#demo3',
        toolbar:{
            show: true,
        },
        filterable: true,
        model: {
            label: {
                type: 'block',
                block: {
                    //最大显示数量, 0:不限制
                    showCount: 1,
                    //是否显示删除图标
                    showIcon: true,
                }
            }
        },
        theme:{
            color:'#FF5722',
        },
        height: '400px',
        name:'station',
        data: {$posts}
    })
    var callbackdata;
    layui.use(['laydate','table','layer', 'form','element','jquery','upload'], function(){
        var table = layui.table
            ,layer = layui.layer
            ,upload = layui.upload
            ,$=layui.jquery
            ,form = layui.form
            ,laydate = layui.laydate;
        var demoListView = $('#demoList')
            ,uploadListIns = upload.render({
                elem: '#testList'
                ,url: 'getFeekBacks?times='+{$times} //改成您自己的上传接口
                ,accept: 'file'
                ,exts: 'ppt|word|excel|xls|xlsx|docx|doc|pptx|msg' //只允许上传压缩文件
                ,multiple: true
                ,auto: false
                ,bindAction: '#testListAction'
                ,choose: function(obj){
                    var files = this.files = obj.pushFile(); //将每次选择的文件追加到文件队列
                    //读取本地文件
                    obj.preview(function(index, file, result){
                        var tr = $(['<tr id="upload-'+ index +'">'
                            ,'<td>'+ file.name +'</td>'
                            ,'<td>'+ (file.size/1024).toFixed(1) +'kb</td>'
                            ,'<td>等待上传</td>'
                            ,'<td>'
                            ,'<button class="layui-btn layui-btn-xs demo-reload layui-hide">重传</button>'
                            ,'<button class="layui-btn layui-btn-xs layui-btn-danger demo-delete">删除</button>'
                            ,'</td>'
                            ,'</tr>'].join(''));
                        tr.find('.demo-reload').on('click', function(){
                            obj.upload(index, file);
                        });

                        //删除
                        tr.find('.demo-delete').on('click', function(){
                            delete files[index]; //删除对应的文件
                            tr.remove();
                            uploadListIns.config.elem.next()[0].value = ''; //清空 input file 值，以免删除后出现同名文件不可选
                        });

                        demoListView.append(tr);
                    });
                }
                ,done: function(res, index, upload){
                    if(res.code == 0){ //上传成功
                        var tr = demoListView.find('tr#upload-'+ index)
                            ,tds = tr.children();
                        tds.eq(2).html('<span style="color: #5FB878;">上传成功</span>');
                        tds.eq(3).html(''); //清空操作
                        return delete this.files[index]; //删除文件队列已经上传成功的文件
                        reload();
                    }
                    this.error(index, upload);
                }
                ,error: function(index, upload){
                    var tr = demoListView.find('tr#upload-'+ index)
                        ,tds = tr.children();
                    tds.eq(2).html('<span style="color: #FF5722;">上传失败</span>');
                    tds.eq(3).find('.demo-reload').removeClass('layui-hide'); //显示重传
                }
            });
        var clientWidth=$(window).width();
        var clientHeight=$(window).height();


        table.on('tool(diaocha)', function(obj){
            var data = obj.data;
            if(obj.event === 'detail'){
                console.log(data.times);
                var index = layer.open({
                    title:"列表",
                    type: 2,
                    content: "kaohe?id="+data.id+"&times="+data.class_time,
                    area: [clientWidth*0.9+'px', '650px'],
                    maxmin: true
                });
                layer.full(index);
            }
        });


//转换静态表格
        table.init('demo', {
            toolbar: true

        });

        laydate.render({
            elem: '#startdate'
            ,type: 'date'
        });
        laydate.render({
            elem: '#enddate'
            ,type: 'date'
        });
        laydate.render({
            elem: '#start_time'
            ,type: 'datetime'
        });
        laydate.render({
            elem: '#end_time'
            ,type: 'datetime'
        });
        var renderTable= function (){
            table.render({
                id:'userstable'
                ,width:$(window).width()*.9
                ,toolbar: true
                ,initSort: {
                    field: 'is_done' //排序字段，对应 cols 设定的各字段名
                    ,type: 'asc' //排序方式  asc: 升序、desc: 降序、null: 默认排序
                }
                ,elem: '#userstable'
                ,url: "noticeusers"
                ,where: {'get_list':{$times}}
                ,cols: [[
                    {type:'numbers',  title: '编号'}
                    ,{field:'region_name', align:'center',  title: '地区'}
                    ,{field:'department_name', align:'center',  title: '部门'}
                    ,{field:'project_name', align:'center',  title: '项目'}
                    ,{field:'station_name', align:'center',  title: '岗位'}
                    ,{field:'username', align:'center',  title: '姓名'}
                    ,{field:'start_time', align:'center',  title: '入职时间'}

                    ,{field:'num', align:'center',  title: '通知次数(包括本次)'}
                    ,{field:'is_done', align:'center',  title: '是否上课'}
                ]]
            });
        };

        var renderTable3= function (){
            table.render({
                id:'diaocha'
                ,width:$(window).width()*.9
                ,toolbar: true

                ,elem: '#diaocha'
                ,url: "getdiaocha"
                ,where: {'get_list':{$times}}
                ,cols: [[
                    {type:'numbers',  title: '编号'}
                    ,{field:'region_title', align:'center',  title: '地区'}
                    ,{field:'department_title', align:'center',  title: '部门'}
                    ,{field:'station_title', align:'center',  title: '岗位'}
                    ,{field:'project_title', align:'center',  title: '项目名称'}
                    ,{field:'username', align:'center',  title: '姓名'}
                    ,{field:'branch', align:'center',  title: '分数',edit: 'text'}
                    ,{field:'proposal', align:'center',  title: '建议'}
                    ,{field:'experience', align:'center',  title: '心得'}
                    ,{field:'puzzled', align:'center',  title: '困惑'}
                    ,{field:'zhichi', align:'center',  title: '课程支持'}
                    ,{fixed: 'right', width:'12%', align:'center', toolbar: '#barDemo',title:'操作'}

                ]]
            });
        };


        renderTable();  renderTable3();
        $(document).on('click','#resetnotice',function() {
            table.render({
                id:'userstable'
                ,width:$(window).width()*.9
                ,method:'post'
                ,autoSort: true
                ,elem: '#userstable'
                ,url: "noticeusers"
                ,where: {
                    'reset':1,
                    'times':{$times},

                }
                ,cols: [[
                    {type:'numbers',  title: '编号'}
                    ,{field:'region_name', align:'center',  title: '地区'}
                    ,{field:'department_name', align:'center',  title: '部门'}
                    ,{field:'project_name', align:'center',  title: '项目'}
                    ,{field:'station_name', align:'center',  title: '岗位'}
                    ,{field:'username', align:'center',  title: '姓名'}
                    ,{field:'start_time', align:'center',  title: '入职时间'}
                    ,{field:'num', align:'center',  title: '通知次数'}
                    ,{field:'is_done', align:'center',  title: '是否上课'}
                ]]
                ,parseData: function(data){ //res 即为原始返回的数据
                    console.log(data);
                    layer.msg(data.msg,{icon:data.code,time:1000});
                }
            });
        })

        $(document).on('click','#noticeusers',function(){
            var department=demo1.getValue('value');
            var project=demo2.getValue('value');
            var station=demo3.getValue('value');
            var start_time=$('#start_time').val();
            var end_time=$('#end_time').val();
            var classify=$('#classify').val();
            if(classify==''){
                layer.msg('请先选择课程分类！',{icon:0,time:1000});
                return false;
            }
            if(department==''&&station==''&&start_time==''&&project==''){
                layer.msg('请先选择筛选通知人员的条件！',{icon:0,time:1000});
                return false;
            }

            if(start_time !=''){
                if(end_time =='')
                {
                    layer.msg('开始、结束时间必须同时选择！',{icon:0,time:1000});
                    return false;
                }
            }
            if(end_time !=''){
                if(start_time =='')
                {
                    layer.msg('开始、结束时间必须同时选择！',{icon:0,time:1000});
                    return false;
                }
            }

            table.render({
                id:'userstable'
                ,width:$(window).width()*.9
                ,method:'post'
                ,autoSort: true
                ,elem: '#userstable'
                ,url: "noticeusers"
                ,where: {
                    'department':department,
                    'station':station,
                    'start_time':start_time,
                    'end_time':end_time,
                    'project':project,
                    'classify':classify,
                    'times':{$times},

                }
                ,cols: [[
                    {type:'numbers',  title: '编号'}
                    ,{field:'region_name', align:'center',  title: '地区'}
                    ,{field:'department_name', align:'center',  title: '部门'}
                    ,{field:'project_name', align:'center',  title: '项目'}
                    ,{field:'station_name', align:'center',  title: '岗位'}
                    ,{field:'username', align:'center',  title: '姓名'}
                    ,{field:'start_time', align:'center',  title: '入职时间'}
                    ,{field:'num', align:'center',  title: '通知次数'}
                ]]
                ,parseData: function(data){ //res 即为原始返回的数据
                    console.log(data);
                    layer.msg(data.msg,{icon:data.code,time:1000});
                }
            });

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


        });

        form.on('select(is_outline)', function(data){

            $('.outline').hide();

        });



//监听select  end
        //返回值
        callbackdata=function () {
            if(!verifycontent()){
                false;
            }else {
                var data =$("#formid").serialize();
                return data;
            }
        };
        //自定义验证规则
        function verifycontent() {
            if($('#area').val()==""){ layer.alert($('#area').attr('placeholder'));  return false;};
            if($('#startdate').val()==""){ layer.alert($('#startdate').attr('placeholder'));  return false;};
            if($('#classtype').val()==""){ layer.alert('请选择类型');  return false;};
            if($('#classify').val()==""){ layer.alert('请选择分类');  return false;};

            //if($('#classname').val()==""){ layer.alert('请选择课程名称');  return false;};


            return true;

        }

        {notempty name="browse"}
        $('.layui-form-item').hide();
        var renderTable1= function (){
            table.render({
                id:'classtable'
                ,width:'500'
                ,autoSort: true
                ,elem: '#classtable'
                ,url: "outline_add"
                ,where: {'get_list':{$times}}
                ,cols: [[
                    {type:'numbers',  title: '编号'}
                    ,{field:'classname', align:'center',  title: '课程名称'}
                    ,{field:'username', align:'center',  title: '讲师姓名'}
                    ,{field:'classtime', align:'center',  title: '时长'}
                ]]
            });
        };

        renderTable1();

        {else /}
        var renderTable1= function (){
            table.render({
                id:'classtable'
                ,width:'500'
                ,autoSort: true
                ,elem: '#classtable'
                ,url: "outline_add"
                ,where: {'get_list':{$times}}
                ,cols: [[
                    {type:'numbers',  title: '编号'}
                    ,{field:'classname', align:'center',  title: '课程名称'}
                    ,{field:'username', align:'center',  title: '讲师姓名', event: 'set_lecturer', style:'cursor: pointer;'}
                    ,{field:'classtime', align:'center',  title: '时长',edit:'text'}
                ]]
            });
        };

        renderTable1();
        {/notempty}


        $(document).on('click','#addonemore',function(){
            var index = layer.open({
                type: 2,
                shade: [0.1],
                title:"添加/编辑",
                area: [clientWidth*.7+'px', clientHeight*.6+'px'],
                maxmin: true,
                content: '/rackstage/Lecturer/addonemore?times={$list.times|default=""}&classify={$list.classify|default=""}',
                btn: ['保存','关闭'],
                zIndex: layer.zIndex, //重点1
                yes: function(index){
                    var row= window["layui-layer-iframe" + index].callbackdata();
                    //console.log(row);return false;
                    if(!$.trim(row)){
                        return false;
                    }
                    $.ajax({
                        url:'/rackstage/Lecturer/addonemore',
                        type:"post",
                        dataType: "json",
                        cache: false,
                        data:row,
                        async:true,
                        contentType: "application/x-www-form-urlencoded; charset=utf-8",
                        success:function(data){
                            if(data.code==1){
                                layer.closeAll();
                                layer.msg(data.msg,{icon:1,time: 1000},function () {
                                    renderTable();//location.reload();
                                });
                            }else{
                                layer.msg(data.msg, { icon: 0});
                            }
                        }
                    });
                },
                cancel: function(){
                },
                end: function(){ //此处用于演示
                }
            });
        });
        $(document).on('click','#getclassname',function(){
            var classify=$('#classify').val();
            if(classify==''){
                layer.msg('请先选择课程分类！',{icon:0,time:1000});
                return false;
            }
            table.render({
                id:'classtable'
                ,width:'500'
                ,autoSort: true
                ,elem: '#classtable'
                ,url: "outline_lecturer_add"
                ,where: {'pid':classify,'levels':'2',times:{$times}}
                ,cols: [[
                    {type:'numbers',  title: '编号'}
                    ,{field:'classname', align:'center',  title: '课程名称'}
                    ,{field:'username', align:'center',  title: '讲师姓名', event: 'set_lecturer', style:'cursor: pointer;'}
                    ,{field:'classtime', align:'center',  title: '时长',edit:'text'}
                ]]
                ,parseData: function(data){ //res 即为原始返回的数据
                    console.log(data);
                    layer.msg(data.msg,{icon:data.code,time:1000});
                }
            });

        });
        //监听单元格事件
        table.on('tool(classtable)', function(obj){
            var data = obj.data;
            if(obj.event === 'set_lecturer'){
                console.log(data);
                layer.open({
                    type: 2,
                    shade: [0.1],
                    title:"添加/编辑",
                    area: ['600px', '430px'],
                    maxmin: true,
                    content: 'set_lecturer?lecturer='+data.lecturer+'&id='+data.id,
                    btn: ['保存'],
                    zIndex: layer.zIndex, //重点1
                    yes: function(index){

                        layer.closeAll();
                        renderTable1();
                    },
                    cancel: function(){
                    },
                    end: function(){ //此处用于演示
                    }
                });
            }
        });
        //编辑表格工具
        table.on('edit(classtable)', function(obj){
            var value = obj.value //得到修改后的值
                ,data = obj.data //得到所在行所有键值
                ,field = obj.field; //得到字段
            //layer.msg('[ID: '+ data.id +'] ' + field + ' 字段更改为：'+ value);

            $.ajax({
                url: "outline_lecturer_field_edit",
                data: {'id':data.id,'field':field,'value':value} ,
                type: "post" ,
                dataType:'json',
                success:function(data){
                    layer.msg(data.msg, {icon: data.code,time:500},function(){
                        //renderTable();
                    });
                }
            })
        });


        //编辑表格工具
        table.on('edit(diaocha)', function(obj){
            var value = obj.value //得到修改后的值
                ,data = obj.data //得到所在行所有键值
                ,field = obj.field; //得到字段
            //layer.msg('[ID: '+ data.id +'] ' + field + ' 字段更改为：'+ value);

            $.ajax({
                url: "editFen",
                data: {'id':data.id,'field':field,'value':value} ,
                type: "post" ,
                dataType:'json',
                success:function(data){
                    layer.msg(data.msg, {icon: data.code,time:500},function(){
                        //renderTable();
                    });
                }
            })
        });


    })


</script>
</body>
</html>