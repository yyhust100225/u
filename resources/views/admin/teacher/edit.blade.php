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
                <div class="layui-card-header">编辑新讲师</div>
                <div class="layui-card-body">
                    <form class="layui-form" action="">
                        @csrf
                        <div class="layui-form-item">
                            <label class="layui-form-label" for="name">讲师姓名</label>
                            <div class="layui-input-inline">
                                <input type="text" name="name" value="{{ $teacher->name }}" id="name" autocomplete="off" placeholder="请输入讲师名称" class="layui-input">
                            </div>

                            <label class="layui-form-label" for="nickname">讲师艺名</label>
                            <div class="layui-input-inline">
                                <input type="text" name="nickname" value="{{ $teacher->nickname }}" id="nickname" autocomplete="off" placeholder="请输入讲师艺名" class="layui-input">
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <div class="layui-col-md6">
                                <label class="layui-form-label" for="tel">联系方式</label>
                                <div class="layui-input-block">
                                    <input type="text" name="tel" value="{{ $teacher->tel }}" id="tel" autocomplete="off" placeholder="请输入讲师联系方式" class="layui-input">
                                </div>
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <div class="layui-col-md6">
                                <label class="layui-form-label" for="course-fee-id">课时费</label>
                                <div class="layui-input-block">
                                    <select name="course_fee_id" id="course-fee-id">
                                        <option value="">请选择讲师课时费</option>
                                        @foreach($course_fees as $course_fee)
                                            <option @if($teacher->course_fee_id == $course_fee->id) selected @endif value="{{ $course_fee->id }}">{{ $course_fee->name }} : {{ $course_fee->fee }}元</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <div class="layui-col-md6">
                                <label class="layui-form-label" for="teacher-group-id">讲师分组</label>
                                <div class="layui-input-block">
                                    <select name="teacher_group_id" id="teacher-group-id">
                                        <option value="">请选择讲师分组</option>
                                        @foreach($teacher_groups as $teacher_group)
                                            <option @if($teacher->teacher_group_id == $teacher_group->id) selected @endif value="{{ $teacher_group->id }}">{{ $teacher_group->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <div class="layui-col-md8">
                                <label class="layui-form-label" for="remark">备注</label>
                                <div class="layui-input-block">
                                    <textarea class="layui-textarea" name="remark" id="remark">{{ $teacher->remark }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <div class="layui-input-block">
                                <input type="hidden" name="id" value="{{ $teacher->id }}">
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
        teachers: {
            list: '{{ route_uri('teachers.list') }}',
            update: '{{ route_uri('teachers.update') }}',
        }
    };

    layui.use(['form'], function(){
        var form = layui.form;
        var $ = layui.$;

        form.on('submit(form-submit)', function(obj){
            $.ajax({
                type: 'PUT',
                url: route(routes.teachers.update),
                data: obj.field,
                dataType: 'json',
                async: false,
                success: function(res){
                    if(res.code === {{ REQUEST_SUCCESS }}) {
                        let index = parent.layer.getFrameIndex(window.name);
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
