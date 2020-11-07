<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>考试优惠列表</title>
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
                <div class="layui-card-header">考试优惠列表</div>
                <div class="layui-card-body">

                    <form class="layui-form" id="table-search-form" style="margin-bottom: 10px;">

                        <div class="layui-form-item">
                            <div class="layui-input-inline">
                                <label>
                                    <select name="discount_type_id" id="discount-type-id">
                                        <option value="">请选择优惠类型查询</option>
                                        @foreach($types as $type)
                                            @if($type->pid === 0)
                                                <optgroup label="{{ $type->name }}"></optgroup>
                                            @else
                                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </label>
                            </div>

                            <div class="layui-inline search-form-buttons">
                                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                                <button type="button" class="layui-btn search-btn" data-type="reload">搜索</button>
                            </div>
                        </div>
                    </form>

                    <table class="layui-hide" id="data-table" lay-filter="data-table"></table>

                    <script type="text/html" id="table-toolbar">
                        <div class="layui-btn-container">
                            <button class="layui-btn layui-btn-sm" lay-event="create">新增考试优惠</button>
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
    let routes = {
        class_examination_discounts: {
            data: '{{ route_uri('class_examination_discounts.data') }}',
            create: '{{ route_uri('class_examination_discounts.create') }}',
            edit: '{{ route_uri('class_examination_discounts.edit') }}',
            delete: '{{ route_uri('class_examination_discounts.delete') }}',
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

        let examination_id = {{ $examination_id }};
        //方法级渲染
        table.render({
            elem: '#data-table',
            id: 'data-table',
            toolbar: '#table-toolbar',
            url: route(routes.class_examination_discounts.data),
            where: {examination_id: examination_id},
            cols: [[
                // {field:'id', title: 'ID', width:'4%', sort: true, fixed: 'left'},
                {field:'type_name', align:'center', title: '优惠名称'},
                {field:'amount', align:'center', title: '优惠金额'},
                {field:'status', align:'center', width:'4%', title: '状态', templet: function(data){
                        if(data.status === 0) {
                            return '<span style="color:red">关闭</span>';
                        } else {
                            return '<span style="color:forestgreen">启用</span>';
                        }
                    }},
                {field:'user', align:'center', width:'8%', title: '录入人'},
                {field:'created_at', align:'center', width:'12%', title: '创建时间'},
                {fixed:'right', title: '操作', width: '12%', align:'center', toolbar: '#table-bar'}
            ]],
            page: true,
            limit: 14,
            limits: [5, 14, 28, 50]
        });

        table.on('toolbar(data-table)', function(obj){
            switch (obj.event) {
                case 'create': {
                    makeLayerForm(layer, '{{ trans('tips.layer form title') }}', route(routes.class_examination_discounts.create, {examination_id: examination_id}));
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
                    makeLayerForm(layer, '{{ trans('tips.layer form title') }}', route(routes.class_examination_discounts.edit, {id: obj.data.id}));
                }break;
                case 'delete': {
                    layer.confirm('{{ trans('tips.table delete confirm') }}', function(index){
                        $.ajax({
                            type: 'DELETE',
                            url: route(routes.class_examination_discounts.delete),
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
