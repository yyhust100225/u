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
                            <label class="layui-form-label" for="notice-type">要讯类型</label>
                            <div class="layui-input-block">
                                <div class="layui-col-md6">
                                    <input type="text" readonly="readonly" id="notice-type" value="{{ $notice->notice_type->name }}" class="layui-input">
                                </div>
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

        }
    };

    layui.use(['form'], function(){
        let form = layui.form;
    });
</script>
</body>
