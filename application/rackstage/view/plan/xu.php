
<script type="text/html" id="checkboxTp2">
    <input type="checkbox" name="status" value="{{d.status}}" lay-skin="switch" lay-text="��ʾ|����" lay-filter="sexDemo" {{
           d.status== 1 ? 'checked' : '' }}>
</script>
<div class="layui-body">
    <!-- ������������ -->
    <div style="padding: 15px;">
        <div class="demoTable">
            {in name="jurisdiction" value="1"}
            <div class="layui-input-inline" style="width:300px;">
                <select id="ids" lay-filter="ids" xm-select="select7_3" xm-select-skin="danger" xm-select-search=""
                        xm-select-show-count="1">
                    <option value="">Ա��������ѡ</option>
                    {volist name="users" id="vo"}
                    <option value="{$vo.id}">{$vo.username}-{$vo.work_id}</option>
                    {/volist}

                </select>
            </div>

            <div class="layui-input-inline" style="width:300px;">
                <select id="department" lay-filter="department" xm-select="select7_0" xm-select-skin="danger"
                        xm-select-search="" xm-select-show-count="1">
                    <option value="">��ѡ����</option>
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
                    <option value="">��ѡ����Ŀ</option>
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
                <input class="layui-input" name="create_at" value="" id="test6" placeholder="��ѡ������" autocomplete="off">
            </div>
            <button class="layui-btn search" data-type="reload" style="">����</button>


            {in name="jurisdiction" value="2,5"}
            <button class="layui-btn" id="create_table">һ�����ɴ�ֱ�</button>
            <!-- <button class="layui-btn"  id="add_user">�����Ա</button> -->
            {/in}
            {in name="jurisdiction" value="1,7,8"}
            <button class="layui-btn" id="xu">����ڲ�ѯ</button>
            <button class="layui-btn" id="chi">�����ڲ�ѯ</button>
            {/in}
            <button class="layui-btn"  id="submit_employee">�ύ</button>
            <button class="layui-btn" style="background: #dddddd" onclick="window.location.href='plan?history=1'">��ʷ���
            </button>
        </div>


        <div style="bottom: 10%;color: #868282;">
            <div>�����������0��30�֣����0��</div>
            <div>������Ŀ����ɵ�40�֣����0��</div>
            <div>���Ϲ�����ʡ�50%��30�֣����0��</div>
        </div>
        <script type="text/html" id="barDemo">
            {eq name="jurisdiction" value="1"}
            <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="pass">ͨ��</a>
            {/eq}
            <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">ɾ��</a>
        </script>
        <script type="text/html" id="adminTpl">
            {{#  if(d.admin_id === 0){ }}
            <span style="color: red;">δ���</span>
            {{#  } else { }}
            <span style="color: green;">�Ѵ��</span>
            {{#  } }}
        </script>
        <script type="text/html" id="isTpl">
            {{#  if(d.manager_id === 0){ }}
            <span style="color: red;">δ���</span>
            {{#  } else { }}
            <span style="color: green;">�Ѵ��</span>
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
        base: './' //�˴�·�������д���, ����ʹ�þ���·��
    }).extend({
        formSelects: 'formSelects-v4'
    });
    //���ڷ�Χ

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
                title:"����ڲ�ѯ",
                type: 2,
                content: "/rackstage/Plan/xu?id="+1,
                area: ['100%', '100%'],
                maxmin: true
            });
            layer.full(index);
        })
        layui.formSelects.opened('select7_1', function (id) {
            console.log(layui.formSelects.value('select7_0', 'val'));
            val = layui.formSelects.value('select7_0', 'val');    //ȡֵval�ַ���
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
        /*������ʼ*/
        var $ = layui.$, active = {
            reload: function () {
                var demoReload = $('#search_field');
                //ִ������
                table.reload('test', {
                    url: '/rackstage/Plan/employee_search'
                    , page: {
                        curr: 1 //���´ӵ� 1 ҳ��ʼ
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
        /*��������*/
        //#���end
        //�༭��񹤾�
        table.on('edit(test)', function (obj) {
            var value = obj.value //�õ��޸ĺ��ֵ
                , data = obj.data //�õ����������м�ֵ
                , field = obj.field; //�õ��ֶ�
            // layer.msg('[ID: '+ data.id +'] ' + field + ' �ֶθ���Ϊ��'+ value);
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
                layer.confirm('���ɾ��ô', function(index){
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
                layer.confirm('ȷ��ͨ����', function(index){
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
                title: "���/�༭",
                area: ['700px', '500px'],
                maxmin: true,
                content: '/rackstage/Plan/add_user',
                btn: ['����', '�ر�'],
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
                end: function() { //�˴�������ʾ
                }
            });
        });
    });


</script>