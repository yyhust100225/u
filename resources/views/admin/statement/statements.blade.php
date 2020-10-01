<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>对账单列表</title>
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
                <div class="layui-card-header">对账单列表</div>
                <div class="layui-card-body">

                    <form class="" id="table-search-form" style="margin-bottom: 10px;">

                        <div class="layui-inline">
                            <input class="layui-input" name="name" autocomplete="off" placeholder="对账单名称">
                        </div>

                        <button type="button" class="layui-btn" data-type="reload">搜索</button>
                    </form>

                    <table class="layui-hide" id="data-table" lay-filter="data-table"></table>

                    <script type="text/html" id="table-toolbar">
                        <div class="layui-btn-container">
                            <button class="layui-btn layui-btn-sm" lay-event="create">新增对账单</button>
                            <button class="layui-btn layui-btn-sm" lay-event="refresh" ><i class="layui-icon layui-icon-refresh-3"></i></button>
                        </div>
                    </script>

                    <script type="text/html" id="table-bar">
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
        statements: {
            data: '{{ route_uri('statements.data') }}',
            create: '{{ route_uri('statements.create') }}',
            edit: '{{ route_uri('statements.edit') }}',
            delete: '{{ route_uri('statements.delete') }}',
        }
    };

    layui.config({
        base: '../../../layuiadmin/' //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
    }).use(['index', 'table', 'layer'], function(){
        let table = layui.table;
        let layer = layui.layer;
        let $ = layui.$;

        //方法级渲染
        table.render({
            elem: '#data-table',
            id: 'data-table',
            toolbar: '#table-toolbar',
            url: route(routes.statements.data),
            cols: [[
                {field:'id', title: 'ID', width:'4%', sort: true, fixed: 'left'},
                {field: 'printer_name', title: '印刷厂', width: '10%'},
                {field: 'printed_matter_name', title: '印刷品', width: '10%'},
                {field: 'applicant', title: '发稿人', width: '10%'},
                {field: 'department_name', title: '所属部门', width: '10%'},
                {field: 'publish_date', title: '发稿时间', width: '8%'},
                {field: 'print_detail', title: '印刷明细', width: '15%'},
                {field: 'quantity_print', title: '印刷品数量', width: '8%'},
                {field: 'price_print', title: '印刷品单价', width: '8%'},
                {field: 'designer_quote_price', title: '设计报价', width: '8%'},
                {field: 'printer_quote_price', title: '印刷厂报价', width: '8%'},
                {field: 'status', title: '账单状态', width: '8%', templet: function(data){
                    switch (data.status) {
                        case {{ STATEMENT_NOT_VERIFIED }}: {
                            return '<span style="color: dodgerblue">未校验</span>';
                        }break;
                        case {{ STATEMENT_VALIDATION_FAILED }}: {
                            return '<span style="color: red">校验不正确</span>';
                        }break;
                        case {{ STATEMENT_VALIDATION_SUCCESSFUL }}: {
                            return '<span style="color: limegreen">已校验</span>';
                        }break;
                    }
                }},
                {field: 'remark', title: '备注', width: '15%'},
                {field: 'created_at', title: '创建时间', width:'12%'},
                {fixed: 'right', title: '操作', width:120, align:'center', toolbar: '#table-bar'}
            ]],
            page: true,
            limit: 14,
            limits: [5, 14, 28, 50]
        });

        table.on('toolbar(data-table)', function(obj){
            switch (obj.event) {
                case 'create': {
                    makeLayerForm(layer, '{{ trans('tips.layer form title') }}', route(routes.statements.create), function(){
                        table.reload('data-table');
                    });
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
                    makeLayerForm(layer, '{{ trans('tips.layer form title') }}', route(routes.statements.edit, {id: obj.data.id}), function(){
                        table.reload('data-table');
                    });
                }break;
                case 'delete': {
                    layer.confirm('{{ trans('tips.table delete confirm') }}', function(index){
                        $.ajax({
                            type: 'DELETE',
                            url: route(routes.statements.delete),
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
                default:break;
            }
        });

        let active = {
            reload: function(){
                let data = $('#table-search-form').serialize();
                table.reload('data-table', {
                    page: {curr: 1},
                    where: {where:data, action:'search'}
                }, 'data');
            }
        };

        $('#table-search-form .layui-btn').on('click', function(){
            let type = $(this).data('type');
            active[type] ? active[type].call(this) : '';
        });
    });
</script>
</body>
</html>
