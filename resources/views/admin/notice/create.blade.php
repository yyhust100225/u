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
                <div class="layui-card-header">创建新要讯</div>
                <div class="layui-card-body">
                <form class="layui-form" action="">
                    @csrf
                    <div class="layui-form-item">
                        <label class="layui-form-label" for="title">要讯名称</label>
                        <div class="layui-input-block">
                            <input type="text" name="title" id="title" autocomplete="off" placeholder="请输入要讯名称" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">抄送部门</label>
                        <div class="layui-input-block">
                            <div class="layui-col-md6">
                                <div id="departments"></div>
                            </div>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">抄送员工</label>
                        <div class="layui-input-block">
                            <div class="layui-col-md6">
                                <div id="users"></div>
                            </div>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">抄送角色</label>
                        <div class="layui-input-block">
                            <div class="layui-col-md6">
                                <div id="roles"></div>
                            </div>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label" for="start-time">开始时间</label>
                        <div class="layui-input-inline">
                            <input type="text" readonly="readonly" name="start_time" id="start-time" autocomplete="off" placeholder="内容生效开始时间" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label" for="end-time">结束时间</label>
                        <div class="layui-input-inline">
                            <input type="text" readonly="readonly" name="end_time" id="end-time" autocomplete="off" placeholder="内容生效结束时间" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label" for="notice-type-id">要讯类型</label>
                        <div class="layui-input-inline">
                            <select name="notice_type_id" id="notice-type-id">
                                @foreach($notice_types as $notice_type)
                                    <option value="{{ $notice_type->id }}">{{ $notice_type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">上传附件</label>
                        <div class="layui-input-inline">
                            <button type="button" class="layui-btn" id="upload">
                                <i class="layui-icon">&#xe67c;</i>上传图片
                            </button>
                            <span id="file-name"></span>
                            <input type="hidden" name="file_id" id="upload-file" value="0" />
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label" for="content">要讯内容</label>
                        <div class="layui-input-block">
                            <div id="content"></div>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <div class="layui-input-block">
                            <button type="button" lay-submit class="layui-btn" lay-filter="form-submit">立即提交</button>
                            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="{{ asset('layuiadmin/layui/layui.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/custom.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/xm-select.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/wangEditor.min.js') }}"></script>
<script>

    // 页面路由
    let routes = {
        notices: {
            list: '{{ route_uri('notices.list') }}',
            store: '{{ route_uri('notices.store') }}',
            upload: '{{ route_uri('file.upload') }}',
            editor_img: '{{ route_uri('file.upload.editor.image') }}',
        }
    };

    layui.use(['form', 'upload', 'laydate'], function(){
        let form = layui.form;
        let upload = layui.upload;
        let laydate = layui.laydate;
        let $ = layui.$;

        // const E = window.wangEditor;
        const editor = new window.wangEditor('#content');
        editor.config.uploadImgServer = route(routes.notices.editor_img);
        editor.config.uploadFileName = 'images';
        editor.create();

        form.on('submit(form-submit)', function(obj){
            obj.field.content = editor.txt.html();
            $.ajax({
                type: 'POST',
                url: route(routes.notices.store),
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

        let uploadInst = upload.render({
            elem: '#upload',
            url: route(routes.notices.upload),
            done: function(res){
                if(res.code === {{ REQUEST_SUCCESS }}) {
                    $('#upload-file').val(res.data.file_id);
                    $('#file-name').html(res.data.file_name);
                }
                else
                    layer.msg(res.message);
            },
            error: function(){
                //请求异常回调
            }
        });

        laydate.render({
            elem: '#start-time',
            type: 'date'
        });

        laydate.render({
            elem: '#end-time',
            type: 'date'
        });
    });

    let departments_select = xmSelect.render({
        el: '#departments',
        language: 'zn',
        filterable: true,
        autoRow: true,
        name: 'department_ids',
        data: [
            @foreach($departments as $department)
                {name: '{{ $department->name }}', value: {{ $department->id }}},
            @endforeach
        ]
    });

    let roles_select = xmSelect.render({
        el: '#roles',
        language: 'zn',
        filterable: true,
        autoRow: true,
        name: 'role_ids',
        data: [
            @foreach($roles as $role)
                {name: '{{ $role->name }}', value: {{ $role->id }}},
            @endforeach
        ]
    });

    let users_select = xmSelect.render({
        el: '#users',
        language: 'zn',
        filterable: true,
        autoRow: true,
        name: 'user_ids',
        data: [
            @foreach($users as $user)
                {name: '{{ $user->username }}', value: {{ $user->id }}},
            @endforeach
        ]
    });

</script>

</body>
</html>
