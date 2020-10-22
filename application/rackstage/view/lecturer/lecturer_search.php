{include file="public/header" /}
<div class="layui-body">
    <div class="layui-main">
    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 30px;">
        <legend>讲师记录查询</legend>
    </fieldset>
    <form class="layui-form" action="" id="formid"  style="margin-top: 20px;">


        <div class="layui-form-item">
            <label class="layui-form-label">时间范围</label>
            <div class="layui-input-inline">
                <input type="text"  id="time_code"  name="time_code" value=""  placeholder="请选择" class="layui-input">
            </div>
            <div class="layui-inline layui-word-aux"></div>
        </div>


        <div class="layui-form-item">
            <label class="layui-form-label">分组依据</label>
            <div class="layui-input-block">
                <input type="radio" name="area" value="1" title="地区" checked>
                <input type="radio" name="area" value="-1" title="课程">
                <input type="radio" name="area" value="2" title="岗位">
                <input type="radio" name="area" value="3" title="姓名">

            </div>
            <div class="layui-inline layui-word-aux">

            </div>
        </div>
		<div class="layui-form-item" id="haha">
            <label class="layui-form-label">选择讲师</label>
            <div class="layui-input-inline">
                <select name="lecturer" id="lecturer" lay-filter="lecturer" lay-search>
                    <option value="">请选择</option>
                    {volist name="lecturer" id="vo"}
                    <option value="{$vo.id}">{$vo.username}</option>
                    {/volist}
                </select>
            </div>
        </div>

        <div class="layui-form-item" id="xixi">
            <label class="layui-form-label">选择岗位</label>
            <div class="layui-input-inline">
                <select name="posts" id="posts" lay-filter="lecturer" lay-search>
                    <option value="">请选择</option>
                    {volist name="posts" id="vo"}
                    <option value="{$vo.posts}">{$vo.posts}</option>
                    {/volist}
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label"></label>
            <div class="layui-input-block">
                <span class="layui-btn" id="statistics" >查询</span>
            </div>
        </div>

    </form>
        <table class="layui-hide"  lay-filter="test" id="test"></table>
    </div>
</div>
<script src="/public/layui/layui.js" charset="utf-8"></script>
<script>
        layui.use(['layer','table', 'form','element','laydate','jquery'], function(){
            var table = layui.table
                ,layer = layui.layer
                ,$=layui.jquery
                ,form = layui.form
                ,laydate = layui.laydate;
            laydate.render({
                elem: '#time_code'
                ,range: true
            });
            $().ready(function(){
                $("#xixi").hide();
            })

 form.on("radio", function (data) {
       var sex = data.value;
        if (this.value == '2') { 
             $("#xixi").show();
                    $("#haha").hide();
        } else{ 
            $("#haha").show();
                    $("#xixi").hide();
        } 
    });

            //触发搜索
            $(document).on('click','#statistics',function(){
                //部门和岗位不能为空，课程二级分类不能为空
                var time_code=$('#time_code').val()//岗位
                var area=$("input[name='area']:checked").val();//岗位

                var lecturer=$('#lecturer').val();
                var posts=$('#posts').val();
console.log(lecturer);

                if(time_code == ''){
                    layer.msg('请输入筛选条件！',{icon:0});
                    return false;
                }



                table.render({
                    id: 'test'
                    ,toolbar: true
                    ,elem: '#test'
                    , url: 'lecturer_search'
                    ,method:'post'
                    ,where: {
                        time_code: time_code
                        ,area: area
                        ,lecturer: lecturer
                        ,posts:posts
                    }

                    , cols: [[
                        {type:'numbers',  title: '编号'}
                        ,{field:'area', align:'center',  title: '地区标签', sort: true}
                        ,{field:'classify', align:'center',  title: '课程分类'}
                        ,{field:'username', align:'center',  title: '姓名'}
                        ,{field:'station',  align:'center',  title: '岗位'}
                        ,{field:'work_id',  align:'center',  title: '工号'}
                        ,{field:'classnum', align:'center',  title: '上课次数'}
                        ,{field:'classtime',  align:'center',  title: '上课时长'}




                    ]]
                });
            });



        })

</script>
{include file="public/footer" /}