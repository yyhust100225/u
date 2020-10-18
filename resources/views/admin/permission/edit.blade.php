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
                <div class="layui-card-header">创建新权限</div>
                <div class="layui-card-body">
                    <form class="layui-form" action="">
                        @csrf
                        <div class="layui-form-item">
                            <label class="layui-form-label">权限名称</label>
                            <div class="layui-input-block">
                                <input type="text" name="name" value="{{ $permission->name }}" autocomplete="off" placeholder="请输入权限名称" class="layui-input">
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">权限控制器</label>
                            <div class="layui-input-block">
                                <input type="text" name="controller" value="{{ $permission->controller }}" autocomplete="off" placeholder="请输入权限控制器" class="layui-input">
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">权限方法</label>
                            <div class="layui-input-block">
                                <input type="text" name="action" value="{{ $permission->action }}" autocomplete="off" placeholder="请输入权限方法" class="layui-input">
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">权限等级</label>
                            <div class="layui-input-inline">
                                <select name="level">
                                    <option @if($permission->level == 1) selected @endif value="1">禁止</option>
                                    <option @if($permission->level == 2) selected @endif value="2">验证</option>
                                    <option @if($permission->level == 3) selected @endif value="3">通行</option>
                                </select>
                            </div>
                        </div>

                        <div class="layui-form-item layui-form-text">
                            <label class="layui-form-label">权限备注</label>
                            <div class="layui-input-block">
                                <textarea placeholder="请输入权限备注" name="remark" class="layui-textarea">{{ $permission->remark }}</textarea>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <div class="layui-input-block">
                                <input type="hidden" name="id" value="{{ $permission->id }}" />
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
        permissions: {
            list: '{{ route_uri('permissions.list') }}',
            update: '{{ route_uri('permissions.update') }}',
        }
    };

    layui.use(['form'], function(){
        var form = layui.form;
        var $ = layui.$;

        form.on('submit(form-submit)', function(obj){
            $.ajax({
                type: 'PUT',
                url: route(routes.permissions.update),
                data: obj.field,
                dataType: 'json',
                async: false,
                success: function(res){
                    if(res.code === {{ REQUEST_SUCCESS }}) {
                        if(res.code === {{ REQUEST_SUCCESS }}) {
                            var index = parent.layer.getFrameIndex(window.name);
                            layer.msg(res.message, {time: 1000}, function(){
                                parent.layer.close(index);
                            });
                        } else {
                            layer.msg(res.message);
                        }
                    } else {
                        layer.msg(res.message);
                    }
                }, error: function(e){
                    if(e.status === 422) {
                        $.each(e.responseJSON.errors, function(k,v){
                            layer.msg(v[0]);
                            return false;
                        });
                    }
                    else {
                        console.log(e);
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
