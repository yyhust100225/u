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
                <div class="layui-card-header">创建新班级</div>
                <div class="layui-card-body">
                <form class="layui-form" action="">
                    @csrf
                    <div class="layui-form-item">
                        <div class="layui-col-md8">
                            <label class="layui-form-label" for="name">班级名称</label>
                            <div class="layui-input-block">
                                <input type="text" name="name" id="name" autocomplete="off" placeholder="请输入班级名称" class="layui-input">
                            </div>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <div class="layui-col-md6">
                            <label class="layui-form-label" for="class-type-id">所属班型</label>
                            <div class="layui-input-block">
                                <select name="class_type_id" id="class-type-id" lay-search>
                                    <option value="">请选择所属班型</option>
                                    @foreach($class_types as $class_type)
                                        <option value="{{ $class_type->id }}">{{ $class_type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <span class="layui-hide">hahahaha</span>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label" for="class-course-type-id">开课类型</label>
                        <div class="layui-input-inline">
                            <select name="class_course_type_id" id="class-course-type-id">
                                <option value="">请选择开课类型</option>
                                @foreach($class_course_types as $class_course_type)
                                    <option value="{{ $class_course_type->id }}">{{ $class_course_type->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <label class="layui-form-label" for="department-id">开课校区</label>
                        <div class="layui-input-inline">
                            <select name="department_id" id="department-id">
                                <option value="">请选择开课校区</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <div class="layui-col-md8">
                            <label class="layui-form-label" for="address">开课具体地点</label>
                            <div class="layui-input-block">
                                <input type="text" name="address" id="address" autocomplete="off" placeholder="请输入开课具体地点" class="layui-input">
                            </div>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <div class="layui-col-md8">
                            <label class="layui-form-label" for="class-course-date">开课具体日期</label>
                            <div class="layui-input-block">
                                <input type="text" readonly name="class_course_date" id="class-course-date" autocomplete="off" placeholder="请选择开课具体日期" class="layui-input">
                            </div>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label" for="max-person-num">封班人数</label>
                        <div class="layui-input-inline">
                            <input type="text" name="max_person_num" id="max-person-num" autocomplete="off" placeholder="请输入封班人数" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label" for="in-hotel">学员是否住宿</label>
                        <div class="layui-input-inline">
                            <input type="radio" name="in_hotel" value="0" id="in-hotel" title="否" checked lay-filter="in-hotel" />
                            <input type="radio" name="in_hotel" value="1" id="in-hotel" title="是" lay-filter="in-hotel" />
                        </div>
                    </div>

                    <div class="layui-form-item layui-hide" id="item-in-hotel-date">
                        <label class="layui-form-label" for="in-hotel-date">学员入住日期</label>
                        <div class="layui-input-inline">
                            <input type="text" readonly name="in_hotel_date" id="in-hotel-date" placeholder="请选择学员入住日期" class="layui-input" />
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <div class="layui-col-md8">
                            <label class="layui-form-label" for="remark">备注</label>
                            <div class="layui-input-block">
                                <textarea name="remark" id="remark" class="layui-textarea"></textarea>
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
        class_courses: {
            store: '{{ route_uri('class_courses.store') }}',
        }
    };

    layui.config({
        base: '/layuiadmin/layui/lay/modules/'
    }).use(['form', 'laydatePro'], function(){
        let form = layui.form;
        let laydate = layui.laydate;
        let $ = layui.$;

        laydate.render({
            elem: '#class-course-date',
            trigger: 'click',
            multiple: ',',
            theme: '#393D49'
        });

        laydate.render({
            elem: '#in-hotel-date',
            theme: '#393D49',
            type: 'date',
            trigger: 'click'
        });

        form.on('submit(form-submit)', function(obj){
            $.ajax({
                type: 'POST',
                url: route(routes.class_courses.store),
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
        form.on('radio(in-hotel)', function(data){
            if(data.value === '1') {
                $('div#item-in-hotel-date').removeClass('layui-hide');
            } else if(data.value === '0') {
                $('div#item-in-hotel-date').addClass('layui-hide');
            }
        });
    });
</script>

</body>
</html>
