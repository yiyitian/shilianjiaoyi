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
    .layui-table-cell {
        font-size:14px;
        padding:0 5px;
        height:auto;
        overflow:visible;
        text-overflow:inherit;
        white-space:normal;
        word-wrap: break-word;
    }
    #line{
        display:none;
    }
</style>
<body>

<!-- 内容主体区域 -->
<div style="padding: 15px;">
   
   
   
    <form class="layui-form" action="" id="formid"  >
       
        </div>

        <input name="classes" id="classes" type="hidden" />
    </form>
    <table class="layui-hide"  lay-filter="test" id="test"></table>

    <div id="pages" class="text-center"></div>
</div>

<script src="/public/layui/layui.js"></script>
<script>
    layui.use(['table','layer','jquery'], function(){
        var table = layui.table,
            $   = layui.jquery
            ,form = layui.form
            ,layer = layui.layer;

        //监听 select start
        form.on('select(classtype)', function(data){
           if(data.value == '125')
           {
            $("#line").css('display','block');//显示
            $.ajax({
                type: 'POST',
                url: "getList",
                data: {id:data.value},
                dataType:  'json',
                success:function(data){
                 
                   
                    $("select[name='online']").empty();
                    var html = "<option value='0'>选择期数</option>";
                    $(data).each(function (v, k) {
                        html += "<option value='" + k.id + "'>" + k.title + "</option>";
                    });
                    //把遍历的数据放到select表里面
                    $("select[name='online']").append(html);
                    //从新刷新了一下下拉框
                    form.render('select');      //重新渲染
                }
            });
            return false;
           }else{
            $("#line").css('display','none');//显示
           }
            //执行重载
            table.reload('test', {
                url: 'class_lists?list=1'
                ,page: {
                    curr: 1 //重新从第 1 页开始
                }
                ,where: {
                    classtype: data.value
                }
            });
        });

         form.on('select(ddd)', function(data){
            table.reload('test', {
                url: 'class_lists?list=1'
                ,page: {
                    curr: 1 //重新从第 1 页开始
                }
                ,where: {
                    classtype: data.value
                }
            });
        });

        //监听  select end
        var clientWidth=document.body.clientWidth;
        var clientHeight=document.body.clientHeight;
        table.render({
            id:'test',
            elem: '#test'
            ,url:'class_lists'
            ,page:false
            ,cols: [[
                {type:'checkbox'}
                ,{type:'numbers', title: '编号'}
                ,{field:'title', align:'center',  title: '课程分类'}


            ]]
        });
        table.render({
            id:'choosed',
            elem: '#choosed'
            ,url:'class_lists?id=1'
            ,page:false
            ,cols: [[
                {type:'numbers', title: '编号'}
                ,{field:'title', align:'center',  title: '课程分类'}


            ]]
        });
        table.on('checkbox(test)', function(obj){
           
            if(obj.type=='one'){
                var classes=$('#classes').val();
                if(obj.checked){
                    console.log(obj.data.id)
                    if(classes=='')
                    {
                        $('#classes').val(obj.data.id)
                    }else
                    {
                        $('#classes').val(classes+','+obj.data.id)
                    }

                }else
                {
                    if(classes!=''){
                        classes=','+classes+',';
                        check_id=','+obj.data.id+',';
                        console.log(classes)
                        console.log(check_id)
                        var result=classes.replace(check_id, ',');

                        //console.log(result.length)
                        if(result.length>2)
                        {
                            console.log(result)
                            result=result.substr(1,result.length-2);
                            console.log(result)
                            $('#classes').val(result);
                        }else{
                            $('#classes').val('');
                        }
                    }
                }

            }else if(obj.type=='all'){
                if(obj.checked){
                    $('#classes').val('all');
                }else{
                    $('#classes').val('');
                }
            }

        });


        callbackdata=function () {

            var data =$("#formid").serialize();
            return data;

        }
    });

</script>
</body>
</html>