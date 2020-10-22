
<div class="layui-footer">
    <!-- 底部固定区域 -->
    <a href="http://www.txct.net" target="_blank" style="color:#999;">天下畅通</a>-提供技术支持
</div>
</div>
<script>
    layui.use('element', function(){
        var element = layui.element;
    });
    var isShow=1;


    layui.use(['table','layer','jquery'], function(){
        var table = layui.table,
            $   = layui.jquery
            ,form = layui.form
            ,layer = layui.layer;
        iconHide= function()
        {
            if(isShow===1)
                hide();
            else
                show();
            isShow*=-1;
        }
        function hide(){
            $('.layui-side span').hide();
            $('.layui-side').animate({width:'55px'});
            $('.layui-body').animate({left:'55px'});
            document.getElementById('hide').className="layui-color layui-icon layui-icon-spread-left";
        }
        function show(){
            $('.layui-side span').show();
            $('.layui-side').animate({width:'200px'});
            $('.layui-body').animate({left:'200px'});
            document.getElementById('hide').className="layui-color layui-icon layui-icon-shrink-right";
        }
        function ulHide(){
            if(isShow===-1)
                show();
            isShow=1;
        }
        $().ready(function(){
            var curr_url = window.location.href;  //获取当前URL
            $('.nav a').each(function(i,n){  //循环导航的a标签
                var href = $(this).attr('href'); //a标签中的href链接
                if(href == curr_url){  //如果当前URL,和a标签中的href相等。
                    $(this).addClass('home_page');  //那么就给这个a标签添加home_page类。
                }
            })
        })
        var i = 0;
        $(".layui-nav-tree .layui-nav-item").click(function(){



        });
        

    })

    layui.use(['table','layer','jquery'], function(){
        var $ = layui.jquery, layer = layui.layer;
        $(document).on('click','#edit_head',function(){
            var index = layer.open({
                type: 2,
                shade: [0.1],
                title:"更换头像",
                area: ['650px', '320px'],
                maxmin: true,
                content: '/rackstage/login/edit_head',
                btn: ['保存','关闭'],
                zIndex: layer.zIndex, //重点1
                yes: function(index){
                    var row= window["layui-layer-iframe" + index].callbackdata();
                    if(!$.trim(row)){
                        return false;
                    }
                    layer.closeAll();
                },
                cancel: function(){
                },
                end: function(){ //此处用于演示
                }
            });
        });
        $(document).on('click','#edit_pwd',function(){
            var index = layer.open({
                type: 2,
                shade: [0.1],
                title:"修改密码",
                area: ['650px', '320px'],
                maxmin: true,
                content: '/rackstage/login/edit_pwd',
                btn: ['保存','关闭'],
                zIndex: layer.zIndex, //重点1
                yes: function(index){
                    var row= window["layui-layer-iframe" + index].callbackdata();
                    if(!$.trim(row)){
                        return false;
                    }
                    layer.closeAll();
                    $.ajax({
                        url:"/rackstage/login/edit_pwd",
                        type:"post",
                        dataType: "json",
                        cache: false,
                        data:row,
                        contentType: "application/x-www-form-urlencoded; charset=utf-8",
                        success:function(data){
                            if(data.code==1){
                                layer.msg(data.msg,{icon:1,time: 500},function () {
                                    location.reload();
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
    });
</script>
</body>
</html>