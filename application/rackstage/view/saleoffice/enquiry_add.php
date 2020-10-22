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
                <option value="{$vo.id}" {if condition="isset($list)&&$list.region eq $vo.id"} selected {/if}>{$vo.name}</option>
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
        
    </div>


    <div class="layui-form-item">
        <label class="layui-form-label">项目经理</label>
        <div class="layui-input-inline">
            <input type="text"  id="manager"  name="manager" value="{$list.manager|default=''}"  placeholder="请输入项目经理" class="layui-input">
        </div>
    </div>
     <div class="layui-form-item">
        <label class="layui-form-label">巡盘时间</label>
        <div class="layui-input-inline">
            <input type="text"  id="enquirytime"  autocomplete="off" name="enquirytime" value="{$list.enquirytime|default=''}"  placeholder="请输入巡盘时间" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">得分</label>
        <div class="layui-input-inline">
            <input type="text"  id="score"  name="score" value="{$list.score|default=''}"  placeholder="请输入得分" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">等级</label>
        <div class="layui-input-inline">
            <select id="levels" name="levels" id="levels">
                <option value=''>请选择等级</option>
                {notempty name="list.levels"}
                <option value="优秀" {if condition="$list.levels eq '优秀'"}selected{/if}>优秀</option>
                <option value="合格" {if condition="$list.levels eq '合格'"}selected{/if}>合格</option>
                <option value="不合格" {if condition="$list.levels eq '不合格'"}selected{/if}>不合格</option>
                {else /}
                <option value="优秀" >优秀</option>
                <option value="合格">合格</option>
                <option value="不合格">不合格</option>
                {/notempty}

            </select>
        </div>
    </div>




    <div class="layui-form-item">
        <label class="layui-form-label"> 考勤纪律</label>
        <div class="layui-input-inline">
            <input type="text"  id="a"  name="a" value="{$list.a|default=''}"  placeholder="请输入扣分详情" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">不合格照片</label>
        <div class="layui-input-block">
            <div class="layui-upload" style="padding-left: 30px;">
                <button type="button" class="layui-btn layui-btn-normal" id="fileList">请选择文件</button>
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
                                            <td><span class="layui-btn layui-btn-xs layui-btn-danger del_uploads" indexs="'.$v["id"].'">删除</span></td>
                                        </tr>
                                        ';

                            }
                            ?>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
                <button type="button" class="layui-btn" id="fileAction">开始上传</button>
            </div>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label"> 仪容仪表 </label>
        <div class="layui-input-inline">
            <input type="text"  id="b"  name="b" value="{$list.b|default=''}"  placeholder="请输入扣分详情" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">不合格照片</label>
        <div class="layui-input-block">
            <div class="layui-upload" style="padding-left: 30px;">
                <button type="button" class="layui-btn layui-btn-normal" id="fileList1">请选择文件</button>
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
                                            <td><span class="layui-btn layui-btn-xs layui-btn-danger del_uploads" indexs="'.$v["id"].'">删除</span></td>
                                        </tr>
                                        ';

                            }
                            ?>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
                <button type="button" class="layui-btn" id="file1Action">开始上传</button>
            </div>
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label"> 行为规范 </label>
        <div class="layui-input-inline">
            <input type="text"  id="c"  name="c" value="{$list.c|default=''}"  placeholder="请输入扣分详情" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">不合格照片</label>
        <div class="layui-input-block">
            <div class="layui-upload" style="padding-left: 30px;">
                <button type="button" class="layui-btn layui-btn-normal" id="fileList2">请选择文件</button>
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
                                            <td><span class="layui-btn layui-btn-xs layui-btn-danger del_uploads" indexs="'.$v["id"].'">删除</span></td>
                                        </tr>
                                        ';

                            }
                            ?>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
                <button type="button" class="layui-btn" id="file2Action">开始上传</button>
            </div>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label"> 团队激励  </label>
        <div class="layui-input-inline">
            <input type="text"  id="d"  name="d" value="{$list.d|default=''}"  placeholder="请输入扣分详情" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">不合格照片</label>
        <div class="layui-input-block">
            <div class="layui-upload" style="padding-left: 30px;">
                <button type="button" class="layui-btn layui-btn-normal" id="fileList3">请选择文件</button>
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
                                            <td><span class="layui-btn layui-btn-xs layui-btn-danger del_uploads" indexs="'.$v["id"].'">删除</span></td>
                                        </tr>
                                        ';

                            }
                            ?>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
                <button type="button" class="layui-btn" id="file3Action">开始上传</button>
            </div>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label"> 公共区域维护 </label>
        <div class="layui-input-inline">
            <input type="text"  id="e"  name="e" value="{$list.e|default=''}"  placeholder="请输入扣分详情" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">不合格照片</label>
        <div class="layui-input-block">
            <div class="layui-upload" style="padding-left: 30px;">
                <button type="button" class="layui-btn layui-btn-normal" id="fileList13">请选择文件</button>
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
                                            <td><span class="layui-btn layui-btn-xs layui-btn-danger del_uploads" indexs="'.$v["id"].'">删除</span></td>
                                        </tr>
                                        ';

                            }
                            ?>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
                <button type="button" class="layui-btn" id="file13Action">开始上传</button>
            </div>
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label"> 会议组织 </label>
        <div class="layui-input-inline">
            <input type="text"  id="f"  name="f" value="{$list.f|default=''}"  placeholder="请输入扣分详情" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">不合格照片</label>
        <div class="layui-input-block">
            <div class="layui-upload" style="padding-left: 30px;">
                <button type="button" class="layui-btn layui-btn-normal" id="fileList4">请选择文件</button>
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
                                            <td><span class="layui-btn layui-btn-xs layui-btn-danger del_uploads" indexs="'.$v["id"].'">删除</span></td>
                                        </tr>
                                        ';

                            }
                            ?>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
                <button type="button" class="layui-btn" id="file4Action">开始上传</button>
            </div>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label"> 接待流程  </label>
        <div class="layui-input-inline">
            <input type="text"  id="g"  name="g" value="{$list.g|default=''}"  placeholder="请输入扣分详情" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">不合格照片</label>
        <div class="layui-input-block">
            <div class="layui-upload" style="padding-left: 30px;">
                <button type="button" class="layui-btn layui-btn-normal" id="fileList14">请选择文件</button>
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
                                            <td><span class="layui-btn layui-btn-xs layui-btn-danger del_uploads" indexs="'.$v["id"].'">删除</span></td>
                                        </tr>
                                        ';

                            }
                            ?>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
                <button type="button" class="layui-btn" id="file14Action">开始上传</button>
            </div>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label"> 电话接听 </label>
        <div class="layui-input-inline">
            <input type="text"  id="h"  name="h" value="{$list.h|default=''}"  placeholder="请输入扣分详情" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">不合格照片</label>
        <div class="layui-input-block">
            <div class="layui-upload" style="padding-left: 30px;">
                <button type="button" class="layui-btn layui-btn-normal" id="fileList5">请选择文件</button>
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
                                            <td><span class="layui-btn layui-btn-xs layui-btn-danger del_uploads" indexs="'.$v["id"].'">删除</span></td>
                                        </tr>
                                        ';

                            }
                            ?>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
                <button type="button" class="layui-btn" id="file5Action">开始上传</button>
            </div>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label"> 小客户回访   </label>
        <div class="layui-input-inline">
            <input type="text"  id="i"  name="i" value="{$list.i|default=''}"  placeholder="请输入扣分详情" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">不合格照片</label>
        <div class="layui-input-block">
            <div class="layui-upload" style="padding-left: 30px;">
                <button type="button" class="layui-btn layui-btn-normal" id="fileList6">请选择文件</button>
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
                                            <td><span class="layui-btn layui-btn-xs layui-btn-danger del_uploads" indexs="'.$v["id"].'">删除</span></td>
                                        </tr>
                                        ';

                            }
                            ?>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
                <button type="button" class="layui-btn" id="file6Action">开始上传</button>
            </div>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">客户登记</label>
        <div class="layui-input-inline">
            <input type="text"  id="j"  name="j" value="{$list.j|default=''}"  placeholder="请输入扣分详情" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">不合格照片</label>
        <div class="layui-input-block">
            <div class="layui-upload" style="padding-left: 30px;">
                <button type="button" class="layui-btn layui-btn-normal" id="fileList7">请选择文件</button>
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
                                            <td><span class="layui-btn layui-btn-xs layui-btn-danger del_uploads" indexs="'.$v["id"].'">删除</span></td>
                                        </tr>
                                        ';

                            }
                            ?>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
                <button type="button" class="layui-btn" id="file7Action">开始上传</button>
            </div>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">数据录入</label>
        <div class="layui-input-inline">
            <input type="text"  id="k"  name="k" value="{$list.k|default=''}"  placeholder="请输入扣分详情" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">不合格照片</label>
        <div class="layui-input-block">
            <div class="layui-upload" style="padding-left: 30px;">
                <button type="button" class="layui-btn layui-btn-normal" id="fileList8">请选择文件</button>
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
                                            <td><span class="layui-btn layui-btn-xs layui-btn-danger del_uploads" indexs="'.$v["id"].'">删除</span></td>
                                        </tr>
                                        ';

                            }
                            ?>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
                <button type="button" class="layui-btn" id="file8Action">开始上传</button>
            </div>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label"> 录音手环 </label>
        <div class="layui-input-inline">
            <input type="text"  id="l"  name="l" value="{$list.l|default=''}"  placeholder="请输入扣分详情" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">不合格照片</label>
        <div class="layui-input-block">
            <div class="layui-upload" style="padding-left: 30px;">
                <button type="button" class="layui-btn layui-btn-normal" id="fileList9">请选择文件</button>
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
                                            <td><span class="layui-btn layui-btn-xs layui-btn-danger del_uploads" indexs="'.$v["id"].'">删除</span></td>
                                        </tr>
                                        ';

                            }
                            ?>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
                <button type="button" class="layui-btn" id="file9Action">开始上传</button>
            </div>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">六大文件夹</label>
        <div class="layui-input-inline">
            <input type="text"  id="m"  name="m" value="{$list.m|default=''}"  placeholder="请输入扣分详情" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">不合格照片</label>
        <div class="layui-input-block">
            <div class="layui-upload" style="padding-left: 30px;">
                <button type="button" class="layui-btn layui-btn-normal" id="fileList10">请选择文件</button>
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
                                            <td><span class="layui-btn layui-btn-xs layui-btn-danger del_uploads" indexs="'.$v["id"].'">删除</span></td>
                                        </tr>
                                        ';

                            }
                            ?>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
                <button type="button" class="layui-btn" id="file10Action">开始上传</button>
            </div>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">团队沟通</label>
        <div class="layui-input-inline">
            <input type="text"  id="n"  name="n" value="{$list.n|default=''}"  placeholder="请输入扣分详情" class="layui-input">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">不合格照片</label>
        <div class="layui-input-block">
            <div class="layui-upload" style="padding-left: 30px;">
                <button type="button" class="layui-btn layui-btn-normal" id="fileList11">请选择文件</button>
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
                                            <td><span class="layui-btn layui-btn-xs layui-btn-danger del_uploads" indexs="'.$v["id"].'">删除</span></td>
                                        </tr>
                                        ';

                            }
                            ?>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
                <button type="button" class="layui-btn" id="file11Action">开始上传</button>
            </div>
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">400投诉</label>
        <div class="layui-input-inline">
            <input type="text"  id="p"  name="p" value="{$list.p|default=''}"  placeholder="请输入扣分详情" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">不合格照片</label>
        <div class="layui-input-block">
            <div class="layui-upload" style="padding-left: 30px;">
                <button type="button" class="layui-btn layui-btn-normal" id="fileList12">请选择文件</button>
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
                                            <td><span class="layui-btn layui-btn-xs layui-btn-danger del_uploads" indexs="'.$v["id"].'">删除</span></td>
                                        </tr>
                                        ';

                            }
                            ?>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
                <button type="button" class="layui-btn" id="file12Action">开始上传</button>
            </div>
        </div>
    </div>


   
    <div class="layui-form-item">
        <label class="layui-form-label">合格照片</label>
        <div class="layui-input-block">
            <div class="layui-upload" style="padding-left: 30px;">
                <button type="button" class="layui-btn layui-btn-normal" id="fileList16">请选择文件</button>
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
                                            <td><span class="layui-btn layui-btn-xs layui-btn-danger del_uploads" indexs="'.$v["id"].'">删除</span></td>
                                        </tr>
                                        ';

                            }
                            ?>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
                <button type="button" class="layui-btn" id="file16Action">开始上传</button>
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
        var field14 = $('#file14')
            ,uploadListIns = upload.render({
                elem: '#fileList14'
                ,url: 'uploads2?type=file14&times='+{$times}
                ,multiple: true
                ,size: 15240
                ,auto: false
                ,bindAction: '#file14Action'
                ,choose: function(obj){
                    var files = this.files = obj.pushFile(); //将每次选择的文件追加到文件队列
                    //读取本地文件
                    obj.preview(function(index, file, result){
                        var tr = $(['<tr id="upload-'+ index +'">'
                            ,'<td><img src='+ result +' title='+ file.name +' class="layui-upload-img"></td>'
                            //,'<td>'+ (file.size/1414).toFixed(1) +'kb</td>'
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

                        field14.append(tr);
                    });
                }
                ,done: function(res, index, upload){
                    if(res.code == 0){ //上传成功
                        var tr = field14.find('tr#upload-'+ index)
                            ,tds = tr.children();
                        tds.eq(1).html('<span style="color: #5FB878;">上传成功</span>');
                        tds.eq(2).html(''); //清空操作
                        return delete this.files[index]; //删除文件队列已经上传成功的文件
                    }
                    this.error(index, upload);
                }
                ,error: function(index, upload){
                    var tr = field14.find('tr#upload-'+ index)
                        ,tds = tr.children();
                    tds.eq(1).html('<span style="color: #FF5722;">上传失败</span>');
                    tds.eq(2).find('.demo-reload').removeClass('layui-hide'); //显示重传
                }
            });
        var field16 = $('#file16')
            ,uploadListIns = upload.render({
                elem: '#fileList16'
                ,url: 'uploads2?type=file16&times='+{$times}
                ,multiple: true
                ,size: 15240
                ,auto: false
                ,bindAction: '#file16Action'
                ,choose: function(obj){
                    var files = this.files = obj.pushFile(); //将每次选择的文件追加到文件队列
                    //读取本地文件
                    obj.preview(function(index, file, result){
                        var tr = $(['<tr id="upload-'+ index +'">'
                            ,'<td><img src='+ result +' title='+ file.name +' class="layui-upload-img"></td>'
                            //,'<td>'+ (file.size/1414).toFixed(1) +'kb</td>'
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

                        field16.append(tr);
                    });
                }
                ,done: function(res, index, upload){
                    if(res.code == 0){ //上传成功
                        var tr = field16.find('tr#upload-'+ index)
                            ,tds = tr.children();
                        tds.eq(1).html('<span style="color: #5FB878;">上传成功</span>');
                        tds.eq(2).html(''); //清空操作
                        return delete this.files[index]; //删除文件队列已经上传成功的文件
                    }
                    this.error(index, upload);
                }
                ,error: function(index, upload){
                    var tr = field16.find('tr#upload-'+ index)
                        ,tds = tr.children();
                    tds.eq(1).html('<span style="color: #FF5722;">上传失败</span>');
                    tds.eq(2).find('.demo-reload').removeClass('layui-hide'); //显示重传
                }
            });
        var field13 = $('#file13')
            ,uploadListIns = upload.render({
                elem: '#fileList13'
                ,url: 'uploads2?type=file13&times='+{$times}
                ,multiple: true
                ,size: 15240
                ,auto: false
                ,bindAction: '#file13Action'
                ,choose: function(obj){
                    var files = this.files = obj.pushFile(); //将每次选择的文件追加到文件队列
                    //读取本地文件
                    obj.preview(function(index, file, result){
                        var tr = $(['<tr id="upload-'+ index +'">'
                            ,'<td><img src='+ result +' title='+ file.name +' class="layui-upload-img"></td>'
                            //,'<td>'+ (file.size/1314).toFixed(1) +'kb</td>'
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

                        field13.append(tr);
                    });
                }
                ,done: function(res, index, upload){
                    if(res.code == 0){ //上传成功
                        var tr = field13.find('tr#upload-'+ index)
                            ,tds = tr.children();
                        tds.eq(1).html('<span style="color: #5FB878;">上传成功</span>');
                        tds.eq(2).html(''); //清空操作
                        return delete this.files[index]; //删除文件队列已经上传成功的文件
                    }
                    this.error(index, upload);
                }
                ,error: function(index, upload){
                    var tr = field13.find('tr#upload-'+ index)
                        ,tds = tr.children();
                    tds.eq(1).html('<span style="color: #FF5722;">上传失败</span>');
                    tds.eq(2).find('.demo-reload').removeClass('layui-hide'); //显示重传
                }
            });


        var field12 = $('#file12')
            ,uploadListIns = upload.render({
                elem: '#fileList12'
                ,url: 'uploads2?type=file12&times='+{$times}
                ,multiple: true
                ,size: 15240
                ,auto: false
                ,bindAction: '#file12Action'
                ,choose: function(obj){
                    var files = this.files = obj.pushFile(); //将每次选择的文件追加到文件队列
                    //读取本地文件
                    obj.preview(function(index, file, result){
                        var tr = $(['<tr id="upload-'+ index +'">'
                            ,'<td><img src='+ result +' title='+ file.name +' class="layui-upload-img"></td>'
                            //,'<td>'+ (file.size/1214).toFixed(1) +'kb</td>'
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

                        field12.append(tr);
                    });
                }
                ,done: function(res, index, upload){
                    if(res.code == 0){ //上传成功
                        var tr = field12.find('tr#upload-'+ index)
                            ,tds = tr.children();
                        tds.eq(1).html('<span style="color: #5FB878;">上传成功</span>');
                        tds.eq(2).html(''); //清空操作
                        return delete this.files[index]; //删除文件队列已经上传成功的文件
                    }
                    this.error(index, upload);
                }
                ,error: function(index, upload){
                    var tr = field12.find('tr#upload-'+ index)
                        ,tds = tr.children();
                    tds.eq(1).html('<span style="color: #FF5722;">上传失败</span>');
                    tds.eq(2).find('.demo-reload').removeClass('layui-hide'); //显示重传
                }
            });


        var field11 = $('#file11')
            ,uploadListIns = upload.render({
                elem: '#fileList11'
                ,url: 'uploads2?type=file11&times='+{$times}
                ,multiple: true
                ,size: 15240
                ,auto: false
                ,bindAction: '#file11Action'
                ,choose: function(obj){
                    var files = this.files = obj.pushFile(); //将每次选择的文件追加到文件队列
                    //读取本地文件
                    obj.preview(function(index, file, result){
                        var tr = $(['<tr id="upload-'+ index +'">'
                            ,'<td><img src='+ result +' title='+ file.name +' class="layui-upload-img"></td>'
                            //,'<td>'+ (file.size/1114).toFixed(1) +'kb</td>'
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

                        field11.append(tr);
                    });
                }
                ,done: function(res, index, upload){
                    if(res.code == 0){ //上传成功
                        var tr = field11.find('tr#upload-'+ index)
                            ,tds = tr.children();
                        tds.eq(1).html('<span style="color: #5FB878;">上传成功</span>');
                        tds.eq(2).html(''); //清空操作
                        return delete this.files[index]; //删除文件队列已经上传成功的文件
                    }
                    this.error(index, upload);
                }
                ,error: function(index, upload){
                    var tr = field11.find('tr#upload-'+ index)
                        ,tds = tr.children();
                    tds.eq(1).html('<span style="color: #FF5722;">上传失败</span>');
                    tds.eq(2).find('.demo-reload').removeClass('layui-hide'); //显示重传
                }
            });


        var field10 = $('#file10')
            ,uploadListIns = upload.render({
                elem: '#fileList10'
                ,url: 'uploads2?type=file10&times='+{$times}
                ,multiple: true
                ,size: 15240
                ,auto: false
                ,bindAction: '#file10Action'
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

                        field10.append(tr);
                    });
                }
                ,done: function(res, index, upload){
                    if(res.code == 0){ //上传成功
                        var tr = field10.find('tr#upload-'+ index)
                            ,tds = tr.children();
                        tds.eq(1).html('<span style="color: #5FB878;">上传成功</span>');
                        tds.eq(2).html(''); //清空操作
                        return delete this.files[index]; //删除文件队列已经上传成功的文件
                    }
                    this.error(index, upload);
                }
                ,error: function(index, upload){
                    var tr = field10.find('tr#upload-'+ index)
                        ,tds = tr.children();
                    tds.eq(1).html('<span style="color: #FF5722;">上传失败</span>');
                    tds.eq(2).find('.demo-reload').removeClass('layui-hide'); //显示重传
                }
            });


        var field9 = $('#file9')
            ,uploadListIns = upload.render({
                elem: '#fileList9'
                ,url: 'uploads2?type=file9&times='+{$times}
                ,multiple: true
                ,size: 15240
                ,auto: false
                ,bindAction: '#file9Action'
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

                        field9.append(tr);
                    });
                }
                ,done: function(res, index, upload){
                    if(res.code == 0){ //上传成功
                        var tr = field9.find('tr#upload-'+ index)
                            ,tds = tr.children();
                        tds.eq(1).html('<span style="color: #5FB878;">上传成功</span>');
                        tds.eq(2).html(''); //清空操作
                        return delete this.files[index]; //删除文件队列已经上传成功的文件
                    }
                    this.error(index, upload);
                }
                ,error: function(index, upload){
                    var tr = field9.find('tr#upload-'+ index)
                        ,tds = tr.children();
                    tds.eq(1).html('<span style="color: #FF5722;">上传失败</span>');
                    tds.eq(2).find('.demo-reload').removeClass('layui-hide'); //显示重传
                }
            });


        var field8 = $('#file8')
            ,uploadListIns = upload.render({
                elem: '#fileList8'
                ,url: 'uploads2?type=file8&times='+{$times}
                ,multiple: true
                ,size: 15240
                ,auto: false
                ,bindAction: '#file8Action'
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

                        field8.append(tr);
                    });
                }
                ,done: function(res, index, upload){
                    if(res.code == 0){ //上传成功
                        var tr = field8.find('tr#upload-'+ index)
                            ,tds = tr.children();
                        tds.eq(1).html('<span style="color: #5FB878;">上传成功</span>');
                        tds.eq(2).html(''); //清空操作
                        return delete this.files[index]; //删除文件队列已经上传成功的文件
                    }
                    this.error(index, upload);
                }
                ,error: function(index, upload){
                    var tr = field8.find('tr#upload-'+ index)
                        ,tds = tr.children();
                    tds.eq(1).html('<span style="color: #FF5722;">上传失败</span>');
                    tds.eq(2).find('.demo-reload').removeClass('layui-hide'); //显示重传
                }
            });


        var field7 = $('#file7')
            ,uploadListIns = upload.render({
                elem: '#fileList7'
                ,url: 'uploads2?type=file7&times='+{$times}
                ,multiple: true
                ,size: 15240
                ,auto: false
                ,bindAction: '#file7Action'
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

                        field7.append(tr);
                    });
                }
                ,done: function(res, index, upload){
                    if(res.code == 0){ //上传成功
                        var tr = field7.find('tr#upload-'+ index)
                            ,tds = tr.children();
                        tds.eq(1).html('<span style="color: #5FB878;">上传成功</span>');
                        tds.eq(2).html(''); //清空操作
                        return delete this.files[index]; //删除文件队列已经上传成功的文件
                    }
                    this.error(index, upload);
                }
                ,error: function(index, upload){
                    var tr = field7.find('tr#upload-'+ index)
                        ,tds = tr.children();
                    tds.eq(1).html('<span style="color: #FF5722;">上传失败</span>');
                    tds.eq(2).find('.demo-reload').removeClass('layui-hide'); //显示重传
                }
            });


        var field6 = $('#file6')
            ,uploadListIns = upload.render({
                elem: '#fileList6'
                ,url: 'uploads2?type=file6&times='+{$times}
                ,multiple: true
                ,size: 15240
                ,auto: false
                ,bindAction: '#file6Action'
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

                        field6.append(tr);
                    });
                }
                ,done: function(res, index, upload){
                    if(res.code == 0){ //上传成功
                        var tr = field6.find('tr#upload-'+ index)
                            ,tds = tr.children();
                        tds.eq(1).html('<span style="color: #5FB878;">上传成功</span>');
                        tds.eq(2).html(''); //清空操作
                        return delete this.files[index]; //删除文件队列已经上传成功的文件
                    }
                    this.error(index, upload);
                }
                ,error: function(index, upload){
                    var tr = field6.find('tr#upload-'+ index)
                        ,tds = tr.children();
                    tds.eq(1).html('<span style="color: #FF5722;">上传失败</span>');
                    tds.eq(2).find('.demo-reload').removeClass('layui-hide'); //显示重传
                }
            });


        var field5 = $('#file5')
            ,uploadListIns = upload.render({
                elem: '#fileList5'
                ,url: 'uploads2?type=file5&times='+{$times}
                ,multiple: true
                ,size: 15240
                ,auto: false
                ,bindAction: '#file5Action'
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

                        field5.append(tr);
                    });
                }
                ,done: function(res, index, upload){
                    if(res.code == 0){ //上传成功
                        var tr = field5.find('tr#upload-'+ index)
                            ,tds = tr.children();
                        tds.eq(1).html('<span style="color: #5FB878;">上传成功</span>');
                        tds.eq(2).html(''); //清空操作
                        return delete this.files[index]; //删除文件队列已经上传成功的文件
                    }
                    this.error(index, upload);
                }
                ,error: function(index, upload){
                    var tr = field5.find('tr#upload-'+ index)
                        ,tds = tr.children();
                    tds.eq(1).html('<span style="color: #FF5722;">上传失败</span>');
                    tds.eq(2).find('.demo-reload').removeClass('layui-hide'); //显示重传
                }
            });


        var field4 = $('#file4')
            ,uploadListIns = upload.render({
                elem: '#fileList4'
                ,url: 'uploads2?type=file4&times='+{$times}
                ,multiple: true
                ,size: 15240
                ,auto: false
                ,bindAction: '#file4Action'
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

                        field4.append(tr);
                    });
                }
                ,done: function(res, index, upload){
                    if(res.code == 0){ //上传成功
                        var tr = field4.find('tr#upload-'+ index)
                            ,tds = tr.children();
                        tds.eq(1).html('<span style="color: #5FB878;">上传成功</span>');
                        tds.eq(2).html(''); //清空操作
                        return delete this.files[index]; //删除文件队列已经上传成功的文件
                    }
                    this.error(index, upload);
                }
                ,error: function(index, upload){
                    var tr = field4.find('tr#upload-'+ index)
                        ,tds = tr.children();
                    tds.eq(1).html('<span style="color: #FF5722;">上传失败</span>');
                    tds.eq(2).find('.demo-reload').removeClass('layui-hide'); //显示重传
                }
            });

        var field3 = $('#file3')
            ,uploadListIns = upload.render({
                elem: '#fileList3'
                ,url: 'uploads2?type=file3&times='+{$times}
                ,multiple: true
                ,size: 15240
                ,auto: false
                ,bindAction: '#file3Action'
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

                        field3.append(tr);
                    });
                }
                ,done: function(res, index, upload){
                    if(res.code == 0){ //上传成功
                        var tr = field3.find('tr#upload-'+ index)
                            ,tds = tr.children();
                        tds.eq(1).html('<span style="color: #5FB878;">上传成功</span>');
                        tds.eq(2).html(''); //清空操作
                        return delete this.files[index]; //删除文件队列已经上传成功的文件
                    }
                    this.error(index, upload);
                }
                ,error: function(index, upload){
                    var tr = field3.find('tr#upload-'+ index)
                        ,tds = tr.children();
                    tds.eq(1).html('<span style="color: #FF5722;">上传失败</span>');
                    tds.eq(2).find('.demo-reload').removeClass('layui-hide'); //显示重传
                }
            });


        var field2 = $('#file2')
            ,uploadListIns = upload.render({
                elem: '#fileList2'
                ,url: 'uploads2?type=file2&times='+{$times}
                ,multiple: true
                ,size: 15240
                ,auto: false
                ,bindAction: '#file2Action'
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

                        field2.append(tr);
                    });
                }
                ,done: function(res, index, upload){
                    if(res.code == 0){ //上传成功
                        var tr = field2.find('tr#upload-'+ index)
                            ,tds = tr.children();
                        tds.eq(1).html('<span style="color: #5FB878;">上传成功</span>');
                        tds.eq(2).html(''); //清空操作
                        return delete this.files[index]; //删除文件队列已经上传成功的文件
                    }
                    this.error(index, upload);
                }
                ,error: function(index, upload){
                    var tr = field2.find('tr#upload-'+ index)
                        ,tds = tr.children();
                    tds.eq(1).html('<span style="color: #FF5722;">上传失败</span>');
                    tds.eq(2).find('.demo-reload').removeClass('layui-hide'); //显示重传
                }
            });
        //多文件列表first
        var field1 = $('#file1')
            ,uploadListIns = upload.render({
                elem: '#fileList1'
                ,url: 'uploads2?type=file1&times='+{$times}
                ,multiple: true
                ,size: 15240
                ,auto: false
                ,bindAction: '#file1Action'
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

                        field1.append(tr);
                    });
                }
                ,done: function(res, index, upload){
                    if(res.code == 0){ //上传成功
                        var tr = field1.find('tr#upload-'+ index)
                            ,tds = tr.children();
                        tds.eq(1).html('<span style="color: #5FB878;">上传成功</span>');
                        tds.eq(2).html(''); //清空操作
                        return delete this.files[index]; //删除文件队列已经上传成功的文件
                    }
                    this.error(index, upload);
                }
                ,error: function(index, upload){
                    var tr = field1.find('tr#upload-'+ index)
                        ,tds = tr.children();
                    tds.eq(1).html('<span style="color: #FF5722;">上传失败</span>');
                    tds.eq(2).find('.demo-reload').removeClass('layui-hide'); //显示重传
                }
            });

        var field = $('#file')
            ,uploadListIns = upload.render({
                elem: '#fileList'
                ,url: 'uploads2?type=file&times='+{$times}
                ,multiple: true
                ,size: 15240
                ,auto: false
                ,bindAction: '#fileAction'
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

                        field.append(tr);
                    });
                }
                ,done: function(res, index, upload){
                    if(res.code == 0){ //上传成功
                        var tr = field.find('tr#upload-'+ index)
                            ,tds = tr.children();
                        tds.eq(1).html('<span style="color: #5FB878;">上传成功</span>');
                        tds.eq(2).html(''); //清空操作
                        return delete this.files[index]; //删除文件队列已经上传成功的文件
                    }
                    this.error(index, upload);
                }
                ,error: function(index, upload){
                    var tr = field.find('tr#upload-'+ index)
                        ,tds = tr.children();
                    tds.eq(1).html('<span style="color: #FF5722;">上传失败</span>');
                    tds.eq(2).find('.demo-reload').removeClass('layui-hide'); //显示重传
                }
            });
        var qualified = $('#qualified')
            ,uploadListIns = upload.render({
                elem: '#upload_img'
                ,url: '/rackstage/index/uploads?mark=enquiry&reserve=qualified&times='+{$times}+'&updatetime='+{$nowtime}
                ,multiple: true
                ,size: 15240
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
                ,size: 15240
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
                    url: "uploads_del" ,
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
            if($('#projectName').val()==null){ layer.alert("项目部门不能为空");  return false;};
             if($('#levels').val()==""){ layer.alert("等级不能为空");  return false;};
              if($('#score').val()==""){ layer.alert("分数不能为空");  return false;};
              if($('#manager').val()==""){ layer.alert("项目经理不能为空");  return false;};
              if($('#enquirytime').val()==""){ layer.alert("询盘时间不能为空");  return false;};

            return true;

        }

    })

</script>
</body>
</html>