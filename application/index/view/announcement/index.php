{include file="public/header" /}
<link rel="stylesheet" href="/public/index/mescroll-master/dist/mescroll.min.css">
<script src="/public/index/mescroll-master/dist/mescroll.min.js" type="text/javascript" charset="utf-8"></script>
<!--mescroll本身不依赖jq,这里为了模拟发送ajax请求-->
<script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js" type="text/javascript" charset="utf-8"></script>
    <style type="text/css">
        .news_k li h1{
            width:1.1rem;
        }
        * {
            margin: 0;
            padding: 0;
            -webkit-touch-callout:none;
            -webkit-user-select:none;
            -webkit-tap-highlight-color:transparent;
        }
        body{background-color: white}
        ul{list-style-type: none}
        a {text-decoration: none;color: #18B4FE;}

        /*模拟的标题*/
        .header{
            z-index: 9990;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 44px;
            line-height: 44px;
            text-align: center;
            border-bottom: 1px solid #eee;
            background-color: white;
        }
        .header .btn-left{
            position: absolute;
            top: 0;
            left: 0;
            padding:12px;
            line-height: 22px;
        }
        .header .btn-right{
            position: absolute;
            top: 0;
            right: 0;
            padding: 0 12px;
        }
        /*说明*/
        .mescroll .notice{
            font-size: 14px;
            padding: 20px 0;
            border-bottom: 1px solid #eee;
            text-align: center;
            color:#555;
        }
        /*列表*/
        .mescroll{
            position: fixed;
            top: 90px;
            bottom: 0;
            height: auto;
        }
        /*展示上拉加载的数据列表*/
        .news-list li{
            padding: 16px;
            border-bottom: 1px solid #eee;
        }
        .news-list .new-content{
            font-size: 14px;
            margin-top: 6px;
            margin-left: 10px;
            color: #666;
        }
    </style>
</head>
<!-- 头部 -->
<div class="toub_beij">
    <div class="logo"><a href="###"><img src="/public/index/images/logo_sy.png"></a></div>
<!--    <div class="sy_zaix"><a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=2239329788&site=qq&menu=yes">在线咨询</a></div>-->
</div>

<div class="luj">
    <div class="luj_nk">
        <em></em>
        <a href="###">公告列表</a>
    </div>
</div>

<!--滑动区域-->
<div id="mescroll" style="bottom:40px;" class="mescroll news_k">

    <ul id="newsList" class="news-list">


<!--        <li>-->
<!--            <a href="#">-->
<!--                <h1><img src="/public/index/images/news3.jpg"></h1>-->
<!--                <p>111111111111111111111111111111111</p>-->
<!--                <h2>日期：2018-01-24</h2>-->
<!--            </a>-->
<!--        </li>-->
    </ul>
</div>
</body>

<script type="text/javascript" charset="utf-8">
    $(function(){
        //创建MeScroll对象
        var mescroll = new MeScroll("mescroll", {
            down: {
                auto: false, //是否在初始化完毕之后自动执行下拉回调callback; 默认true
                callback: downCallback //下拉刷新的回调
            },
            up: {
                auto: true, //是否在初始化时以上拉加载的方式自动加载第一页数据; 默认false
                isBounce: false, //此处禁止ios回弹,解析(务必认真阅读,特别是最后一点): http://www.mescroll.com/qa.html#q10
                page: {
                    num: 0, //当前页 默认0,回调之前会加1; 即callback(page)会从1开始
                    size: 10 //每页数据条数,默认10
                },
                callback: upCallback, //上拉回调,此处可简写; 相当于 callback: function (page) { upCallback(page); }
                toTop:{ //配置回到顶部按钮
                    src : "/public/index/mescroll-master/demo/res/img/mescroll-totop.png", //默认滚动到1000px显示,可配置offset修改
                    //offset : 1000
                }
            }
        });
        /*下拉刷新的回调 */
        function downCallback(){
            //联网加载数据
            getListDataFromNet(0, 1, function(data){
                //联网成功的回调,隐藏下拉刷新的状态
                mescroll.endSuccess();
                //设置列表数据
                setListData(data, false);
            }, function(){
                //联网失败的回调,隐藏下拉刷新的状态
                mescroll.endErr();
            });
        }
        //上拉加载的回调 page = {num:1, size:10}; num:当前页 默认从1开始, size:每页数据条数,默认10
        function upCallback(page) {
            $.ajax({
                url: 'index?num=' + page.num + "&size=" + page.size, //如何修改page.num从0开始 ?
                success: function(data) {
                    var curPageData = data.curPageData; // 接口返回的当前页数据列表
                    mescroll.endSuccess(curPageData.length);
                    setListData(curPageData,true);//自行实现 TODO
                },
                error: function(e) {
                    mescroll.endErr();
                }
            });

        }
        /*设置列表数据*/
        function setListData(curPageData, isAppend) {
            var listDom=document.getElementById("newsList");
            console.log(curPageData.length);
            if(curPageData.length == 0){
                document.getElementById("newsList").innerHTML='暂无内容';
                document.getElementById("newsList").style.textAlign="center";
                document.getElementById("newsList").style.color="#ccc";
            }
            for (var i = 0; i < curPageData.length; i++) {
                var newObj=curPageData[i];
                var string = '';
                    string+= '<a href="Detail?id='+newObj.id+'"><h1><img src="/public/index/images/black.jpg"></h1>';
                    if(newObj.is_seen=='1'){
                        string+= '<p style="color:red;">'+newObj.title;
                    }else{
                        string+= '<p>'+newObj.title;
                    }

                   
                    string+= '</p><h2>';
                    console.log(newObj);
                    string+= ' &nbsp;&nbsp;&nbsp;<span style="float:right;padding-top:20px;">发布时间:'+newObj.createtime+'</span></h2></a>';
                var liDom=document.createElement("li");
                liDom.innerHTML=string;
                if (isAppend) {
                    listDom.appendChild(liDom);//加在列表的后面,上拉加载
                } else{
                    listDom.insertBefore(liDom, listDom.firstChild);//加在列表的前面,下拉刷新
                }
            }
        }


    });
</script>
{include file="public/footer" /}

