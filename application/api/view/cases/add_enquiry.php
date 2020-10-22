<!DOCTYPE html>
<html style="background-color: rgb(255, 255, 255); font-size: 48px;">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="wap-font-scale" content="no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>周报详情</title>
    <link type="text/css" rel="stylesheet" href="/public/api/css/style.css">
    <script src="https://cdn.bootcdn.net/ajax/libs/jquery/3.5.1/jquery.js"></script>
    <link rel="stylesheet" href="/public/api/css/pandastar.css">
    <link type="text/css" rel="stylesheet" href="/public/api/css/top.css">
    <link rel="stylesheet" type="text/css" href="/public/api/LCalendar/css/index.css" />
    <link rel="stylesheet" type="text/css" href="/public/api/LCalendar/css/LCalendar.css" />
    <script type="text/javascript" src="/public/layui/layui.js"></script>
    <link rel="stylesheet" href="/public/layui/css/layui.css" type="text/css">
</head>
<body>
<style>
    .fen{
        text-align:center;
        color:red;
    }
</style>
<style>
    * {
        margin: 0;
        padding: 0;
    }
    /*图片上传*/

    html,
    body {
        width: 100%;
        height: 100%;
    }

    .container {
        width: 100%;
        height: 100%;
        overflow: auto;
        clear: both;
    }



    #z_photo img {
        width: 1rem;
        height: 1rem;
    }

    .z_addImg {
        float: left;
    }

    #z_file {
        width: 1rem;
        height: 1rem;
        background: url("/public/api/images/z_add.png") no-repeat;
        background-size: 100% 100%;
        float: left;
        margin-right: 0.2rem;
    }

    #z_file input::-webkit-file-upload-button {
        width: 1rem;
        height: 1rem;
        border: none;
        position: absolute;
        outline: 0;
        opacity: 0;
    }

    #z_file input#file {
        display: block;
        width: auto;
        border: 0;
        vertical-align: middle;
    }
    /*遮罩层*/

    #z_mask {
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, .5);
        position: fixed;
        top: 0;
        left: 0;
        z-index: 999;
        display: none;
    }

    #z_alert {
        width: 3rem;
        height: 2rem;
        border-radius: .2rem;
        background: #fff;
        font-size: .24rem;
        text-align: center;
        position: absolute;
        left: 50%;
        top: 50%;
        margin-left: -1.5rem;
        margin-top: -2rem;
    }
    #z_alert p:nth-child(1) {
        line-height: 1.5rem;
    }

    #z_alert p:nth-child(2) span {
        display: inline-block;
        width: 49%;
        height: .5rem;
        line-height: .5rem;
        float: left;
        border-top: 1px solid #ddd;
    }
    #z_cancel {
        border-right: 1px solid #ddd;
    }

</style>
<section class="aui-flexView">
    <div class="header">
        <div class="box">
            <div class="L"><a onClick="javascript:history.back(-1)" class="goback"><i class="go-left"></i></a></div>
            <div class="C"><p>添加询盘</p></div>
            {notempty name="isAdd"}
            <div class="R" style="position: absolute;right: 10px;top: 0;color: #fff;line-height: 39px;" id="add"><p>添加询盘</p></div>
            {/notempty}

        </div>
    </div>
    <form class="layui-form" action="" id="formid"  style="margin-top: 40px;">
        <div class="lecture-art">
            <table width="94.5%" border="0" cellspacing="0" cellpadding="0" id="grid">
                <tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='30%' style='font-weight:bold;'>打分名称</td>
                    <td  style="text-align:center">分数</td>
                    <td  style="text-align:center">不合格图片</td>
                </tr>
                <tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='40%' style='font-weight:bold;'>地区</td>
                    <td  class="fen">
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
                    </td>
                    <td class="fen"></td>
                </tr>
                <tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='30%' style='font-weight:bold;'>部门</td>
                    <td  class="fen">
                        <select id="department" name="department" lay-filter="department">
                            <option></option>
                            {notempty name="list.department"}
                            <option value="{$list.department}" selected>{$list.department_name}</option>
                            {/notempty}
                        </select>
                    </td>
                    <td  class="fen"></td>

                </tr>
                <tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='30%' style='font-weight:bold;'>项目</td>
                    <td  class="fen">
                        <select name="project_id" id="city" lay-verify="required" lay-search="">
                            <option value="">直接选择或搜索选择</option>
                        </select>
                    </td>
                    <td  class="fen"></td>
                </tr><tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='30%' style='font-weight:bold;'>项目经理</td>
                    <td  class="fen">
                        <input type="text"  id="manager"  name="manager" value="{$list.manager|default=''}"  placeholder=" 项目经理" class="layui-input">
                    </td>
                    <td  class="fen"></td>
                </tr><tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='30%' style='font-weight:bold;'>得分</td>
                    <td  class="fen">
                        <input type="text"  id="score"  name="score" value="{$list.score|default=''}"  placeholder=" 得分" class="layui-input">

                    </td>
                    <td  class="fen"></td>
                </tr><tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='30%' style='font-weight:bold;'>等级</td>
                    <td  class="fen">
                        <select id="levels" name="levels">
                            <option></option>
                            {notempty name="list.levels"}
                            <option value="优秀" {if condition="$list.levels eq '优秀'"}selected{/if}>优秀</option>
                            <option value="合格" {if condition="$list.levels eq '合格'"}selected{/if}>合格</option>
                            <option value="不合格" {if condition="$list.levels eq '不合格'"}selected{/if}>不合格</option>
                            {else /}
                            <option value="优秀">优秀</option>
                            <option value="合格">合格</option>
                            <option value="不合格">不合格</option>
                            {/notempty}

                        </select>
                    </td>
                    <td  class="fen"></td>
                </tr><tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='30%' style='font-weight:bold;'>考勤纪律</td>
                    <td  class="fen">
                        <input type="text"  id="a"  name="a" value="{$list.a|default=''}"  placeholder=" 扣分详情" class="layui-input">

                    </td>
                    <td  class="fen">
                        <div class="z_photo" id="z_photo">
                            <div class="z_file" id="z_file">
                                <input type="file" name="file" id="file" value="" accept="image/*" multiple onchange="imgChanges('z_photo','z_file','file');" />
                            </div>
                        </div>
                    </td>
                </tr><tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='30%' style='font-weight:bold;'>仪容仪表</td>
                    <td  class="fen">
                        <input type="text"  id="b"  name="b" value="{$list.b|default=''}"  placeholder=" 扣分详情" class="layui-input">

                    </td>
                    <td  class="fen">
                        <div class="z_photo1" id="z_photo">
                            <div class="z_file1" id="z_file">
                                <input type="file" name="file" id="file1" value="" accept="image/*" multiple onchange="imgChanges('z_photo1','z_file1','file1');" />
                            </div>
                        </div>
                    </td>
                </tr><tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='30%' style='font-weight:bold;'>行为规范</td>
                    <td  class="fen">
                        <input type="text"  id="c"  name="c" value="{$list.c|default=''}"  placeholder=" 扣分详情" class="layui-input">

                    </td>
                    <td  class="fen">
                        <div class="z_photo2" id="z_photo">
                            <div class="z_file2" id="z_file">
                                <input type="file" name="file" id="file2" value="" accept="image/*" multiple onchange="imgChanges('z_photo2','z_file2','file2');" />
                            </div>
                        </div>
                    </td>
                </tr><tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='30%' style='font-weight:bold;'>团队激励</td>
                    <td  class="fen">
                        <input type="text"  id="d"  name="d" value="{$list.d|default=''}"  placeholder=" 扣分详情" class="layui-input">

                    </td>
                    <td  class="fen">
                        <div class="z_photo3" id="z_photo">
                            <div class="z_file3" id="z_file">
                                <input type="file" name="file" id="file3" value="" accept="image/*" multiple onchange="imgChanges('z_photo3','z_file3','file3');" />
                            </div>
                        </div>
                    </td>
                </tr><tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='30%' style='font-weight:bold;'>会议组织</td>
                    <td  class="fen">
                        <input type="text"  id="f"  name="f" value="{$list.f|default=''}"  placeholder=" 扣分详情" class="layui-input">

                    </td>
                    <td  class="fen">
                        <div class="z_photo4" id="z_photo">
                            <div class="z_file4" id="z_file">
                                <input type="file" name="file" id="file4" value="" accept="image/*" multiple onchange="imgChanges('z_photo4','z_file4','file4');" />
                            </div>
                        </div>
                    </td>
                </tr><tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='30%' style='font-weight:bold;'>电话接听</td>
                    <td  class="fen">
                        <input type="text"  id="h"  name="h" value="{$list.h|default=''}"  placeholder=" 扣分详情" class="layui-input">

                    </td>
                    <td  class="fen">
                        <div class="z_photo5" id="z_photo">
                            <div class="z_file5" id="z_file">
                                <input type="file" name="file" id="file5" value="" accept="image/*" multiple onchange="imgChanges('z_photo5','z_file5','file5');" />
                            </div>
                        </div>
                    </td>
                </tr><tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='30%' style='font-weight:bold;'>小客户回访</td>
                    <td  class="fen">
                        <input type="text"  id="i"  name="i" value="{$list.i|default=''}"  placeholder=" 扣分详情" class="layui-input">
                    </td>
                    <td  class="fen">
                        <div class="z_photo6" id="z_photo">
                            <div class="z_file6" id="z_file">
                                <input type="file" name="file" id="file6" value="" accept="image/*" multiple onchange="imgChanges('z_photo6','z_file6','file6');" />
                            </div>
                        </div>
                    </td>
                </tr><tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='30%' style='font-weight:bold;'>客户登记</td>
                    <td  class="fen">
                        <input type="text"  id="j"  name="j" value="{$list.j|default=''}"  placeholder=" 扣分详情" class="layui-input">

                    </td>
                    <td  class="fen">
                        <div class="z_photo7" id="z_photo">
                            <div class="z_file7" id="z_file">
                                <input type="file" name="file" id="file7" value="" accept="image/*" multiple onchange="imgChanges('z_photo7','z_file7','file7');" />
                            </div>
                        </div>
                    </td>
                </tr><tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='30%' style='font-weight:bold;'>数据录入</td>
                    <td  class="fen">
                        <input type="text"  id="k"  name="k" value="{$list.k|default=''}"  placeholder=" 扣分详情" class="layui-input">

                    </td>
                    <td  class="fen">
                        <div class="z_photo8" id="z_photo">
                            <div class="z_file8" id="z_file">
                                <input type="file" name="file" id="file8" value="" accept="image/*" multiple onchange="imgChanges('z_photo8','z_file8','file8');" />
                            </div>
                        </div>
                    </td>
                </tr><tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='30%' style='font-weight:bold;'>录音手环</td>
                    <td  class="fen">
                        <input type="text"  id="l"  name="l" value="{$list.l|default=''}"  placeholder=" 扣分详情" class="layui-input">
                        </td>
                    <td  class="fen">
                        <div class="z_photo9" id="z_photo">
                            <div class="z_file9" id="z_file">
                                <input type="file" name="file" id="file9" value="" accept="image/*" multiple onchange="imgChanges('z_photo9','z_file9','file9');" />
                            </div>
                        </div>
                    </td>
                </tr><tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='30%' style='font-weight:bold;'>六大文件夹</td>
                    <td  class="fen" style="width:30%">
                        <input type="text"  id="m"  name="m" value="{$list.m|default=''}"  placeholder=" 扣分详情" class="layui-input">

                    </td>
                    <td  class="fen">
                        <div class="z_photo10" id="z_photo">
                            <div class="z_file10" id="z_file">
                                <input type="file" name="file" id="file10" value="" accept="image/*" multiple onchange="imgChanges('z_photo10','z_file10','file10');" />
                            </div>
                        </div>
                    </td>
                </tr><tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='30%' style='font-weight:bold;'>团队沟通</td>
                    <td  class="fen">
                        <input type="text"  id="n"  name="n" value="{$list.n|default=''}"  placeholder=" 扣分详情" class="layui-input">
                        <input type="hidden" name="times" value="{$nowtime}"/>

                    </td>
                    <td  class="fen">
                        <div class="z_photo11" id="z_photo">
                            <div class="z_file11" id="z_file">
                                <input type="file" name="file" id="file11" value="" accept="image/*" multiple onchange="imgChanges('z_photo11','z_file11','file11');" />
                            </div>
                        </div>
                    </td>
                </tr>
                <tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='30%' style='font-weight:bold;'>400投诉</td>
                    <td  class="fen">
                        <input type="text"  id="p"  name="p" value="{$list.p|default=''}"  placeholder=" 扣分详情" class="layui-input">

                    </td>
                    <td  class="fen">
                        <div class="z_photo12" id="z_photo">
                            <div class="z_file12" id="z_file">
                                <input type="file" name="file" id="file12" value="" accept="image/*" multiple onchange="imgChanges('z_photo12','z_file12','file12');" />
                            </div>
                        </div>
                    </td>
                </tr>
                <tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='30%' style='font-weight:bold;'>备注</td>
                    <td  >
                        <textarea placeholder=" 内容" class="layui-textarea" name="mark" style="width:100%">{$list.mark|default=''}</textarea>

                    </td>
                    <td  ></td>
                </tr>
                <tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='40%' style='font-weight:bold;'>询盘时间</td>
                    <td  class="fen">
                        <input type="text"  id="enquirytime"  name="enquirytime" value="{$list.enquirytime|default=''}"  placeholder=" 巡盘时间" class="layui-input">
                    </td>
                    <td></td>
                </tr>
                <tr style="background-color: rgb(245, 245, 245);">
                    <td align="left" valign="middle" width='30%' style='font-weight:bold;'>合格照片</td>
                    <td  class="fen">
                    </td>
                    <td  class="fen">
                        <div class="z_photo16" id="z_photo">
                            <div class="z_file16" id="z_file">
                                <input type="file" name="file" id="file16" value="" accept="image/*" multiple onchange="imgChanges('z_photo16','z_file16','file16');" />
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button type="submit" class="layui-btn" lay-submit="" lay-filter="demo1">立即提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
        </form>
    </section>
</body>

<script type="text/javascript">

    function imgChanges(obj1, obj2, obj3) {
        var file = document.getElementById(obj3);
        var imgContainer = document.getElementsByClassName(obj1)[0];
        var fileList = file.files;
        var input = document.getElementsByClassName(obj2)[0];
        var imgArr = [];
        for (var i = 0; i < fileList.length; i++) {
            var imgUrl = window.URL.createObjectURL(file.files[i]);
            imgArr.push(imgUrl);
            var img = document.createElement("img");
            img.setAttribute("src", imgArr[i]);
            var imgAdd = document.createElement("div1");
            imgAdd.setAttribute("class", "z_addImg");
            imgAdd.appendChild(img);
            imgContainer.appendChild(imgAdd);
        };
        submits(fileList,obj3);
    };
    function submits(imgList,obj3) {
        var imgLists = []
        var formData = new FormData();
        for (var i = 0; i < imgList.length; i++) {
            imgLists.push(imgList[i])
            formData.append('files', imgLists[i])
        }
        $.ajax({
            type : 'post',
            url : 'upload1', // 上传图片的接口地址
            data : formData,
            headers: {
                'token':{$time},
                'type':obj3
            },
            cache : false,
            processData : false, // 不处理发送的数据，因为data值是Formdata对象，不需要对数据做处理
            contentType : false, // 不设置Content-type请求头
            success : function(response){
                alert("上传成功");
            },
            error : function(){ }
        });
    }

    layui.use(['laydate','layer', 'form','element','jquery','upload'], function() {
        var layer = layui.layer
            , $ = layui.jquery
            , form = layui.form
            , upload = layui.upload
            ,laydate = layui.laydate;
        laydate.render({
            elem: '#enquirytime'
            , trigger: 'click'
        });
        upload.render({
            elem: '#test6'
            ,url: "uploads?mark=answercall&reserve=mp3&times={$nowtime}&updatetime={$nowtime}" //改成您自己的上传接口
            ,accept: 'audio' //音频
            ,done: function(res){
                layer.msg('上传成功');
                console.log(res)
            }
        });

        form.on('submit(demo1)', function(data){

            $.ajax({
                url: "addEnquiry" ,
                data: $("#formid").serialize(),
                type: "post" ,
                dataType:'json',
                success:function(data){
                    layer.msg('添加成功',function(){
                        location.href="Enquiry";
                    })
                }
            })
            return false;
        });

        laydate.render({
            elem: '#enquirytime'
            , trigger: 'click'
        });
        form.on('select(region)', function(data){
            $.ajax({
                url: "getCate" ,
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

        form.on('select(department)', function(data){
            console.log(data.value)
            $.ajax({
                url: "getProject" ,
                data: {'pid':data.value} ,
                type: "get" ,
                dataType:'json',
                success:function(data){
                    $("#city").empty();
                    $("#city").append("<option value=''>请选择</option>");//新增
                    for(var i = 0; i < data.length; i++){
                        $("#city").append("<option value='"+data[i].id+"'>"+data[i].name+"</option>");//新增
                    }
                    form.render('select');
                }
            })
        });
    })

</script>


{include file="layouts/footer" /}
