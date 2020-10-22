
<script type="text/html" id="checkboxTp2">
    <input type="checkbox" name="status" value="{{d.status}}" lay-skin="switch" lay-text="显示|隐藏" lay-filter="sexDemo" {{
           d.status== 1 ? 'checked' : '' }}>
</script>
<div class="layui-body">
    <!-- 内容主体区域 -->
    <div style="padding: 15px;">
        <div class="demoTable">
            {in name="jurisdiction" value="1"}
            <div class="layui-input-inline" style="width:300px;">
                <select id="ids" lay-filter="ids" xm-select="select7_3" xm-select-skin="danger" xm-select-search=""
                        xm-select-show-count="1">
                    <option value="">员工姓名多选</option>
                    {volist name="users" id="vo"}
                    <option value="{$vo.id}">{$vo.username}-{$vo.work_id}</option>
                    {/volist}

                </select>
            </div>

            <div class="layui-input-inline" style="width:300px;">
                <select id="department" lay-filter="department" xm-select="select7_0" xm-select-skin="danger"
                        xm-select-search="" xm-select-show-count="1">
                    <option value="">请选择部门</option>
                    {volist name="framework_pid" id="vo_pid"}
                    <optgroup label="{$vo_pid.name}">
                        {volist name="vo_pid.framework" id="vo"}
                        {if condition="$vo.pid eq $vo_pid.id"}

                        <option value="{$vo.id}">{$vo.name}</option>
                        {/if}
                        {/volist}
                    </optgroup>
                    {/volist}

                </select>
            </div>
            <div class="layui-input-inline" style="width:300px;">
                <select id="project" lay-filter="project" xm-select="select7_1" xm-select-skin="danger"
                        xm-select-search="" xm-select-show-count="1">
                    <option value="">请选择项目</option>
                    {volist name="project_pid" id="vo_pid"}
                    <optgroup label="{$vo_pid.name}-{$vo_pid.father}">
                        {volist name="vo_pid.project" id="vo"}
                        {if condition="$vo.framework_id eq $vo_pid.id"}
                        <option value="{$vo.id}">{$vo.name}</option>
                        {/if}
                        {/volist}
                    </optgroup>
                    {/volist}

                </select>
            </div>
            {/in}
            <div class="layui-input-inline" style="">
                <input class="layui-input" name="create_at" value="" id="test6" placeholder="请选择日期" autocomplete="off">
            </div>
            <button class="layui-btn search" data-type="reload" style="">搜索</button>


            {in name="jurisdiction" value="2,5"}
            <button class="layui-btn" id="create_table">一键生成打分表</button>
            <!-- <button class="layui-btn"  id="add_user">添加人员</button> -->
            {/in}
            {in name="jurisdiction" value="1,7,8"}
            <button class="layui-btn" id="xu">蓄客期查询</button>
            <button class="layui-btn" id="chi">持销期查询</button>
            {/in}
            <button class="layui-btn"  id="submit_employee">提交</button>
            <button class="layui-btn" style="background: #dddddd" onclick="window.location.href='plan?history=1'">历史打分
            </button>
        </div>


        <div style="bottom: 10%;color: #868282;">
            <div>月理论利润≥0得30分，否得0分</div>
            <div>月来访目标完成得40分，否得0分</div>
            <div>月认购完成率≥50%得30分，否得0分</div>
        </div>
        <script type="text/html" id="barDemo">
            {eq name="jurisdiction" value="1"}
            <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="pass">通过</a>
            {/eq}
            <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
        </script>
        <script type="text/html" id="adminTpl">
            {{#  if(d.admin_id === 0){ }}
            <span style="color: red;">未打分</span>
            {{#  } else { }}
            <span style="color: green;">已打分</span>
            {{#  } }}
        </script>
        <script type="text/html" id="isTpl">
            {{#  if(d.manager_id === 0){ }}
            <span style="color: red;">未打分</span>
            {{#  } else { }}
            <span style="color: green;">已打分</span>
            {{#  } }}
        </script>
        <script type="text/html" id="visiting_score">

            <span style="color: {{d.color2}};">{{ d.visiting_score}}</span>

        </script>
        <script type="text/html" id="profit_score">

            <span style="color: {{d.color3}};">{{ d.profit_score}}</span>

        </script>
        <script type="text/html" id="subscribe_real">

            <span style="color: {{d.color1}};">{{ d.subscribe_real}}</span>

        </script>
        <script type="text/html" id="visiting_score">
            {{#  if(d.visiting_score !==d.erp_entry_real_score){ }}
            <span style="color: {{d.color2}};">{{ d.visiting_score}}</span>
            {{#  } else { }}
            {{ d.visiting_score}}
            {{#  } }}
        </script>

        <div id=" pages" class="text-center">
        </div>
    </div>
</div>
<script src="/public/layui/layui.js"></script>
<script src="/public/layui/formSelects-v4.js" charset="utf-8"></script>
<script>
    layui.config({
        base: './' //此处路径请自行处理, 可以使用绝对路径
    }).extend({
        formSelects: 'formSelects-v4'
    });
    //日期范围

    layui.use(['table', 'layer', 'jquery', 'laydate', 'upload'], function () {
        var table = layui.table,
            $ = layui.jquery
            , form = layui.form
            , laydate = layui.laydate
            , upload = layui.upload
            , layer = layui.layer;
        laydate.render({
            elem: '#test6'
            , range: true
        });
        var in_time={$in_time};
        $('#xu').click(function(){
            var index = layer.open({
                title:"蓄客期查询",
                type: 2,
                content: "/rackstage/Plan/xu?id="+1,
                area: ['100%', '100%'],
                maxmin: true
            });
            layer.full(index);
        })
        layui.formSelects.opened('select7_1', function (id) {
            console.log(layui.formSelects.value('select7_0', 'val'));
            val = layui.formSelects.value('select7_0', 'val');    //取值val字符串
            $.ajax({
                url: "/rackstage/Getinfo/getProject",
                data: {'pid': val},
                type: "get",
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    project = data;
                    var formSelects = layui.formSelects;
                    formSelects.data('select7_1', 'local', {
                        arr: data
                    });
                }
            });
            console.log(val);
        });

        var clientWidth = document.body.clientWidth;
        var clientHeight = document.body.clientHeight;
        /*搜索开始*/
        var $ = layui.$, active = {
            reload: function () {
                var demoReload = $('#search_field');
                //执行重载
                table.reload('test', {
                    url: '/rackstage/Plan/employee_search'
                    , page: {
                        curr: 1 //重新从第 1 页开始
                    }
                    , method: 'post'
                    , where: {
                        project: layui.formSelects.value('select7_1', 'val'),
                        department: layui.formSelects.value('select7_0', 'val'),
                        ids: layui.formSelects.value('select7_3', 'val'),
                        date: $("#test6").val(),
                    }
                });
            }
        };
        $('.demoTable .layui-btn').on('click', function () {
            var type = $(this).data('type');
            active[type] ? active[type].call(this) : '';
        });
        $('#create_table').click(function () {
            $.ajax({
                url: "/rackstage/Plan/create_table",
                data: {'create': 'yes'},
                type: "get",
                dataType: 'json',
                success: function (data) {
                    layer.msg(data.msg, {icon: data.code, time: 1000}, function () {
                        setTimeout(function () {
                            window.location.reload();
                        }, 666)

                    });
                }
            })
            ;
        });
        /*搜索结束*/
        //#添加end
        //编辑表格工具
        table.on('edit(test)', function (obj) {
            var value = obj.value //得到修改后的值
                , data = obj.data //得到所在行所有键值
                , field = obj.field; //得到字段
            // layer.msg('[ID: '+ data.id +'] ' + field + ' 字段更改为：'+ value);
            $.ajax({
                url: "/rackstage/Plan/employee_edit",
                data: {
                    'id': data.id,
                    'field': field,
                    'value': value,
                    manager_id: "{$manager_id}",
                    admin_id: "{$admin_id}"
                },
                type: "post",
                dataType: 'json',
                success: function (data) {

                }
            })
        });
        table.on('tool(test)', function(obj){
            var data = obj.data;
            if(obj.event === 'del'){
                console.log(data.id);
                layer.confirm('真的删除么', function(index){
                    $.ajax({
                        url: "/rackstage/Plan/del" ,
                        data: {'id':data.id},
                        type: "post" ,
                        dataType:'json',
                        success:function(data){
                            layer.msg(data.msg, {icon: data.code,time:500},function(){
                                $(".layui-laypage-btn").click();
                            });
                        }
                    })
                });

            }else if(obj.event=='pass'){
                layer.confirm('确认通过吗', function(index){
                    $.ajax({
                        url: "/rackstage/Plan/pass" ,
                        data: {'id':data.id},
                        type: "post" ,
                        dataType:'json',
                        success:function(data){
                            layer.msg(data.msg, {icon: data.code,time:500},function(){
                                $(".layui-laypage-btn").click();
                            });
                        }
                    })
                });
            }
        });
        $("#submit_employee").click(function () {
            $.ajax({
                url: "/rackstage/Plan/submit_employee",
                data: {is_submit: 'yes'},
                type: "post",
                dataType: 'json',
                success: function (data) {
                    layer.msg(data.msg, {icon: data.code, time: 1000}, function () {
                        $(".layui-laypage-btn").click();

                    });
                }
            })
        });
        $("#add_user").click(function () {
            var index = layer.open({
                type: 2,
                shade: [0.1],
                title: "添加/编辑",
                area: ['700px', '500px'],
                maxmin: true,
                content: '/rackstage/Plan/add_user',
                btn: ['保存', '关闭'],
                zIndex: layer.zIndex,
                yes: function(index) {
                    var row = window["layui-layer-iframe" + index].callbackdata();
                    if (!$.trim(row)) {
                        return false;
                    }
                    layer.closeAll();
                    $.ajax({
                        url: "/rackstage/Plan/add_user",
                        type: "post",
                        dataType: "json",
                        cache: false,
                        data: row,
                        contentType: "application/x-www-form-urlencoded; charset=utf-8",
                        success: function(data) {
                            layer.msg(data.msg, {
                                time: 1000
                            }, function() {
                                //renderTable();
                                $(".layui-laypage-btn").click()
                            });
                        }
                    });
                },
                cancel: function() {},
                end: function() { //此处用于演示
                }
            });
        });
    });


</script>