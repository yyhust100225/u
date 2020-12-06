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
                            <input class="layui-input" name="like|name" autocomplete="off" placeholder="学员信息名称">
                        </div>

                        <button type="button" class="layui-btn" data-type="reload">搜索</button>
                    </form>

                    <table class="layui-hide" id="data-table" lay-filter="data-table"></table>

                    <script type="text/html" id="table-toolbar">
                        <div class="layui-btn-container">
                            <button class="layui-btn layui-btn-sm" lay-event="search">新增学员信息</button>
                            <button class="layui-btn layui-btn-sm" lay-event="refresh" ><i class="layui-icon layui-icon-refresh-3"></i></button>
                        </div>
                    </script>

                    <script type="text/html" id="table-bar">
                        <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="payment">缴费</a>
                        <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
                        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="delete">删除</a>
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
    var routes = {
        students: {
            data: '{{ route_uri('students.data') }}',
            search: '{{ route_uri('students.search') }}',
            edit: '{{ route_uri('students.edit') }}',
            delete: '{{ route_uri('students.delete') }}',
            payment: '{{ route_uri('students.payment') }}',
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
            url: route(routes.students.data),
            cols: [[
                { align :"center",title:"学员信息",colspan:2},
                { align :"center",title:"报班信息",colspan:5},
                // { align :"center",title:"缴费信息",colspan:14}
                {field:'created_at', align:'center', title: '创建时间', width:'12%', rowspan: 2},
                {fixed: 'right', title: '操作', width:180, align:'center', toolbar: '#table-bar', rowspan: 2}
            ],[
                // {field:'id', title: 'ID', width:'4%', sort: true, fixed: 'left'},
                {field:'name', align:'center', title: '学员姓名'},
                {field:'mobile', align:'center', title: '学员电话'},
                {field:'examination_and_class_type', align:'center', title: '考试+班型'},
                {field:'class_detail', align:'center', title: '报班明细'},
                {field:'class_open_date', align:'center', title: '开课日期'},
                {field:'', align:'center', title: '是否入班', templet: function(data){
                    return '未入班';
                }},
                {field:'', align:'center', title: '班级名称'},
            ]],
            page: true,
            limit: 14,
            limits: [5, 14, 28, 50]
        });

        table.on('toolbar(data-table)', function(obj){
            switch (obj.event) {
                case 'search': {
                    makeLayerForm(layer, '{{ trans('tips.layer form title') }}', route(routes.students.search));
                }break;
                case 'refresh': {
                    table.reload('data-table');
                }break;
                default: break;
            }
        });

        table.on('tool(data-table)', function(obj){
            switch (obj.event) {
                case 'edit': {
                    makeLayerForm(layer, '{{ trans('tips.layer form title') }}', route(routes.students.edit, {id: obj.data.id}));
                }break;
                case 'delete': {
                    layer.confirm('{{ trans('tips.table delete confirm') }}', function(index){
                        $.ajax({
                            type: 'DELETE',
                            url: route(routes.students.delete),
                            data: {id: obj.data.id},
                            dataType: 'json',
                            async: false,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(res){
                                if(res.code === {{ REQUEST_SUCCESS }}){
                                    layer.msg(res.message, {time: 1000}, function(){
                                        obj.del();
                                    });
                                }
                            }, error: function(e){
                                if(e.status === 404)
                                    layer.msg(e.responseJSON.message);
                            }
                        });
                        layer.close(index);
                    });
                }break;
                case 'payment': {
                    makeLayerForm(layer, '{{ trans('tips.layer form title') }}', route(routes.students.payment, {id: obj.data.id}));
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
