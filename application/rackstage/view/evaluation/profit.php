<link rel="stylesheet" href="/public/layui/formSelects-v4.css" media="all">
<link rel="stylesheet" href="_CSS_/layui.css">
<style>
    .layui-input{
        width:50%;
    }
</style>
{include file="public/header" /}

<script type="text/html" id="checkboxTp2">
    <input type="checkbox" name="status" value="{{d.status}}" lay-skin="switch" lay-text="显示|隐藏" lay-filter="sexDemo" {{
           d.status== 1 ? 'checked' : '' }}>
</script>
<div class="layui-body">
    <!-- 内容主体区域 -->
    <div style="padding: 15px;">
        <div class="demoTable">
            {if condition="$jurisdiction eq 1"}
            <!-- <div class="layui-input-inline" style="width:300px;">
                <select id="ids" lay-filter="ids" xm-select="select7_3" xm-select-skin="danger" xm-select-search="" xm-select-show-count="1">
                    <option value="">员工姓名多选</option>
                    {volist name="users" id="vo"}
                    <option value="{$vo.id}">{$vo.user_name}</option>
                    {/volist}

                </select>
            </div> -->

            <!-- <div class="layui-input-inline" style="width:300px;">
                <select id="department" lay-filter="department" xm-select="select7_0" xm-select-skin="danger" xm-select-search="" xm-select-show-count="1">
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
            </div> -->
            <div class="layui-input-inline" style="width:200px;">
                <select id="project" lay-filter="project" xm-select="select7_1" xm-select-skin="danger" xm-select-search="" xm-select-show-count="1">
                    <option value="">请选择项目</option>
                    {volist name="pro_pid" id="vo_pid"}
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
            {/if}
            <div class="layui-input-inline" style="width:200px;">
                <select name="month" lay-filter="project" xm-select="select7_4" xm-select-skin="danger"
                        xm-select-search="" xm-select-show-count="1">
                    <option value="">请选择时间</option>
                    {volist name="month" id="vo"}
                    <option value="{$vo.month}">{$vo.month}</option>
                    {/volist}
                </select>
            </div>
            <button class="layui-btn search" data-type="reload" style="">搜索</button>
                                    <button type="reset" class="layui-btn" type="button" id="reset">重置</button>

            {eq name="jurisdiction" value="2"}
<!--            <button class="layui-btn" id="calculation">理论利润</button>-->

            {/eq}
            <button class="layui-btn" id="exp">导出</button>

        </div>
        {in name="jurisdiction" value="2"}
        <fieldset class="layui-elem-field layui-field-title" style="margin-top: 50px;">
          <legend>理论利润计算</legend>
        </fieldset>
       <form class="layui-form" action="" id="formid" style="margin-top: 20px;">

       <div class="layui-form-item">
            {notempty name='this_profit.id'}
                <div class="layui-form-inline">
                    <label class="layui-form-label">项目名称</label>
                    <div class="layui-input-inline">
                        <input type="text" id="name" name="project_title" lay-verify="required"
                               value="{$this_profit.project_title|default=''}"
                               placeholder="请输入项目名称" autocomplete="off" class="layui-input" >
                    </div>
                    <input type="hidden" id="project" name="project_name" value="{$project_name|default=''}">
                </div>
                <div class="layui-form-inline">
                    <label class="layui-form-label">姓名</label>
                    <div class="layui-input-inline">
                        <input type="text" id="aims" name="username" lay-verify="required" value="{$this_profit.username|default=''}"
                               placeholder="请输入姓名" autocomplete="off" class="layui-input">
                    </div>
                </div>
            {/notempty}
       </div>
       <div class="layui-form-item">
            <div class="layui-form-inline">
                <label class="layui-form-label">成交额（万）</label>
                <div class="layui-input-inline">
                    <input type="number" id="aims" name="turnover" lay-verify="required" value="{$this_profit.turnover|default=''}"
                           placeholder="请输入成交额" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-inline">
                <label class="layui-form-label">平均代理费率(%)</label>
                <div class="layui-input-inline">
                    <input type="text" id="aims" name="agency_rate" lay-verify="required"
                           value="{$this_profit.agency_rate|default=''}"
                           placeholder="请输入平均代理费率" autocomplete="off" class="layui-input" step="0.01">
                </div>
            </div>
       </div>
       <div class="layui-form-item">
            <div class="layui-form-inline">
                <label class="layui-form-label">物业费（万）</label>
                <div class="layui-input-inline">
                    <input type="number" id="aims" name="property" lay-verify="required" value="{$this_profit.property|default=''}"
                           placeholder="请输入物业费" autocomplete="off" class="layui-input" step="0.01">
                </div>
            </div>

           <div class="layui-form-inline">
               <label class="layui-form-label">保证金扣款</label>
               <div class="layui-input-inline">
                   <input type="number" id="aims" name="margin" lay-verify="required" value="{$this_profit.margin|default=''}"
                          placeholder="请输入保证金扣款" autocomplete="off" class="layui-input" step="0.01">
               </div>
           </div>

                    <input type="hidden" id="aims" name="margin_rate" lay-verify="required"
                           value="0"
                           placeholder="请输入保证金扣款比率" autocomplete="off" class="layui-input" step="0.01">

      </div>
       <div class="layui-form-item">
            <div class="layui-form-inline">
                <label class="layui-form-label">人员数量</label>
                <div class="layui-input-inline">
                    <input type="number" id="aims" name="number" lay-verify="required" value="{$total_number|default=''}"
                           placeholder="请输入人员数量" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-inline">
                <label class="layui-form-label">人力成本（万）</label>
                <div class="layui-input-inline">
                    <input type="number" id="aims" name="labor_costs" lay-verify="required" value="{$total_money|default=''}"
                           placeholder="请输入人力成本" autocomplete="off" class="layui-input" step="0.01">
                </div>
            </div>
      </div>
       <div class="layui-form-item">
            <div class="layui-form-inline">
                <label class="layui-form-label">二次薪(补助)（万）</label>
                <div class="layui-input-inline">
                    <input type="number" id="aims" name="second_money" lay-verify="required"
                           value="{$this_profit.second_money|default=''}"
                           placeholder="请输入二次薪(补助)" autocomplete="off" class="layui-input" step="0.01">
                </div>
            </div>
            <div class="layui-form-inline">
                <label class="layui-form-label">联代补助（万）</label>
                <div class="layui-input-inline">
                    <input type="number" id="aims" name="subsidies" lay-verify="required" value="{$this_profit.subsidies|default=''}"
                           placeholder="请输入联代补助" autocomplete="off" class="layui-input" step="0.01">
                </div>
            </div>
      </div>
      <div class="layui-form-item">
            <div class="layui-form-inline">
                <label class="layui-form-label">提成比率(%)</label>
                <div class="layui-input-inline">
                    <input type="text" id="aims" name="commission_ratio" lay-verify="required"
                           value="{$this_profit.commission_ratio|default=''}"
                           placeholder="请输入提成比率" autocomplete="off" class="layui-input" step="0.01">
                </div>
            </div>
            <div class="layui-form-inline">
                <label class="layui-form-label">其他费用（万）</label>
                <div class="layui-input-inline">
                    <input type="number" id="aims" name="else" lay-verify="required"
                           value="{$this_profit.else|default=''}"
                           placeholder="请输入其他费用" autocomplete="off" class="layui-input" step="0.01">
                </div>
            </div>
      </div>

<!--           <div class="layui-form-item">-->
<!--            <div class="layui-form-inline">-->
<!--                <label class="layui-form-label">二次薪(佣金)</label>-->
<!--                <div class="layui-input-inline">-->
<!--                    <input type="text" id="aims" name="commission_ratio" lay-verify="required"-->
<!--                           value="{$this_profit.second_money2|default=''}"-->
<!--                           placeholder="请输入提成比率" autocomplete="off" class="layui-input" step="0.01">-->
<!--                </div>-->
<!--            </div>-->
<!--           -->
<!--      </div>-->
        
      <div class="layui-form-item">
       <div class="layui-form-inline">
                <label class="layui-form-label">税费率(%)</label>
                <div class="layui-input-inline">
                    <input type="text" id="aims" name="taxes_rate" lay-verify="required"
                           value="6.4"
                           placeholder="请输入税费率" autocomplete="off" class="layui-input" step="0.01" readonly>
                </div>
            </div>
            <div class="layui-form-inline">
                <label class="layui-form-label">集团管理费率</label>
                <div class="layui-input-inline">
                    {eq name="this_profit.type|default=1" value="1"}
                    <input type="radio" name="type" value="1" title="恒大" checked>
                    <input type="radio" name="type" value="2" title="非恒大">
                    {else /}
                    <input type="radio" name="type" value="1" title="恒大">
                    <input type="radio" name="type" value="2" title="非恒大" checked>
                    {/eq}
                </div>
            </div>
      </div>
           <div class="layui-form-item">
               <div class="layui-form-inline">
                   <label class="layui-form-label">税费金额</label>
                   <div class="layui-input-inline">
                       <input type="text" id="aims" name="total_profit" lay-verify="required"
                              value="{$this_profit.taxes_money|default='等待计算'}"
                              placeholder="请输入提成比率" autocomplete="off" class="layui-input"  readonly>
                   </div>
               </div>
               <div class="layui-form-inline">
                   <label class="layui-form-label">理论结算代理费</label>
                   <div class="layui-input-inline">
                       <input type="text" id="aims" name="total_profit" lay-verify="required"
                              value="{$this_profit.agency_fees|default='等待计算'}"
                              placeholder="请输入提成比率" autocomplete="off" class="layui-input"  readonly>
                   </div>
               </div>

           </div>
           <div class="layui-form-item">
               <div class="layui-form-inline">
                   <label class="layui-form-label">二次薪（佣金）</label>
                   <div class="layui-input-inline">
                       <input type="text" id="aims" name="second_money2" lay-verify="required"
                              value="{$this_profit.second_money2|default='等待计算'}"
                              placeholder="请输入提成比率" autocomplete="off" class="layui-input"  readonly>
                   </div>
               </div>
               <div class="layui-form-inline">
                   <label class="layui-form-label">理论利润</label>
                   <div class="layui-input-inline">
                       <input type="text" id="aims" name="total_profit" lay-verify="required"
                              value="{$this_profit.total_profit|default='等待计算'}"
                              placeholder="请输入提成比率" autocomplete="off" class="layui-input"  readonly>
                   </div>
               </div>



           </div>
    {notempty name='this_profit.id'}<input type='hidden' value='{$this_profit.id}' name='id'>
        {else /}
    {/notempty}
      <div class="layui-form-block">
        <div class="layui-input-inline" style="padding-left:150px;">
          <button type="submit" class="layui-btn" lay-submit="" lay-filter="demo1">立即测算</button>
          <button type="reset" class="layui-btn layui-btn-primary">重置</button>
        </div>
      </div>
    </form>
   {/in}
        {eq name="jurisdiction" value="2"}
        {else/}
        <table class="layui-table" lay-data="{height:'',url:'profit?id=1', page:{ layout: ['limit', 'count', 'prev', 'page', 'next', 'skip'] ,curr: 1 , limit: 10  , limits: [5,10,15,20,25,30,35,40, 50, 100] , groups: 5 , first: '首页', last: '尾页' }, id:'test',cellMinWidth:120}" lay-filter="test">
            <thead>
            <tr>
                <th lay-data=" {type:'numbers', minWidth: 20, title: '编号'}">编号</th>
                <th lay-data="{field: 'username', align: 'center',width:100}" class="">姓名</th>
                <th lay-data="{field: 'project_name', align: 'center'}">项目</th>
                <th lay-data="{field: 'turnover', align: 'center'}">成交额</th>
                <th lay-data="{field: 'agency_rate', align: 'center'}">平均代理费率</th>
                <th lay-data="{field: 'property', align: 'center'}">物业费</th>
                <!--                    <th lay-data="{field: 'margin_rate', align: 'center'}">保证金扣款比率</th>-->
                <th lay-data="{field: 'margin', align: 'center'}">保证金扣款</th>
                <th lay-data="{field: 'agency_fees', align: 'center'}">理论代理费</th>
                <th lay-data="{field: 'number', align: 'center'}">人员数量</th>
                <th lay-data="{field: 'labor_costs', align: 'center'}">人力成本</th>
                <th lay-data="{field: 'second_money', align: 'center'}">二次薪(补助)</th>
                <th lay-data="{field: 'subsidies', align: 'center'}">联代补助</th>
                <th lay-data="{field: 'commission_ratio', align: 'center'}">提成比率</th>
                <th lay-data="{field: 'second_money2', align: 'center'}">二次薪(佣金)</th>
                <th lay-data="{field: 'else', align: 'center'}">其他费用</th>
                <th lay-data="{field: 'group_management_rate', align: 'center'}">集团管理费率</th>
                <th lay-data="{field: 'group_management_money', align: 'center'}">集团管理金额</th>
                <th lay-data="{field: 'taxes_rate', align: 'center'}">税费率</th>
                <th lay-data="{field: 'taxes_money', align: 'center'}">税费金额</th>
                <th lay-data="{field: 'total_profit', align: 'center'}">理论利润</th>
                <!--                     <th lay-data="{align: 'center',toolbar:'#barDemo'}">操作</th>
                 -->                </tr>
            </thead>
        </table>
        <!--  <script type="text/html" id="barDemo">
             <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="edit_profit">编辑</a>
         </script> -->
        <div id=" pages" class="text-center">
        </div>
        {/eq}

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
    layui.use(['table', 'layer', 'jquery', 'laydate'], function() {
        var table = layui.table,
            $ = layui.jquery,
            form = layui.form,
            laydate = layui.laydate,
            layer = layui.layer;
        laydate.render({
            elem: '#test6',
            range: true
        });
        $(document).on('click','#reset',function(){
            layui.formSelects.value('select7_1', [0]);
            layui.formSelects.value('select7_4', [0]);
            table.reload('test', {
                url: "profit?id=1"
                , page: {
                    curr: 1 //重新从第 1 页开始
                }
                , method: 'post'
            });
        });
     
        /*搜索开始*/
        var $ = layui.$,
            active = {
                reload: function() {
                    var demoReload = $('#search_field');
                    //执行重载
                    table.reload('test', {
                        url: "/rackstage/Profit/profit_search",
                        page: {
                            curr: 1 //重新从第 1 页开始
                        },
                        method: 'post',
                        where: {
                            project: layui.formSelects.value('select7_1', 'val'),
                            department: layui.formSelects.value('select7_0', 'val'),
                            ids: layui.formSelects.value('select7_3', 'val'),
                            date: layui.formSelects.value('select7_4', 'val'),

                        }
                    });
                    
                }
            };
        $('.demoTable .layui-btn').on('click', function() {
            var type = $(this).data('type');
            active[type] ? active[type].call(this) : '';
        });
          form.on('submit(demo1)', function(data){
            $.ajax({
                            url: "/rackstage/Profit/profit_edit",
                            type: "post",
                            dataType: "json",
                            cache: false,
                            data: {i:JSON.stringify(data.field)},
                            contentType: "application/x-www-form-urlencoded; charset=utf-8",
                            success: function(data) {
                                layer.msg(data.msg, {
                                    time: 1000
                                }, function() {
                                    //renderTable();
                                    window.location.reload();
                                });
                            }
                        });
           
            return false;
          });
         
        table.on('tool(test)', function(obj){
            var data = obj.data;
            if(obj.event === 'edit_profit'){
                console.log(data.id);
                var index = layer.open({
                    type: 2,
                    shade: [0.1],
                    title: "添加/编辑",
                    area: ['700px', '500px'],
                    maxmin: true,
                    content: '/rackstage/Profit/profit_edit?id='+data.id,
                    btn: ['保存', '关闭'],
                    zIndex: layer.zIndex,
                    yes: function(index) {
                        var row = window["layui-layer-iframe" + index].callbackdata();
                        if (!$.trim(row)) {
                            return false;
                        }
                        layer.closeAll();
                        $.ajax({
                            url: "/rackstage/Profit/profit_edit",
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

            }
        });
        $("#exp").click(function() {
            var project = layui.formSelects.value('select7_1', 'val')||''
                var department = layui.formSelects.value('select7_0', 'val')|''
                $.ajax({
                        url: "/rackstage/Profit/export",
                        type: "post",
                        dataType: "json",
                        cache: false,
                        data: {project:project,department:department},
                        contentType: "application/x-www-form-urlencoded; charset=utf-8",
                        success: function(data) {
                        
                            layer.msg(data.msg, {
                                time: 1000
                            }, function() {
                                //renderTable();
                                if(data.code==1){
                                    window.location.href=data.url
                                }
                               
                                $(".layui-laypage-btn").click()
                            });
                        }
                    });
        });
        $("#calculation").click(function() {
            var index = layer.open({
                type: 2,
                shade: [0.1],
                title: "添加/编辑",
                area: ['700px', '500px'],
                maxmin: true,
                content: '/rackstage/Profit/profit_edit',
                btn: ['保存', '关闭'],
                zIndex: layer.zIndex,
                yes: function(index) {
                    var row = window["layui-layer-iframe" + index].callbackdata();
                    if (!$.trim(row)) {
                        return false;
                    }
                    layer.closeAll();
                    $.ajax({
                        url: "/rackstage/Profit/profit_edit",
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
        $("#labor").click(function() {
            window.location.href = 'labor_costs'
        });
    });
</script>
{include file="public/footer" /}