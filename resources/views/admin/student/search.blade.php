<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>学员信息列表</title>
    <meta name="renderer" content="webkit">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="{{ asset('layuiadmin/layui/css/layui.css') }}" media="all">
    <link rel="stylesheet" href="{{ asset('layuiadmin/style/admin.css') }}" media="all">
    <link rel="stylesheet" href="{{ asset('layuiadmin/style/app.css') }}" media="all">
</head>
<body>

<div class="layui-fluid">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-header">学员信息列表</div>
                <div class="layui-card-body">

                    <form class="" id="table-search-form" style="margin-bottom: 10px;">
                        <div class="layui-inline">
                            <label>
                                <input class="layui-input" name="like|name" autocomplete="off" placeholder="学员信息名称">
                            </label>
                        </div>

                        <div class="layui-inline">
                            <label>
                                <input class="layui-input" name="like|mobile" autocomplete="off" placeholder="学员手机号码">
                            </label>
                        </div>

                        <button type="button" class="layui-btn" data-type="reload">搜索</button>
                    </form>

                    <table class="layui-hide" id="data-table" lay-filter="data-table"></table>

                    <script type="text/html" id="table-bar">
                        <a class="layui-btn layui-btn-xs layui-btn-normal" lay-event="create">选择创建</a>
                    </script>

                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('layuiadmin/layui/layui.js') }}"></script>
<script src="{{ asset('assets/js/custom.js') }}"></script>
<script>

    // 页面路由
    let routes = {
        students: {
            searched: '{{ route_uri('students.searched') }}',
            create: '{{ route_uri('students.create') }}',
        }
    };

    layui.config({
        base: '../../../layuiadmin/' //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
    }).use(['index', 'table', 'layer'], function(){
        var table = layui.table;
        var layer = layui.layer;
        var $ = layui.$;

        //方法级渲染
        table.render({
            elem: '#data-table',
            id: 'data-table',
            toolbar: '#table-toolbar',
            bar: '#table-bar',
            url: route(routes.students.searched),
            cols: [[
                {field:'tq_id', align:'center', title: '学员TQID'},
                {field:'name', align:'center', title: '学员名称'},
                {field:'mobile', align:'center', title: '学员电话'},
                {align:'center', title: '是否为老学员', templet: function(data){
                    return '新学员';
                }},
                {field:'create_time', align:'center', title: '同步时间'},
                {fixed: 'right', title: '操作', width:120, align:'center', toolbar: '#table-bar'}
            ]],
            page: true,
            limit: 14,
            limits: [5, 14, 28, 50]
        });

        table.on('tool(data-table)', function(obj){
            switch (obj.event) {
                case 'create': {
                    let index = parent.layer.getFrameIndex(window.name);
                    makeLayerForm(layer, '{{ trans('tips.layer form title') }}', route(routes.students.create, {id: obj.data.id}));
                    parent.layer.close(index);
                }break;
                default:break;
            }
        });

        active = {
            reload: function(){
                var data = $('#table-search-form').serializeArray();
                table.reload('data-table', {
                    page: {curr: 1},
                    where: {where:data, action:'search'}
                }, 'data');
            }
        };

        $('#table-search-form .layui-btn').on('click', function(){
            var type = $(this).data('type');
            active[type] ? active[type].call(this) : '';
        });
    });
</script>
</body>
</html>
