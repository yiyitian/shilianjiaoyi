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
        input,textarea{color:#666;}
    </style>
</head>

<body>


<form class="layui-form" action="" id="formid"  style="margin-top: 20px;">

    <div class="layui-form-item">
        <label class="layui-form-label">选择部门</label>
        <div class="layui-input-inline" style="width:200px;">
            <input type="text" readonly  id=""  name="manager" value="{$list.region_name|default=''}"  placeholder="请输入项目经理" class="layui-input">


        </div>
        <div class="layui-input-inline" style="width:200px;">
            <input type="text" readonly  id=""  name="manager" value="{$list.department_name|default=''}"  placeholder="请输入项目经理" class="layui-input">

        </div>

    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">已选项目</label>
        <div class="layui-input-inline">
            <div class="search">
                <input type="text" readonly id="" name="project_id" value="{$list['project_name']}" class="layui-input" placeholder="请务必从列表中选择项目"/>
                <div id="">
                </div>
            </div>
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">项目经理</label>
        <div class="layui-input-inline">
            <input type="text" readonly  id=""  name="manager" value="{$list.manager|default=''}"  placeholder="请输入项目经理" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">得分</label>
        <div class="layui-input-inline">
            <input type="text" readonly  id=""  name="score" value="{$list.score|default=''}"  placeholder="请输入得分" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">等级</label>
        <div class="layui-input-inline">
            <input type="text" readonly  id=""  name="score" value="{$list.levels|default=''}"  placeholder="请输入得分" class="layui-input">

        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label"> 考勤纪律</label>
        <div class="layui-input-inline">
            <input type="text"  readonly  id="a"  name="a" value="{$list.a|default=''}"  placeholder="请输入扣分详情" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">不合格照片</label>
        <div class="layui-input-block">
            <div class="layui-upload" style="padding-left: 30px;">
                <div class="layui-upload-list">
                    <table class="layui-table">
                        <thead>
                        <tr><th>文件名</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr></thead>
                        <tbody id="file">
                        <?php if(!empty($file)){
                            foreach($file as $k=>$v){

                                echo'
                                        <tr>
                                            <td><a href=/public/'.$v["images"].' target="_blank"><img src=/public/'.$v["images"].' /></a></td>
                                            <td>已上传</td>
                                        </tr>
                                        ';

                            }
                            ?>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label"> 仪容仪表 </label>
        <div class="layui-input-inline">
            <input type="text"  readonly  id="b"  name="b" value="{$list.b|default=''}"  placeholder="请输入扣分详情" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">不合格照片</label>
        <div class="layui-input-block">
            <div class="layui-upload" style="padding-left: 30px;">
                <div class="layui-upload-list">
                    <table class="layui-table">
                        <thead>
                        <tr><th>文件名</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr></thead>
                        <tbody id="file1">
                        <?php if(!empty($file1)){
                            foreach($file1 as $k=>$v){

                                echo'
                                        <tr>
                                            <td><a href=/public/'.$v["images"].' target="_blank"><img src=/public/'.$v["images"].' /></a></td>
                                            <td>已上传</td>
                                        </tr>
                                        ';

                            }
                            ?>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label"> 行为规范 </label>
        <div class="layui-input-inline">
            <input type="text"  readonly  id="c"  name="c" value="{$list.c|default=''}"  placeholder="请输入扣分详情" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">不合格照片</label>
        <div class="layui-input-block">
            <div class="layui-upload" style="padding-left: 30px;">
                <div class="layui-upload-list">
                    <table class="layui-table">
                        <thead>
                        <tr><th>文件名</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr></thead>
                        <tbody id="file2">
                        <?php if(!empty($file2)){
                            foreach($file2 as $k=>$v){

                                echo'
                                        <tr>
                                            <td><a href=/public/'.$v["images"].' target="_blank"><img src=/public/'.$v["images"].' /></a></td>
                                            <td>已上传</td>
                                        </tr>
                                        ';

                            }
                            ?>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label"> 团队激励  </label>
        <div class="layui-input-inline">
            <input type="text"  readonly  id="d"  name="d" value="{$list.d|default=''}"  placeholder="请输入扣分详情" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">不合格照片</label>
        <div class="layui-input-block">
            <div class="layui-upload" style="padding-left: 30px;">
                <div class="layui-upload-list">
                    <table class="layui-table">
                        <thead>
                        <tr><th>文件名</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr></thead>
                        <tbody id="file3">
                        <?php if(!empty($file3)){
                            foreach($file3 as $k=>$v){

                                echo'
                                        <tr>
                                            <td><a href=/public/'.$v["images"].' target="_blank"><img src=/public/'.$v["images"].' /></a></td>
                                            <td>已上传</td>
                                        </tr>
                                        ';

                            }
                            ?>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label"> 公共区域维护 </label>
        <div class="layui-input-inline">
            <input type="text"  readonly  id="e"  name="e" value="{$list.e|default=''}"  placeholder="请输入扣分详情" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">不合格照片</label>
        <div class="layui-input-block">
            <div class="layui-upload" style="padding-left: 30px;">
                <div class="layui-upload-list">
                    <table class="layui-table">
                        <thead>
                        <tr><th>文件名</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr></thead>
                        <tbody id="file13">
                        <?php if(!empty($file13)){
                            foreach($file13 as $k=>$v){

                                echo'
                                        <tr>
                                            <td><a href=/public/'.$v["images"].' target="_blank"><img src=/public/'.$v["images"].' /></a></td>
                                            <td>已上传</td>
                                        </tr>
                                        ';

                            }
                            ?>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label"> 会议组织 </label>
        <div class="layui-input-inline">
            <input type="text"  readonly  id="f"  name="f" value="{$list.f|default=''}"  placeholder="请输入扣分详情" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">不合格照片</label>
        <div class="layui-input-block">
            <div class="layui-upload" style="padding-left: 30px;">
                <div class="layui-upload-list">
                    <table class="layui-table">
                        <thead>
                        <tr><th>文件名</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr></thead>
                        <tbody id="file4">
                        <?php if(!empty($file4)){
                            foreach($file4 as $k=>$v){

                                echo'
                                        <tr>
                                            <td><a href=/public/'.$v["images"].' target="_blank"><img src=/public/'.$v["images"].' /></a></td>
                                            <td>已上传</td>
                                        </tr>
                                        ';

                            }
                            ?>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label"> 接待流程  </label>
        <div class="layui-input-inline">
            <input type="text"  readonly  id="g"  name="g" value="{$list.g|default=''}"  placeholder="请输入扣分详情" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">不合格照片</label>
        <div class="layui-input-block">
            <div class="layui-upload" style="padding-left: 30px;">
                <div class="layui-upload-list">
                    <table class="layui-table">
                        <thead>
                        <tr><th>文件名</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr></thead>
                        <tbody id="file14">
                        <?php if(!empty($file14)){
                            foreach($file14 as $k=>$v){

                                echo'
                                        <tr>
                                            <td><a href=/public/'.$v["images"].' target="_blank"><img src=/public/'.$v["images"].' /></a></td>
                                            <td>已上传</td>
                                        </tr>
                                        ';

                            }
                            ?>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label"> 电话接听 </label>
        <div class="layui-input-inline">
            <input type="text"   readonly id="h"  name="h" value="{$list.h|default=''}"  placeholder="请输入扣分详情" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">不合格照片</label>
        <div class="layui-input-block">
            <div class="layui-upload" style="padding-left: 30px;">
                <div class="layui-upload-list">
                    <table class="layui-table">
                        <thead>
                        <tr><th>文件名</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr></thead>
                        <tbody id="file5">
                        <?php if(!empty($file5)){
                            foreach($file5 as $k=>$v){

                                echo'
                                        <tr>
                                            <td><a href=/public/'.$v["images"].' target="_blank"><img src=/public/'.$v["images"].' /></a></td>
                                            <td>已上传</td>
                                        </tr>
                                        ';

                            }
                            ?>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label"> 小客户回访   </label>
        <div class="layui-input-inline">
            <input type="text"  readonly  id="i"  name="i" value="{$list.i|default=''}"  placeholder="请输入扣分详情" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">不合格照片</label>
        <div class="layui-input-block">
            <div class="layui-upload" style="padding-left: 30px;">
                <div class="layui-upload-list">
                    <table class="layui-table">
                        <thead>
                        <tr><th>文件名</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr></thead>
                        <tbody id="file6">
                        <?php if(!empty($file6)){
                            foreach($file6 as $k=>$v){

                                echo'
                                        <tr>
                                            <td><a href=/public/'.$v["images"].' target="_blank"><img src=/public/'.$v["images"].' /></a></td>
                                            <td>已上传</td>
                                        </tr>
                                        ';

                            }
                            ?>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">客户登记</label>
        <div class="layui-input-inline">
            <input type="text"  readonly  id="j"  name="j" value="{$list.j|default=''}"  placeholder="请输入扣分详情" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">不合格照片</label>
        <div class="layui-input-block">
            <div class="layui-upload" style="padding-left: 30px;">
                <div class="layui-upload-list">
                    <table class="layui-table">
                        <thead>
                        <tr><th>文件名</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr></thead>
                        <tbody id="file7">
                        <?php if(!empty($file7)){
                            foreach($file7 as $k=>$v){

                                echo'
                                        <tr>
                                            <td><a href=/public/'.$v["images"].' target="_blank"><img src=/public/'.$v["images"].' /></a></td>
                                            <td>已上传</td>
                                        </tr>
                                        ';

                            }
                            ?>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">数据录入</label>
        <div class="layui-input-inline">
            <input type="text"  readonly  id="k"  name="k" value="{$list.k|default=''}"  placeholder="请输入扣分详情" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">不合格照片</label>
        <div class="layui-input-block">
            <div class="layui-upload" style="padding-left: 30px;">
                <div class="layui-upload-list">
                    <table class="layui-table">
                        <thead>
                        <tr><th>文件名</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr></thead>
                        <tbody id="file8">
                        <?php if(!empty($file8)){
                            foreach($file8 as $k=>$v){

                                echo'
                                        <tr>
                                            <td><a href=/public/'.$v["images"].' target="_blank"><img src=/public/'.$v["images"].' /></a></td>
                                            <td>已上传</td>
                                        </tr>
                                        ';

                            }
                            ?>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label"> 录音手环 </label>
        <div class="layui-input-inline">
            <input type="text" readonly   id="l"  name="l" value="{$list.l|default=''}"  placeholder="请输入扣分详情" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">不合格照片</label>
        <div class="layui-input-block">
            <div class="layui-upload" style="padding-left: 30px;">
                <div class="layui-upload-list">
                    <table class="layui-table">
                        <thead>
                        <tr><th>文件名</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr></thead>
                        <tbody id="file9">
                        <?php if(!empty($file9)){
                            foreach($file9 as $k=>$v){

                                echo'
                                        <tr>
                                            <td><a href=/public/'.$v["images"].' target="_blank"><img src=/public/'.$v["images"].' /></a></td>
                                            <td>已上传</td>
                                        </tr>
                                        ';

                            }
                            ?>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">六大文件夹</label>
        <div class="layui-input-inline">
            <input type="text"  readonly  id="m"  name="m" value="{$list.m|default=''}"  placeholder="请输入扣分详情" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">不合格照片</label>
        <div class="layui-input-block">
            <div class="layui-upload" style="padding-left: 30px;">
                <div class="layui-upload-list">
                    <table class="layui-table">
                        <thead>
                        <tr><th>文件名</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr></thead>
                        <tbody id="file10">
                        <?php if(!empty($file10)){
                            foreach($file10 as $k=>$v){

                                echo'
                                        <tr>
                                            <td><a href=/public/'.$v["images"].' target="_blank"><img src=/public/'.$v["images"].' /></a></td>
                                            <td>已上传</td>
                                        </tr>
                                        ';

                            }
                            ?>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">团队沟通</label>
        <div class="layui-input-inline">
            <input type="text"  readonly  id="n"  name="n" value="{$list.n|default=''}"  placeholder="请输入扣分详情" class="layui-input">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">不合格照片</label>
        <div class="layui-input-block">
            <div class="layui-upload" style="padding-left: 30px;">
                <div class="layui-upload-list">
                    <table class="layui-table">
                        <thead>
                        <tr><th>文件名</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr></thead>
                        <tbody id="file11">
                        <?php if(!empty($file11)){
                            foreach($file11 as $k=>$v){

                                echo'
                                        <tr>
                                            <td><a href=/public/'.$v["images"].' target="_blank"><img src=/public/'.$v["images"].' /></a></td>
                                            <td>已上传</td>
                                        </tr>
                                        ';

                            }
                            ?>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">400投诉</label>
        <div class="layui-input-inline">
            <input type="text"  readonly  id="p"  name="p" value="{$list.p|default=''}"  placeholder="请输入扣分详情" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">不合格照片</label>
        <div class="layui-input-block">
            <div class="layui-upload" style="padding-left: 30px;">
                <div class="layui-upload-list">
                    <table class="layui-table">
                        <thead>
                        <tr><th>文件名</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr></thead>
                        <tbody id="file12">
                        <?php if(!empty($file12)){
                            foreach($file12 as $k=>$v){

                                echo'
                                        <tr>
                                            <td><a href=/public/'.$v["images"].' target="_blank"><img src=/public/'.$v["images"].' /></a></td>
                                            <td>已上传</td>
                                        </tr>
                                        ';

                            }
                            ?>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">巡盘时间</label>
        <div class="layui-input-inline">
            <input type="text" readonly  readonly  id=""  name="enquirytime" value="{$list.enquirytime|default=''}"  placeholder="请输入巡盘时间" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">合格照片</label>
        <div class="layui-input-block">
            <div class="layui-upload" style="padding-left: 30px;">
                <div class="layui-upload-list">
                    <table class="layui-table">
                        <thead>
                        <tr><th>文件名</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr></thead>
                        <tbody id="file16">
                        <?php if(!empty($file16)){
                            foreach($file16 as $k=>$v){

                                echo'
                                        <tr>
                                            <td><a href=/public/'.$v["images"].' target="_blank"><img src=/public/'.$v["images"].' /></a></td>
                                            <td>已上传</td>
                                        </tr>
                                        ';

                            }
                            ?>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="layui-form-item layui-form-text">
        <label class="layui-form-label">备注</label>
        <div class="layui-input-block">
            <textarea readonly placeholder="请输入内容" class="layui-textarea" name="mark" style="width:80%">{$list.mark|default=''}</textarea>
        </div>
    </div>
</form>
<script src="/public/layui/layui.js" charset="utf-8"></script>
<script>
    layui.use('upload', function() {
        var $ = layui.jquery
            , upload = layui.upload;






        //多文件列表first
        var qualified = $('#qualified')
            ,uploadListIns = upload.render({
                elem: '#upload_img'
                ,url: '/rackstage/index/uploads?mark=enquiry&reserve=qualified&times='+{$times}+'&updatetime='+{$nowtime}
                ,multiple: true
                ,size: 10240
                ,auto: false
                ,bindAction: '#qualifiedAction'
                ,choose: function(obj){
                    var files = this.files = obj.pushFile(); //将每次选择的文件追加到文件队列
                    //读取本地文件
                    obj.preview(function(index, file, result){
                        var tr = $(['<tr id="upload-'+ index +'">'
                            ,'<td><img src='+ result +' title='+ file.name +' class="layui-upload-img"></td>'
                            //,'<td>'+ (file.size/1014).toFixed(1) +'kb</td>'
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

                        qualified.append(tr);
                    });
                }
                ,done: function(res, index, upload){
                    if(res.code == 0){ //上传成功
                        var tr = qualified.find('tr#upload-'+ index)
                            ,tds = tr.children();
                        tds.eq(1).html('<span style="color: #5FB878;">上传成功</span>');
                        tds.eq(2).html(''); //清空操作
                        return delete this.files[index]; //删除文件队列已经上传成功的文件
                    }
                    this.error(index, upload);
                }
                ,error: function(index, upload){
                    var tr = qualified.find('tr#upload-'+ index)
                        ,tds = tr.children();
                    tds.eq(1).html('<span style="color: #FF5722;">上传失败</span>');
                    tds.eq(2).find('.demo-reload').removeClass('layui-hide'); //显示重传
                }
            });
        //多文件上传second
        var Unqualified = $('#Unqualified')
            ,uploadListNO = upload.render({
                elem: '#upload_imgUn'
                ,url: '/rackstage/index/uploads?mark=enquiry&reserve=Unqualified&times='+{$times}+'&updatetime='+{$nowtime}
                ,multiple: true
                ,size: 10240
                ,auto: false
                ,bindAction: '#UnqualifiedAction'
                ,choose: function(obj){
                    var files = this.files = obj.pushFile(); //将每次选择的文件追加到文件队列
                    //读取本地文件
                    obj.preview(function(index, file, result){
                        var tr = $(['<tr id="upload-'+ index +'">'
                            ,'<td><img src='+ result +' title='+ file.name +' class="layui-upload-img"></td>'
                            //,'<td>'+ (file.size/1014).toFixed(1) +'kb</td>'
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
                            uploadListNO.config.elem.next()[0].value = ''; //清空 input file 值，以免删除后出现同名文件不可选
                        });

                        Unqualified.append(tr);
                    });
                }
                ,done: function(res, index, upload){
                    if(res.code == 0){ //上传成功
                        var tr = Unqualified.find('tr#upload-'+ index)
                            ,tds = tr.children();
                        tds.eq(1).html('<span style="color: #5FB878;">上传成功</span>');
                        tds.eq(2).html(''); //清空操作
                        return delete this.files[index]; //删除文件队列已经上传成功的文件
                    }
                    this.error(index, upload);
                }
                ,error: function(index, upload){
                    var tr = Unqualified.find('tr#upload-'+ index)
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
        //监听select  end
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
            if($('#search_text').val()==""){ layer.alert($('#search_text').attr('placeholder'));  return false;};
            if($('#search_text').val().indexOf("--") == '-1'){ layer.alert($('#search_text').attr('placeholder'));  return false;};
            // if($('#types').val()==""){ layer.alert($('#types').attr('placeholder'));  return false;};
            // if($('#levels').val()==""){ layer.alert($('#levels').attr('placeholder'));  return false;};
            // if($('#classtime').val()==""){ layer.alert($('#classtime').attr('placeholder'));  return false;};
            // if($('#classnum').val()==""){ layer.alert($('#classnum').attr('placeholder'));  return false;};


            return true;

        }



        //所属项目开始
        form.on('select(department)', function(data){
            console.log(data.value)
            $.ajax({
                url: "/rackstage/Personnel/getProject" ,
                data: {'pid':data.value} ,
                type: "get" ,
                dataType:'json',
                success:function(data){
                    console.log(data);


                    if(data==''){
                        layer.msg('暂无项目', {icon:0});

                        //return false;
                    }else{
                        //下拉搜索start
                        //测试用的数据，这里可以用AJAX获取服务器数据
                        var arr=new Array(); ;
                        for(var i = 0; i < data.length; i++){
                            arr[i]=data[i].id+'--'+data[i].name;
                        }
                        var test_list = arr;
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
                        //下拉搜索end
                    }

                }
            })
        });

    })

</script>
</body>
</html>