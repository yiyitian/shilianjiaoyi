
<div class="h54"></div>
<div class="clear"></div>
<div class="footerBox">
    <div class="footer">
        <ul>
            <li {eq name=':request()->controller()' value='Index'} class="on" {/eq}>
                <a href="/api/Index/index">
                    {eq name=':request()->controller()' value='Index'}
                    <img src="/public/api/picture/f01.png">
                    {else/}
                    <img src="/public/api/picture/f1.png">
                    {/eq}                    <p>首页</p>
                </a>
            </li>

            <li {eq name=':request()->controller()' value='Course'} class="on" {/eq}>
                <a href="/api/Course/index">
                    {eq name=':request()->controller()' value='Course'}
                        <img src="/public/api/picture/f05.png">
                    {else/}
                        <img src="/public/api/picture/f5.png">
                    {/eq}
                    <p>课程</p>
                </a>
            </li>

<!--            <li {eq name=':request()->controller()' value='Lecturer'} class="on" {/eq}>-->
<!--                <a href="/api/lecturer/index">-->
<!--                    {eq name=':request()->controller()' value='Lecturer'}-->
<!--                    <img src="/public/api/picture/f03.png">-->
<!--                    {else/}-->
<!--                    <img src="/public/api/picture/f3.png">-->
<!--                    {/eq}-->
<!--                    <p>讲师</p>-->
<!--                </a>-->
<!--            </li>-->
            <li {eq name=':request()->action()' value='achievements'} class="on" {/eq}>
            <a href="/api/User/achievements">
                {eq name=':request()->action()' value='achievements'}
                <img src="/public/api/picture/f018.png">
                {else/}
                <img src="/public/api/picture/f18.png">
                {/eq}
                <p>绩效</p>
            </a>
            </li>

            <li  {eq name=':request()->controller()' value='Cases'} class="on" {/eq}>
                <a href="/api/Cases/index">
                    {eq name=':request()->controller()' value='Cases'}
                    <img src="/public/api/picture/f02.png">
                    {else/}
                    <img src="/public/api/picture/f2.png">
                    {/eq}
                    <p>案场</p>
                </a>
            </li>
            <li  {eq name=':request()->action()' value='indexs'} class="on" {/eq}>
                <a href="/api/User/indexs">
                    {eq name=':request()->action()' value='indexs'}
                    <img src="/public/api/picture/f04.png">
                    {else/}
                    <img src="/public/api/picture/f4.png">
                    {/eq}
                    <p>我的</p>
                </a>
<!--                //<div id="badge4">5</div>-->
            </li>

        </ul>
    </div>
</div>
</body>
</html>
