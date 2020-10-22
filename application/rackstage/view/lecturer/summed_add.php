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
    .layui-upload-img{width: 92px;  height: 92px;  margin: 0 10px 10px 0; }
</style>
<body>


<form class="layui-form" action="" id="formid"  style="margin-top: 20px;">
    {notempty name="id"}
        <input type="hidden" name="id" value="{$id}">
    {else /}
        {if condition="$outline_id eq ''"}
            <input type="hidden" name="outline_id" value="{$list.outline_id|default=''}">
            <input type="hidden" name="times" value="{$list.times|default=''}">
        {else /}
            <input type="hidden" name="outline_id" value="{$outline_id}">
            <input type="hidden" name="times" value="{$times}">
        {/if}
    {/notempty}
    <div class="layui-form-item">
        <label class="layui-form-label">上传文件</label>
        <div class="layui-input-block">
            <div class="layui-upload" style="padding-left: 30px;">
                <button type="button" class="layui-btn layui-btn-normal" id="upload_file">请选择文件</button>
                <div class="layui-upload-list">
                    <table class="layui-table">
                        <thead>
                        <tr><th>文件名</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr></thead>
                        <tbody id="demoList">
                        <?php if(!empty($imglist)){
                            foreach($imglist as $k=>$v){
                                if($v['reserve']=='peixunzhaopian'){
                                    $v["url"]="'".$v["url"]."'";
                                    echo'
                                    <tr>
                                        <td><input type=button class="layui-btn" onclick="window.open('.$v["url"].')" value="打开'.$v["filename"].'"></td>
                                        <td>已上传</td>
                                        <td><span class="layui-btn layui-btn-xs layui-btn-danger  del_uploads" indexs="'.$v["id"].'">删除</span></td>
                                    </tr>
                                    ';
                                }
                            }
                            ?>



                        <?php } ?>
                        </tbody>
                    </table>
                </div>
                <button type="button" class="layui-btn" id="testListAction">开始上传</button>
            </div>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">通知播报</label>
        <div class="layui-input-block">
            <div class="layui-upload" style="padding-left: 30px;">
                <button type="button" class="layui-btn layui-btn-normal" id="upload_file_tongzhi">请选择文件</button>
                <div class="layui-upload-list">
                    <table class="layui-table">
                        <thead>
                        <tr><th>文件名</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr></thead>
                        <tbody id="demoList_tongzhi">
                        <?php if(!empty($imglist)){
                            foreach($imglist as $k=>$v){
                                if($v['reserve']=='tongzhibobao'){
                                    $v["url"]="'".$v["url"]."'";
                                    echo'
                                    <tr>
                                        <td><input type=button class="layui-btn" onclick="window.open('.$v["url"].')" value="打开'.$v["filename"].'"></td>
                                        <td>已上传</td>
                                        <td><span class="layui-btn layui-btn-xs layui-btn-danger  del_uploads" indexs="'.$v["id"].'">删除</span></td>
                                    </tr>
                                    ';
                                }
                            }
                            ?>



                        <?php } ?>
                        </tbody>
                    </table>
                </div>
                <button type="button" class="layui-btn" id="Action_tongzhi">开始上传</button>
            </div>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">培训照片</label>
        <div class="layui-input-block">
            <div class="layui-upload" style="padding-left: 30px;">
                <button type="button" class="layui-btn layui-btn-normal" id="upload_file_photo">请选择文件</button>
                <div class="layui-upload-list">
                    <table class="layui-table">
                        <thead>
                        <tr><th>文件名</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr></thead>
                        <tbody id="demoList_photo">
                        <?php if(!empty($imglist)){
                            foreach($imglist as $k=>$v){
                                if($v['reserve']=='peixunmingdan'){
                                    $v["url"]="'".$v["url"]."'";
                                    echo'
                                    <tr>
                                        <td><input type=button class="layui-btn" onclick="window.open('.$v["url"].')" value="打开'.$v["filename"].'"></td>
                                        <td>已上传</td>
                                        <td><span class="layui-btn layui-btn-xs layui-btn-danger  del_uploads" indexs="'.$v["id"].'">删除</span></td>
                                    </tr>
                                    ';
                                }
                            }
                            ?>



                        <?php } ?>
                        </tbody>
                    </table>
                </div>
                <button type="button" class="layui-btn" id="Action_photo">开始上传</button>
            </div>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">文档附件</label>
        <div class="layui-input-block">
            <div class="layui-upload" style="padding-left: 30px;">
                <button type="button" class="layui-btn layui-btn-normal" id="upload_file_accessories">请选择文件</button>
                <div class="layui-upload-list">
                    <table class="layui-table">
                        <thead>
                        <tr><th>文件名</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr></thead>
                        <tbody id="demoList_accessories">
                        <?php if(!empty($imglist)){
                            foreach($imglist as $k=>$v){
                                if($v['reserve']=='wendangfujian'){
                                    $v["url"]="'".$v["url"]."'";
                                    echo'
                                    <tr>
                                        <td><input type=button class="layui-btn" onclick="window.open('.$v["url"].')" value="打开'.$v["filename"].'"></td>
                                        <td>已上传</td>
                                        <td><span class="layui-btn layui-btn-xs layui-btn-danger  del_uploads" indexs="'.$v["id"].'">删除</span></td>
                                    </tr>
                                    ';
                                }
                            }
                            ?>



                        <?php } ?>
                        </tbody>
                    </table>
                </div>
                <button type="button" class="layui-btn" id="Action_accessories">开始上传</button>
            </div>
        </div>
    </div>
    <div class="layui-form-item xuanze">
        <label class="layui-form-label">心得总结</label>
        <div class="layui-input-inline" style="width:700px;">
            <textarea placeholder="请输入内容" class="layui-textarea" name="mark" rows="20" style="width:80%">{$list.mark|default=''}</textarea>
        </div>
    </div>

</form>
<script src="/public/layui/layui.js" charset="utf-8"></script>
<script>

    layui.use('upload', function() {
        var $ = layui.jquery
            , upload = layui.upload;
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

        $('.layui-upload-list').css('width',$(window).width()*.8);//上传文件表的宽度
        var demoListView = $('#demoList')
            ,uploadListIns = upload.render({
            elem: '#upload_file'
            ,url: '/rackstage/index/uploads?mark=summed&reserve=peixunmingdan&times='+{$times}+'&updatetime='+{$nowtime}
            ,accept: 'file'
            ,multiple: false
            ,auto: false
            ,bindAction: '#testListAction'
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
                    console.log(res)

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
        //培训名单end
        //通知播报start
        var demoListView_tongzhi = $('#demoList_tongzhi')
            ,uploadListIns_tongzhi = upload.render({
            elem: '#upload_file_tongzhi'
            ,url: '/rackstage/index/uploads?mark=summed&reserve=tongzhibobao&times='+{$times}+'&updatetime='+{$nowtime}
            ,accept: 'file'
            ,multiple: false
            ,auto: false
            ,bindAction: '#Action_tongzhi'
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
                        uploadListIns_tongzhi.config.elem.next()[0].value = ''; //清空 input file 值，以免删除后出现同名文件不可选
                    });

                    demoListView_tongzhi.append(tr);
                });
            }
            ,done: function(res, index, upload){
                if(res.code == 0){ //上传成功
                    var tr = demoListView_tongzhi.find('tr#upload-'+ index)
                        ,tds = tr.children();
                    tds.eq(1).html('<span style="color: #5FB878;">上传成功</span>');
                    tds.eq(2).html(''); //清空操作
                    console.log(res)
                    return delete this.files[index]; //删除文件队列已经上传成功的文件
                }
                this.error(index, upload);
            }
            ,error: function(index, upload){
                var tr = demoListView_tongzhi.find('tr#upload-'+ index)
                    ,tds = tr.children();
                tds.eq(1).html('<span style="color: #FF5722;">上传失败</span>');
                tds.eq(2).find('.demo-reload').removeClass('layui-hide'); //显示重传
            }
        });
        //通知播报end
        //培训照片start
        var demoListView_photo = $('#demoList_photo')
            ,uploadListIns_photo = upload.render({
            elem: '#upload_file_photo'
            ,url: '/rackstage/index/uploads?mark=summed&reserve=peixunzhaopian&times='+{$times}+'&updatetime='+{$nowtime}
            ,accept: 'file'
            ,multiple: false
            ,auto: false
            ,bindAction: '#Action_photo'
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
                        uploadListIns_photo.config.elem.next()[0].value = ''; //清空 input file 值，以免删除后出现同名文件不可选
                    });

                    demoListView_photo.append(tr);
                });
            }
            ,done: function(res, index, upload){
                if(res.code == 0){ //上传成功
                    var tr = demoListView_photo.find('tr#upload-'+ index)
                        ,tds = tr.children();
                    tds.eq(1).html('<span style="color: #5FB878;">上传成功</span>');
                    tds.eq(2).html(''); //清空操作
                    console.log(res)
                    return delete this.files[index]; //删除文件队列已经上传成功的文件
                }
                this.error(index, upload);
            }
            ,error: function(index, upload){
                var tr = demoListView_photo.find('tr#upload-'+ index)
                    ,tds = tr.children();
                tds.eq(1).html('<span style="color: #FF5722;">上传失败</span>');
                tds.eq(2).find('.demo-reload').removeClass('layui-hide'); //显示重传
            }
        });
        //培训照片end
        //文档附件start
        var demoListView_accessories = $('#demoList_accessories')
            ,uploadListIns_accessories = upload.render({
            elem: '#upload_file_accessories'
            ,url: '/rackstage/index/uploads?mark=summed&reserve=wendangfujian&times='+{$times}+'&updatetime='+{$nowtime}
            ,accept: 'file'
            ,multiple: false
            ,auto: false
            ,bindAction: '#Action_accessories'
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
                        uploadListIns_accessories.config.elem.next()[0].value = ''; //清空 input file 值，以免删除后出现同名文件不可选
                    });

                    demoListView_accessories.append(tr);
                });
            }
            ,done: function(res, index, upload){
                if(res.code == 0){ //上传成功
                    var tr = demoListView_accessories.find('tr#upload-'+ index)
                        ,tds = tr.children();
                    tds.eq(1).html('<span style="color: #5FB878;">上传成功</span>');
                    tds.eq(2).html(''); //清空操作
                    console.log(res)
                    return delete this.files[index]; //删除文件队列已经上传成功的文件
                }
                this.error(index, upload);
            }
            ,error: function(index, upload){
                var tr = demoListView_accessories.find('tr#upload-'+ index)
                    ,tds = tr.children();
                tds.eq(1).html('<span style="color: #FF5722;">上传失败</span>');
                tds.eq(2).find('.demo-reload').removeClass('layui-hide'); //显示重传
            }
        });
        //文档附件end

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

                if($('#levels').val()==""){ layer.alert($('#levels').attr('placeholder'));  return false;};
                if($('#classtime').val()==""){ layer.alert($('#classtime').attr('placeholder'));  return false;};
                if($('#classnum').val()==""){ layer.alert($('#classnum').attr('placeholder'));  return false;};
                

                return true;

            }

        })

</script>
</body>
</html>