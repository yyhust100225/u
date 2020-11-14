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
                <div class="layui-card-header">编辑学员</div>
                <div class="layui-card-body">
                <form class="layui-form" action="">
                    @csrf
                    <div class="layui-form-item">
                        <label class="layui-form-label" for="name">学员姓名</label>
                        <div class="layui-input-inline">
                            <input type="text" name="name" value="{{ $tq_student->name }}" id="name" autocomplete="off" placeholder="请输入学员姓名" class="layui-input">
                        </div>

                        <label class="layui-form-label" for="mobile">性别</label>
                        <div class="layui-input-inline">
                            <input type="radio" @if($tq_student->gender == 1) checked @endif name="gender" value="1" id="gender" title="男" />
                            <input type="radio" @if($tq_student->gender == 2) checked @endif name="gender" value="2" id="gender" title="女" />
                        </div>

                        <label class="layui-form-label" for="mobile">手机</label>
                        <div class="layui-input-inline">
                            <input type="text" name="mobile" value="{{ $tq_student->mobile }}" id="mobile" autocomplete="off" placeholder="请输入手机号" class="layui-input">
                        </div>

                        <label class="layui-form-label" for="telephone">联系方式</label>
                        <div class="layui-input-inline">
                            <input type="text" name="telephone" value="{{ $tq_student->telephone }}" id="telephone" autocomplete="off" placeholder="请输入联系方式" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label" for="address">现住址</label>
                        <div class="layui-input-block">
                            <input type="text" name="name" value="{{ $tq_student->address }}" id="address" autocomplete="off" placeholder="请输入现住址" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label" for="qq">QQ号</label>
                        <div class="layui-input-inline">
                            <input type="text" name="qq" value="{{ $tq_student->qq }}" id="qq" autocomplete="off" placeholder="请输入QQ号" class="layui-input">
                        </div>

                        <label class="layui-form-label" for="wechat">微信</label>
                        <div class="layui-input-inline">
                            <input type="text" name="wechat" value="{{ $tq_student->wechat }}" id="wechat" autocomplete="off" placeholder="请输入微信" class="layui-input">
                        </div>

                        <label class="layui-form-label" for="level">学员等级</label>
                        <div class="layui-input-inline">
                            <select name="level" id="level">
                                <option @if($tq_student->level == 1) selected @endif value="1">1</option>
                                <option @if($tq_student->level == 2) selected @endif value="2">2</option>
                                <option @if($tq_student->level == 3) selected @endif value="3">3</option>
                                <option @if($tq_student->level == 4) selected @endif value="4">4</option>
                                <option @if($tq_student->level == 5) selected @endif value="5">5</option>
                            </select>
                        </div>

                        <label class="layui-form-label" for="department-id">所属部门</label>
                        <div class="layui-input-inline">
                            <select name="department_id" id="department-id">
                                @foreach($departments as $department)
                                    <option @if($tq_student->department_id == $department->id) selected @endif value="{{ $department->id }}">{{ $department->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label" for="address">现住址</label>
                        <div class="layui-input-block">
                            <input type="text" name="name" value="{{ $tq_student->address }}" id="address" autocomplete="off" placeholder="请输入现住址" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <div class="layui-input-block">
                            <input type="hidden" name="id" value="{{ $tq_student->id }}">
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
        TQ_students: {
            update: '{{ route_uri('TQ_students.update') }}',
        }
    };

    layui.use(['form'], function(){
        let form = layui.form;
        let $ = layui.$;

        form.on('submit(form-submit)', function(obj){
            $.ajax({
                type: 'PUT',
                url: route(routes.TQ_students.update),
                data: obj.field,
                dataType: 'json',
                async: false,
                success: function(res){
                    if(res.code === {{ REQUEST_SUCCESS }}) {
                        var index = parent.layer.getFrameIndex(window.name);
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
