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
    <style>
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
        .layui-form-radio * {
            font-size: 25px;
            font-family: '微软雅黑';
        }
        #div_qualified .layui-icon + div{font-size:14px;}
    </style>
</head>
<body>

<form class="layui-form" action="" id="formid"  style="margin-top: 20px;">
    {notempty name="id"}
        <input type="hidden" name="id" value="{$id}">
    {else /}
        {empty name='times'}
            <input type="hidden" name="times" value="{$list.times|default=''}">
        {else /}
            <input type="hidden" name="times" value="{$times}">
        {/empty}
    {/notempty}

    <div class="layui-form-item">
        <label class="layui-form-label">选择部门</label>
        <div class="layui-input-inline" style="width:200px;">
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
        <div class="layui-input-inline" style="width:200px;">
            <select id="department" name="department" lay-filter="department">
                <option></option>
                {notempty name="list.department"}
                <option value="{$list.department}" selected>{$list.department_name}</option>
                {/notempty}
            </select>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">选择项目</label>
        <div class="layui-input-inline">
              <select name="project_id" id="projectName" lay-verify="required" lay-search="">
                {notempty   name="list"}
                    {volist name="lists" id="vo"}
                        <option value="{$vo.id}" {if condition="$vo.id eq $list.project_id"} selected {/if}>{$vo.name}</option>
                    {/volist}}
                {/notempty}}
                </select>
        </div>
        <div class="layui-form-mid layui-word-aux">若列表中没有，请先添加项目</div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">项目经理</label>
        <div class="layui-input-inline">
            <input type="text"  id="manager"  name="manager" value="{$list.manager|default=''}"  placeholder="请输入项目经理" class="layui-input">
        </div>
    </div>
     <div class="layui-form-item">
        <label class="layui-form-label">抽查时间</label>
        <div class="layui-input-inline">
            <input type="text"  id="enquirytime" autocomplete="off" name="enquirytime" value="{$list.enquirytime|default=''}"  placeholder="请输入巡盘时间" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">项目电话</label>
        <div class="layui-input-inline">
            <input type="text" id="project_tel" name="project_tel" value="{$list.project_tel|default=''}" placeholder="请输入项目电话" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">标准开场语</label>
        <div class="layui-input-block">
            {empty name="list.standard"}
            <input type="radio" name="standard" value="√" title="√">
            <input type="radio" name="standard" value="×" title="×">
            {else /}
            <input type="radio" name="standard" value="√" title="√" {if condition="$list.standard eq '√'"} checked {/if}>
            <input type="radio" name="standard" value="×" title="×" {if condition="$list.standard eq '×'"} checked {/if}>
            {/empty}
        </div>
        <div class="layui-inline layui-word-aux">
            是否运用标准开场语
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">积极接听</label>
        <div class="layui-input-block">
            {empty name="list.positive"}
            <input type="radio" name="positive" value="√" title="√">
            <input type="radio" name="positive" value="×" title="×">
            {else /}
            <input type="radio" name="positive" value="√" title="√" {if condition="$list.positive eq '√'"} checked {/if}>
            <input type="radio" name="positive" value="×" title="×" {if condition="$list.positive eq '×'"} checked {/if}>
            {/empty}
        </div>
        <div class="layui-inline layui-word-aux">
            是否感受到积极接听
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">自报姓名</label>
        <div class="layui-input-block">
            {empty name="list.a"}
            <input type="radio" name="a" value="√" title="√">
            <input type="radio" name="a" value="×" title="×">
            {else /}
            <input type="radio" name="a" value="√" title="√" {if condition="$list.a eq '√'"} checked {/if}>
            <input type="radio" name="a" value="×" title="×" {if condition="$list.a eq '×'"} checked {/if}>
            {/empty}
        </div>
        <div class="layui-inline layui-word-aux">
            是否主动自报姓名
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">价值点传递</label>
        <div class="layui-input-block">
            {empty name="list.core"}
            <input type="radio" name="core" value="√" title="√">
            <input type="radio" name="core" value="×" title="×">
            {else /}
            <input type="radio" name="core" value="√" title="√" {if condition="$list.core eq '√'"} checked {/if}>
            <input type="radio" name="core" value="×" title="×" {if condition="$list.core eq '×'"} checked {/if}>
            {/empty}
        </div>
        <div class="layui-inline layui-word-aux">
            是否传递项目核心价值
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">来电渠道</label>
        <div class="layui-input-block">
            {empty name="list.callfrom"}
            <input type="radio" name="callfrom" value="√" title="√">
            <input type="radio" name="callfrom" value="×" title="×">
            {else /}
            <input type="radio" name="callfrom" value="√" title="√" {if condition="$list.callfrom eq '√'"} checked {/if}>
            <input type="radio" name="callfrom" value="×" title="×" {if condition="$list.callfrom eq '×'"} checked {/if}>
            {/empty}
        </div>
        <div class="layui-inline layui-word-aux">
            是否询问客户来电渠道
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">邀约客户</label>

        <div class="layui-input-block">
            {empty name="list.invitation"}
            <input type="radio" name="invitation" value="√" title="√">
            <input type="radio" name="invitation" value="×" title="×">
            {else /}
            <input type="radio" name="invitation" value="√" title="√" {if condition="$list.invitation eq '√'"} checked {/if}>
            <input type="radio" name="invitation" value="×" title="×" {if condition="$list.invitation eq '×'"} checked {/if}>
            {/empty}
        </div>
        <div class="layui-inline layui-word-aux">
            是否邀约客户到访并留电
        </div>
    </div>
     <div class="layui-form-item">
        <label class="layui-form-label">主动留电</label>

        <div class="layui-input-block">
            {empty name="list.b"}
            <input type="radio" name="b" value="√" title="√">
            <input type="radio" name="b" value="×" title="×">
            {else /}
            <input type="radio" name="b" value="√" title="√" {if condition="$list.b eq '√'"} checked {/if}>
            <input type="radio" name="b" value="×" title="×" {if condition="$list.b eq '×'"} checked {/if}>
            {/empty}
        </div>
        <div class="layui-inline layui-word-aux">
是否主动留取客户电话        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">是否合格</label>
        <div class="layui-input-block" id="div_qualified">
            {empty name="list.qualified"}
            <input type="radio" name="qualified" value="合格" title="合格">
            <input type="radio" name="qualified" value="不合格" title="不合格">
            {else /}
            <input type="radio" name="qualified" value="合格" title="合格" {if condition="$list.qualified eq '合格'"} checked {/if}>
            <input type="radio" name="qualified" value="不合格" title="不合格" {if condition="$list.qualified eq '不合格'"} checked {/if}>
            {/empty}
        </div>
        <div class="layui-inline layui-word-aux">
            是否合格
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">上传录音</label>
        <input type="hidden" name="" value="{$list.file_url|default=''}"  id="file_url"/>
        <div class="layui-input-block">
            <div class="layui-upload" style="padding-left: 30px;">
                <button type="button" class="layui-btn layui-btn-normal" id="upload_img">请选择文件</button>
                <div class="layui-inline layui-word-aux">
                    允许上传小于20M的mp3文件
                </div>
                <div class="layui-upload-list">
                    <table class="layui-table">
                        <thead>
                        <tr><th>文件名</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr></thead>
                        <tbody id="qualified_file">
                        <?php if(!empty($imglist)){
                            foreach($imglist as $k=>$v){

                                    $v["url"]="'".$v["url"]."'";
                                    echo'
                                    <tr>
                                        <td><a href='.$v["url"].' target="_blank">'.$v["filename"].'</a></td>
                                        <td>已上传</td>
                                        <td><span class="layui-btn layui-btn-xs layui-btn-danger del_uploads"  indexs="'.$v["id"].'">删除</span></td>
                                    </tr>
                                    ';

                            }
                            ?>



                        <?php } ?>
                        </tbody>
                    </table>
                </div>
                <button type="button" class="layui-btn" id="qualifiedAction">开始上传</button>
            </div>
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
<script>
    layui.use('upload', function() {
        var $ = layui.jquery
            , upload = layui.upload;

        $('.layui-upload-list').css('width',$(window).width()*.8);//上传文件表的宽度




        //多文件列表first
        var demoListView = $('#qualified_file')
            ,uploadListIns = upload.render({
            elem: '#upload_img'
            ,url: '/rackstage/index/uploads?mark=answercall&reserve=mp3&times='+{$times}+'&updatetime='+{$nowtime}
            ,multiple: true
            ,auto: false
                ,accept: 'audio' //音频
                ,bindAction: '#qualifiedAction'
            ,choose: function(obj){
                var files = this.files = obj.pushFile(); //将每次选择的文件追加到文件队列
                //读取本地文件
                obj.preview(function(index, file, result){
                    var tr = $(['<tr id="upload-'+ index +'">'
                        ,'<td>'+ file.name +'</td>'
                        ,'<td>等待上传</td>'
                        ,'<td>'
                        ,'<button class="layui-btn layui-btn-xs demo-reload layui-hide">重传</button>'
                        ,'<button class="layui-btn layui-btn-xs layui-btn-danger demo-delete">删除</button>'
                        ,'</td>'
                        ,'</tr>'].join(''));

                    //单个重传
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
                    tds.eq(1).html('<span style="color: #5FB878;">上传成功</span>');
                    tds.eq(2).html(''); //清空操作
                    return delete this.files[index]; //删除文件队列已经上传成功的文件
                }
                this.error(index, upload);
            }
            ,error: function(index, upload){
                var tr = demoListView.find('tr#upload-'+ index)
                    ,tds = tr.children();
                tds.eq(1).html('<span style="color: #FF5722;">上传失败</span>');
                tds.eq(2).find('.demo-reload').removeClass('layui-hide'); //显示重传
            }
        });


    });
    var callbackdata;
        layui.use(['laydate','layer', 'form','element','jquery'], function(){
            var layer = layui.layer
                ,$=layui.jquery
                ,form = layui.form
                ,laydate = layui.laydate;
            $(document).on('click','.del_uploads',function(){
                var O_id=$(this).attr('indexs');
                layer.confirm('确定删除吗', function(index){
                    $.ajax({
                        url: "/rackstage/index/uploads_del" ,
                        data: {'id':O_id} ,
                        type: "post" ,
                        dataType:'json',
                        success:function(data){
                            layer.msg(data.msg, {icon: data.code,time:500},function(){
                                location.reload();
                            });
                        }
                    })
                });
            });

            laydate.render({
                elem: '#enquirytime'

            });
            // 所属部门开始
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
                        form.render('select');
                    }
                })
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
            }
            //自定义验证规则
            function verifycontent() {
                if($('#projectName').val()==null){ layer.alert('项目部门不能为空');  return false;};
                 if($('#manager').val()==""){ layer.alert('项目经理不能为空');  return false;};

                 if($('#enquirytime').val()==""){ layer.alert('巡查时间不能为空');  return false;};

                 if($('#project_tel').val()==""){ layer.alert('项目电话不能为空');  return false;};

                return true;

            }
//所属项目开始
        form.on('select(department)', function(data){
            $.ajax({
                url: "/rackstage/Personnel/getproject" ,
                data: {'pid':data.value} ,
                type: "get" ,
                dataType:'json',
                success:function(data){
                    $("#projectName").empty();
                    $("#projectName").append("<option value=''>请选择</option>");//新增
                    for(var i = 0; i < data.length; i++){
                        $("#projectName").append("<option value='"+data[i].id+"'>"+data[i].name+"</option>");//新增
                    }
                    form.render('select');
                }
            })
        });

        })

</script>
</body>
</html>