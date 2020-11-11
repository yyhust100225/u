<!DOCTYPE html>
<html lang="en">
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
                <div class="layui-card-header">创建新班型</div>
                <div class="layui-card-body">
                <form class="layui-form" action="">
                    @csrf
                    <div class="layui-form-item">
                        <div class="layui-col-md8">
                            <label class="layui-form-label" for="name">班型名称</label>
                            <div class="layui-input-block">
                                <input type="text" name="name" id="name" autocomplete="off" placeholder="请输入班型名称" class="layui-input">
                            </div>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <div class="layui-col-md6">
                            <label class="layui-form-label" for="examination-id">所属考试</label>
                            <div class="layui-input-block">
                                <select name="examination_id" id="examination-id" lay-search>
                                    <option value="">请选择班型所属考试</option>
                                    @foreach($examinations as $examination)
                                        <option value="{{ $examination->id }}">{{ $examination->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <div class="layui-col-md6">
                            <label class="layui-form-label" for="exam-type">考试形式</label>
                            <div class="layui-input-block">
                                <input type="radio" name="exam_type" id="exam-type" value="0" title="笔试" checked />
                                <input type="radio" name="exam_type" id="exam-type" value="1" title="面试" />
                                <input type="radio" name="exam_type" id="exam-type" value="2" title="笔试+面试" />
                            </div>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <div class="layui-col-md3">
                            <label class="layui-form-label" for="is-agreement-class">是否协议班</label>
                            <div class="layui-input-block">
                                <input type="radio" name="is_agreement_class" id="is-agreement-class" value="0" title="否" checked />
                                <input type="radio" name="is_agreement_class" id="is-agreement-class" value="1" title="是" />
                            </div>
                        </div>
                    </div>

                    <fieldset class="layui-elem-field" style="margin-bottom: 15px;">
                        <legend>课时长度</legend>
                        <div class="layui-field-box">
                            <div class="layui-form-item">
                                <label class="layui-form-label" for="written-examination-days">笔试白天</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="written_examination_days" id="written-examination-days" autocomplete="off" placeholder="笔试课程有几个白天" class="layui-input">
                                </div>

                                <label class="layui-form-label" for="written-examination-nights">笔试傍晚</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="written_examination_nights" id="written-examination-nights" autocomplete="off" placeholder="笔试课程有几个夜晚" class="layui-input">
                                </div>
                            </div>

                            <div class="layui-form-item">
                                <label class="layui-form-label" for="interview-days">面试白天</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="interview_days" id="interview-days" autocomplete="off" placeholder="面试课程有几个白天" class="layui-input">
                                </div>

                                <label class="layui-form-label" for="interview-nights">面试傍晚</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="interview_nights" id="interview-nights" autocomplete="off" placeholder="面试课程有几个夜晚" class="layui-input">
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    <div class="layui-form-item">
                        <div class="layui-col-md3">
                            <label class="layui-form-label" for="total-tuition">总学费</label>
                            <div class="layui-input-block">
                                <input type="text" name="total_tuition" id="total-tuition" autocomplete="off" placeholder="请输入总学费" class="layui-input">
                            </div>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <div class="layui-col-md3">
                            <label class="layui-form-label" for="per-day-tuition">每日学费</label>
                            <div class="layui-input-block">
                                <input type="text" name="per_day_tuition" id="per-day-tuition" autocomplete="off" placeholder="请输入每日学费" class="layui-input">
                            </div>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <div class="layui-col-md3">
                            <label class="layui-form-label" for="written-examination-refund">笔试退费</label>
                            <div class="layui-input-block">
                                <input type="text" name="written_examination_refund" id="written-examination-refund" autocomplete="off" placeholder="请输入笔试退费" class="layui-input">
                            </div>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <div class="layui-col-md3">
                            <label class="layui-form-label" for="interview-refund">面试退费</label>
                            <div class="layui-input-block">
                                <input type="text" name="interview_refund" id="interview-refund" autocomplete="off" placeholder="请输入面试退费" class="layui-input">
                            </div>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label" for="remark">备注</label>
                        <div class="layui-input-block">
                            <textarea name="remark" id="remark" class="layui-textarea"></textarea>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <div class="layui-col-md3">
                            <label class="layui-form-label" for="status">班型状态</label>
                            <div class="layui-input-block">
                                <input type="radio" name="status" id="status" value="1" title="启用" checked />
                                <input type="radio" name="status" id="status" value="0" title="停用" />
                            </div>
                        </div>
                    </div>

                    <hr>

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
    var routes = {
        class_types: {
            list: '{{ route_uri('class_types.list') }}',
            store: '{{ route_uri('class_types.store') }}',
        }
    };

    layui.use(['form', 'laydate'], function(){
        let form = layui.form;
        let $ = layui.$;

        form.on('submit(form-submit)', function(obj){
            $.ajax({
                type: 'POST',
                url: route(routes.class_types.store),
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
    });
</script>

</body>
</html>
