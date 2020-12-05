<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>考试班型列表</title>
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
                <div class="layui-card-header">考试班型列表</div>
                <div class="layui-card-body">

                    <form class="" id="table-search-form" style="margin-bottom: 10px;">
                        <div class="layui-inline">
                            <label>
                                <input class="layui-input" name="like|name" autocomplete="off" placeholder="考试班型名称">
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

                    <script type="text/html" id="table-toolbar">
                        <div class="layui-btn-container">
                            <button class="layui-btn layui-btn-sm" lay-event="select">选择</button>
                        </div>
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
            class_types_data: '{{ route_uri('students.class_types.data') }}',
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
            defaultToolbar: false,
            url: route(routes.students.class_types_data),
            cols: [[
                {type: 'radio'},
                {field:'examination', align:'center', title: '考试名称'},
                {field:'name', align:'center', title: '班型名称'},
                {field:'is_agreement_class', align:'center', title: '协议班', templet:function(data){
                    return '1' === data.is_agreement_class ? '是' : '否';
                }},
                {field:'total_tuition', align:'center', title: '学费'},
            ]],
            page: true,
            limit: 14,
            limits: [5, 14, 28, 50]
        });

        table.on('toolbar(data-table)', function(obj){
            let checkStatus = table.checkStatus(obj.config.id);
            switch (obj.event) {
                case 'select': {
                    parent.window.class_type = (checkStatus.data)[0];
                    parent.layer.close(parent.layer.getFrameIndex(window.name));
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
