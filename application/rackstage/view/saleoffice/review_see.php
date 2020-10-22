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
            <input type="text" readonly id=""  name="manager" value="{$list.department_name|default=''}"  placeholder="请输入项目经理" class="layui-input">
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
        <label class="layui-form-label">客户姓名</label>
        <div class="layui-input-inline">
            <input type="text" readonly  id="customer"  name="customer" value="{$list.customer|default=''}"  placeholder="请输入客户姓名" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">客户电话</label>
        <div class="layui-input-inline">
            <input type="text" readonly id="phone" name="phone" value="{$list.phone|default=''}" placeholder="请输入客户电话" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">业务员</label>
        <div class="layui-input-inline">
            <input type="text" readonly id="salesman" name="salesman" value="{$list.salesman|default=''}" placeholder="请输入业务员姓名" class="layui-input">
        </div>
        <div class="layui-inline layui-word-aux">

        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">主动接待</label>
        <div class="layui-input-block">
            <input type="radio" name="" value="1" title="{$list.positive}分" checked>

        </div>
        <div class="layui-inline layui-word-aux">
            (是1分，否0分)
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">耐心回答</label>

        <div class="layui-input-block">
            <input type="radio" name="" value="1" title="{$list.patient}分" checked>
        </div>
        <div class="layui-inline layui-word-aux">
            (是1分，否0分)
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">客户了解楼盘</label>
        
        <div class="layui-input-block">
            <input type="radio" name="" value="1" title="{$list.lucid}分" checked>

        </div>
        <div class="layui-inline layui-word-aux">
            客户是否清楚了解所需楼盘情况（是1分，否0分）
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">有无异议</label>

        <div class="layui-input-block">
            <input type="radio" name="" value="1" title="{$list.dissent}分" checked>

        </div>
        <div class="layui-inline layui-word-aux">
            对销售代表在接待过程中介绍的购房所产生的费用有无异议?（无1分，有0分）
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">客户对服务评分</label>
        <div class="layui-input-inline">
            <input type="text" readonly id="appraise" name="appraise" value="{$list.appraise|default=''}" placeholder="客户对服务评分" class="layui-input">
        </div>
        <div class="layui-inline layui-word-aux">
            （1-5分）
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">客户建议</label>
        <div class="layui-input-block">
            <input type="radio" name="" value="1" title="{$list.suggest}分" checked>

        </div>
        <div class="layui-inline layui-word-aux">
            表扬1分，无0分，投诉－1分
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">总分</label>
        <div class="layui-input-inline">
            <input type="text" readonly id="score" name="score" value="{$list.score|default=''}" placeholder="总分" class="layui-input">
        </div>
        <div class="layui-inline layui-word-aux">

        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">抽查时间</label>
        <div class="layui-input-inline">
            <input type="text" readonly  id=""  name="" value="{$list.enquirytime|default=''}"  placeholder="请输入巡盘时间" class="layui-input">
        </div>
    </div>

    <div class="layui-form-item layui-form-text">
        <label class="layui-form-label">备注</label>
        <div class="layui-input-block">
            <textarea readonly placeholder="请输入内容" class="layui-textarea" name="mark" style="width:80%">{$list.mark|default='无内容'}</textarea>
        </div>
    </div>
</form>
<script src="/public/layui/layui.js" charset="utf-8"></script>
<script>
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