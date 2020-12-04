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
                <div class="layui-card-header">创建新科目</div>
                <div class="layui-card-body">
                <form class="layui-form" action="">
                    @csrf
                    <div class="layui-form-item">
                        <label class="layui-form-label" for="name">科目姓名</label>
                        <div class="layui-input-inline">
                            <input type="text" name="name" id="name" autocomplete="off" placeholder="请输入科目名称" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <div class="layui-col-md12">
                            <label class="layui-form-label">科目讲师</label>
                            <div class="layui-input-block">
                                @foreach($teacher_groups as $teacher_group)
                                    @if(!$teacher_group->teachers->isEmpty())
                                        <fieldset class="layui-elem-field">
                                            <legend>{{ $teacher_group->name }}</legend>
                                            <div class="layui-field-box">
                                                @foreach($teacher_group->teachers as $teacher)
                                                    <input type="checkbox" name="teacher_ids[]" value="{{ $teacher->id }}" title="{{ $teacher->name }}[{{ $teacher->course_fee->name }}:{{ $teacher->course_fee->fee }}元]">
                                                @endforeach
                                            </div>
                                        </fieldset>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <div class="layui-col-md8">
                            <label class="layui-form-label" for="remark">备注</label>
                            <div class="layui-input-block">
                                <textarea class="layui-textarea" name="remark" id="remark"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <div class="layui-input-block">
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
    let routes = {
        subjects: {
            list: '{{ route_uri('subjects.list') }}',
            store: '{{ route_uri('subjects.store') }}',
        }
    };

    layui.use(['form'], function(){
        var form = layui.form;
        var $ = layui.$;

        form.on('submit(form-submit)', function(obj){
            $.ajax({
                type: 'POST',
                url: route(routes.subjects.store),
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
