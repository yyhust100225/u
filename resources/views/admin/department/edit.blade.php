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
                <div class="layui-card-header">编辑行政部门</div>
                <div class="layui-card-body">
                <form class="layui-form" action="">
                    @csrf
                    <div class="layui-form-item">
                        <label class="layui-form-label">部门名称</label>
                        <div class="layui-input-block">
                            <input type="text" name="name" value="{{ $department->name }}" autocomplete="off" placeholder="请输入行政部门名称" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">上级部门</label>
                        <div class="layui-input-inline">
                            <select name="p_id">
                                <option value="0">无</option>
                                @foreach($parent_departments as $parent_department)
                                    <option @if($parent_department->id == $department->p_id) selected @endif value="{{ $parent_department->id }}">{{ $parent_department->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="layui-form-item layui-form-text">
                        <label class="layui-form-label">部门备注</label>
                        <div class="layui-input-block">
                            <textarea placeholder="请输入行政部门备注" name="remark" class="layui-textarea">{{ $department->remark }}</textarea>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <div class="layui-input-block">
                            <input type="hidden" name="id" value="{{ $department->id }}">
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
        departments: {
            list: '{{ route_uri('departments.list') }}',
            update: '{{ route_uri('departments.update') }}',
        }
    };

    layui.use(['form'], function(){
        var form = layui.form;
        var $ = layui.$;

        form.on('submit(form-submit)', function(obj){
            $.ajax({
                type: 'PUT',
                url: route(routes.departments.update),
                data: obj.field,
                dataType: 'json',
                async: false,
                success: function(res){
                    if(res.code === {{ REQUEST_SUCCESS }}) {
                        var index = parent.layer.getFrameIndex(window.name);
                        layer.msg(res.message, {time: 1000}, function(){
                            parent.layer.close(index);
                        });
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
