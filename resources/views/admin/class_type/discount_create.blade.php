<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Layui</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="{{ asset('layuiadmin/layui/css/layui.css') }}" media="all">
    <link rel="stylesheet" href="{{ asset('layuiadmin/style/admin.css') }}" media="all">
    <link rel="stylesheet" href="{{ asset('layuiadmin/style/app.css') }}" media="all">
</head>
<body>

<div class="layui-fluid">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-header">创建新班型优惠</div>
                <div class="layui-card-body">
                <form class="layui-form" action="">
                    @csrf
                    <div class="layui-form-item">
                        <div class="layui-col-md6">
                            <label class="layui-form-label" for="name">班型优惠名称</label>
                            <div class="layui-input-block">
                                <input type="text" class="layui-input" name="name" id="name" placeholder="请输入班型优惠名称" />
                            </div>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <div class="layui-col-md6">
                            <label class="layui-form-label" for="amount">班型优惠金额</label>
                            <div class="layui-input-block">
                                <input type="text" class="layui-input" name="amount" id="amount" placeholder="请输入班型优惠金额" />
                            </div>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label" for="start-date">生效日期</label>
                        <div class="layui-input-inline">
                            <input readonly="readonly" type="text" class="layui-input" name="start_date" id="start-date" placeholder="优惠生效开始日期" />
                        </div>
                        <div class="layui-form-mid">-</div>
                        <div class="layui-input-inline">
                            <label for="end-date"></label>
                            <input readonly="readonly" type="text" class="layui-input" name="end_date" id="end-date" placeholder="优惠生效结束日期" />
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <div class="layui-col-md3">
                            <label class="layui-form-label" for="status">班型优惠状态</label>
                            <div class="layui-input-block">
                                <input type="radio" name="status" id="status" value="1" title="启用" checked />
                                <input type="radio" name="status" id="status" value="0" title="停用" />
                            </div>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label" for="remark">备注</label>
                        <div class="layui-input-block">
                            <textarea class="layui-textarea" name="remark" id="remark" placeholder="请输入班型优惠备注"></textarea>
                        </div>
                    </div>

                    <hr>

                    <div class="layui-form-item">
                        <div class="layui-input-block">
                            <input type="hidden" name="type_id" value="{{ $type_id }}" />
                            <button lay-submit class="layui-btn" lay-filter="form-submit">立即提交</button>
                            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                        </div>
                    </div>
                </form>
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
        class_type_discounts: {
            store: '{{ route_uri('class_type_discounts.store') }}',
        }
    };

    layui.use(['form', 'laydate'], function(){
        let form = layui.form;
        let laydate = layui.laydate;
        let $ = layui.$;

        laydate.render({
            elem: '#start-date',
            type: 'date',
            trigger: 'click'
        });

        laydate.render({
            elem: '#end-date',
            type: 'date',
            trigger: 'click'
        });

        form.on('submit(form-submit)', function(obj){
            $.ajax({
                type: 'POST',
                url: route(routes.class_type_discounts.store),
                data: obj.field,
                dataType: 'json',
                async: false,
                success: function(res){
                    if(res.code === {{ REQUEST_SUCCESS }}) {
                        let index = parent.layer.getFrameIndex(window.name);
                        layer.msg(res.message, {time: 1000}, function(){
                            parent.layer.close(index);
                            parent.active.reload.call(this);
                        });
                    }
                }, error: function(e){
                    if(e.status === 422) {
                        $.each(e.responseJSON.errors, function(k,v){
                            layer.msg(v[0]);
                            return false;
                        });
                    }
                    else if(e.status === 419 || e.status === 401) {
                        layer.msg(e.responseJSON.message, {time: 1000}, function(){
                            parent.parent.window.location = "{{ route('login.form') }}";
                        });
                    }
                    else {
                        layer.msg(e.responseJSON.message);
                    }
                }
            });
            return false;
        });
    });
</script>

</body>
</html>
