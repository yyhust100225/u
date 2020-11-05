<!DOCTYPE html>
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
                <div class="layui-card-header">审核要讯</div>
                <div class="layui-card-body">
                    <form class="layui-form layui-form-pane" action="">
                        @csrf
                        <div class="layui-form-item">
                            <label class="layui-form-label" for="title">标题</label>
                            <div class="layui-input-block">
                                <input type="text" readonly="readonly" id="title" value="{{ $notice->title }}" class="layui-input">
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label" for="departments">抄送部门</label>
                            <div class="layui-input-block">
                                <input type="text" readonly="readonly" id="departments" value="{{ $departments }}" class="layui-input">
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label" for="roles">抄送角色</label>
                            <div class="layui-input-block">
                                <input type="text" readonly="readonly" id="roles" value="{{ $roles }}" class="layui-input">
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label" for="users">抄送用户</label>
                            <div class="layui-input-block">
                                <input type="text" readonly="readonly" id="users" value="{{ $users }}" class="layui-input">
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label" for="notice-type">要讯类型</label>
                            <div class="layui-input-block">
                                <div class="layui-col-md6">
                                    <input type="text" readonly="readonly" id="notice-type" value="{{ $notice->notice_type->name }}" class="layui-input">
                                </div>
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <div class="layui-inline">
                                <label class="layui-form-label" for="start-time">开始日期</label>
                                <div class="layui-input-inline">
                                    <input type="text" readonly="readonly" id="start-time" value="{{ $notice->start_time }}" class="layui-input" />
                                </div>
                                <div class="layui-form-mid">-</div>
                                <label class="layui-form-label" for="end-time">结束日期</label>
                                <div class="layui-input-inline">
                                    <input type="text" readonly="readonly" id="end-time" value="{{ $notice->end_time }}" class="layui-input" />
                                </div>
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label" for="file">附件</label>
                            <div class="layui-input-block">
                                <div class="layui-col-md2">
                                    <input type="text" readonly="readonly" id="file" value="{{ !is_null($notice->file) ? $notice->file->name : '无' }}" class="layui-input" />
                                </div>
                                @if(!is_null($notice->file))
                                    <a class="layui-btn" style="margin-left: 10px;" href="{{ route('file.download', ['id' => $notice->file->id]) }}">
                                        <i class="layui-icon">&#xe601;</i>下载附件
                                    </a>
                                @endif
                            </div>
                        </div>

                        <div class="layui-form-item layui-form-text">
                            <label class="layui-form-label" for="content">要讯内容</label>
                            <div class="layui-input-block">
                                <div class="show-content">
                                    {!! $notice->content !!}
                                </div>
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label" for="review-remark">审批建议</label>
                            <div class="layui-input-block">
                                <input type="text" name="review_remark" id="review-remark" value="{{ $notice->review_remark }}" class="layui-input">
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <input type="hidden" name="id" value="{{ $notice->id }}">
                            <button type="button" lay-submit class="layui-btn layui-btn-normal" lay-filter="approve">审核通过</button>
                            <button type="button" lay-submit class="layui-btn layui-btn-danger" lay-filter="reject">审核驳回</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('layuiadmin/layui/layui.js') }}"></script>
<script src="{{ asset('assets/js/custom.js') }}"></script>
<script type="text/javascript">

    // 页面路由
    let routes = {
        notices: {
            approve: '{{ route_uri('notices.approve') }}',
            reject: '{{ route_uri('notices.reject') }}',
        }
    };

    layui.use(['form'], function(){
        let form = layui.form;

        // 审核通过
        form.on('submit(approve)', function(obj){
            obj.field.status = {{ NOTICE_APPROVED }};
            return formSubmit(obj.field, 'PUT', route(routes.notices.approve), {{ REQUEST_SUCCESS }});
        });

        // 审核驳回
        form.on('submit(reject)', function(obj){
            obj.field.status = {{ NOTICE_REJECT }};
            return formSubmit(obj.field, 'PUT', route(routes.notices.reject), {{ REQUEST_SUCCESS }});
        });
    });
</script>
</body>
