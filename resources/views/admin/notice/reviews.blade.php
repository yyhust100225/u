<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>审核要讯列表</title>
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
                <div class="layui-card-header">待审核要讯</div>
                <div class="layui-card-body">

                    <form class="" id="table-search-form" style="margin-bottom: 10px;">

                        <div class="layui-inline">
                            <label>
                                <input class="layui-input" name="title" autocomplete="off" placeholder="要讯名称">
                            </label>
                        </div>

                        <button type="button" class="layui-btn" data-type="reload">搜索</button>
                    </form>

                    <table class="layui-hide" id="data-table" lay-filter="data-table"></table>

                    <script type="text/html" id="table-toolbar">
                        <div class="layui-btn-container">
                            <button class="layui-btn layui-btn-sm" lay-event="refresh" ><i class="layui-icon layui-icon-refresh-3"></i></button>
                        </div>
                    </script>

                    <script type="text/html" id="table-bar">
                        <a class="layui-btn layui-btn-warm layui-btn-xs" lay-event="show">查看</a>
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
        notices: {
            data: '{{ route_uri('notices.reviews.data') }}',
            show: '{{ route_uri('notices.show') }}',
        }
    };

    layui.config({
        base: '../../../layuiadmin/' //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
    }).use(['index', 'table', 'layer'], function(){
        let table = layui.table;
        let layer = layui.layer;
        let $ = layui.$, active;

        //方法级渲染
        table.render({
            elem: '#data-table',
            id: 'data-table',
            toolbar: '#table-toolbar',
            url: route(routes.notices.data),
            cols: [[
                {field:'id', title: 'ID', width:'4%', sort: true, fixed: 'left'},
                {field:'title', title: '要讯标题'},
                {field:'notice_type_name', title: '类型', width:'20%'},
                {field:'notice_time', title: '持续时间', width:'12%'},
                {field:'notice_creator', title: '创建人', width:'8%'},
                {field:'status', title: '状态', width: '6%', templet: function(data){
                    switch(data.status) {
                        case {{ NOTICE_SAVED }}: return '<span style="color: #20B2AA">已保存</span>';
                        case {{ NOTICE_SUBMITTED }}: return '<span style="color: #00BFFF">已提交</span>';
                        case {{ NOTICE_VIEWED }}: return '<span style="color: #008080">已查看</span>';
                        case {{ NOTICE_APPROVED }}: return '<span style="color: #6495ED">审核通过</span>';
                        case {{ NOTICE_REJECT }}: return '<span style="color: #EE0000">审核驳回</span>';
                    }
                }},
                {field:'created_at', title: '创建时间', width:'15%'},
                {fixed: 'right', title: '操作', width:120, align:'center', toolbar: '#table-bar'}
            ]],
            page: true,
            limit: 14,
            limits: [5, 14, 28, 50]
        });

        table.on('toolbar(data-table)', function(obj){
            switch (obj.event) {
                case 'refresh': {
                    table.reload('data-table');
                }break;
                default: break;
            }
        });

        table.on('tool(data-table)', function(obj){
            switch (obj.event) {
                case 'show': {
                    makeLayerForm(layer, '{{ trans('tips.layer form title') }}', route(routes.notices.show, {id: obj.data.id}), function(){
                        table.reload('data-table');
                    });
                }break;
                default:break;
            }
        });

        active = {
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
