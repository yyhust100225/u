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
                <div class="layui-card-header">编辑新角色</div>
                <div class="layui-card-body">
                <form class="layui-form" action="">
                    @csrf
                    <div class="layui-form-item">
                        <label class="layui-form-label">角色名称</label>
                        <div class="layui-input-block">
                            <input type="text" value="{{ $role->name }}" name="name" autocomplete="off" placeholder="请输入角色名称" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">角色状态</label>
                        <div class="layui-input-block">
                            <input value="1" type="checkbox" @if($role->status == 1)checked=""@endif name="status" lay-skin="switch" lay-text="启用|禁用">
                        </div>
                    </div>

                    <div class="layui-form-item layui-form-text">
                        <label class="layui-form-label">角色备注</label>
                        <div class="layui-input-block">
                            <textarea placeholder="请输入角色备注" name="remark" class="layui-textarea">{{ $role->remark }}</textarea>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <div class="layui-input-block">
                            <input type="hidden" name="id" value="{{ $role->id }}" class="layui-input">
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
    layui.use(['form'], function(){
        var form = layui.form;
        var $ = layui.$;

        form.on('submit(form-submit)', function(obj){
            $.ajax({
                type: 'PUT',
                url: "{{ route('roles.update') }}",
                data: obj.field,
                dataType: 'json',
                async: false,
                success: function(res){
                    if(res.code === {{ REQUEST_SUCCESS }}) {
                        layer.msg(res.message, {time: 1000}, function(){
                            window.location.href = "{{ route('roles.list') }}";
                        });
                    } else {
                        layer.msg(res.message);
                    }
                }, error: function(e){

                }
            });
            return false;
        });
    });
</script>

</body>
</html>
