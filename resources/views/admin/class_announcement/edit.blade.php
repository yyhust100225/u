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
                <div class="layui-card-header">编辑公告</div>
                <div class="layui-card-body">
                    <form class="layui-form" action="">
                        @csrf
                        <div class="layui-form-item">
                            <div class="layui-col-md8">
                                <label class="layui-form-label" for="title">公告名称</label>
                                <div class="layui-input-block">
                                    <input type="text" name="title" value="{{ $class_announcement->title }}" id="title" autocomplete="off" placeholder="请输入公告名称" class="layui-input">
                                </div>
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <div class="layui-col-md3">
                                <label class="layui-form-label" for="city-id">城市</label>
                                <div class="layui-input-block">
                                    <select name="city_id" id="city-id">
                                        @foreach($cities as $city)
                                            <option @if($city->id === $class_announcement->city_id) selected @endif value="{{ $city->id }}">{{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <div class="layui-col-md6">
                                <label class="layui-form-label" for="announcement-type">公告类型</label>
                                <div class="layui-input-block">
                                    <select name="announcement_type" id="announcement-type">
                                        @foreach($announcement_types as $announcement_type)
                                            <option @if($announcement_type->id === $class_announcement->announcement_type) selected @endif value="{{ $announcement_type->id }}">{{ $announcement_type->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <div class="layui-col-md8">
                                <label class="layui-form-label" for="link">公告链接</label>
                                <div class="layui-input-block">
                                    <input type="text" name="link" value="{{ $class_announcement->link }}" id="link" autocomplete="off" placeholder="请输入公告链接" class="layui-input">
                                </div>
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <div class="layui-col-md3">
                                <label class="layui-form-label" for="level">考试等级</label>
                                <div class="layui-input-block">
                                    <select name="level" id="level">
                                        <option @if('A' === $class_announcement->level) selected @endif value="A">A</option>
                                        <option @if('B' === $class_announcement->level) selected @endif value="B">B</option>
                                        <option @if('C' === $class_announcement->level) selected @endif value="C">C</option>
                                        <option @if('D' === $class_announcement->level) selected @endif value="D">D</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <div class="layui-col-md3">
                                <label class="layui-form-label" for="publish-date">发布时间</label>
                                <div class="layui-input-block">
                                    <input type="text" readonly="readonly" name="publish_date" value="{{ $class_announcement->publish_date }}" id="publish-date" autocomplete="off" placeholder="选择发布时间" class="layui-input">
                                </div>
                            </div>

                            <div class="layui-col-md3">
                                <label class="layui-form-label" for="candidate-num">招考人数</label>
                                <div class="layui-input-block">
                                    <input type="text" name="candidate_num" value="{{ $class_announcement->candidate_num }}" id="candidate-num" autocomplete="off" placeholder="请输入招考人数" class="layui-input">
                                </div>
                            </div>

                            <div class="layui-col-md3">
                                <label class="layui-form-label" for="enroll-date-start">报名开始时间</label>
                                <div class="layui-input-block">
                                    <input type="text" readonly="readonly" name="enroll_date_start" value="{{ $class_announcement->enroll_date_start }}" id="enroll-date-start" autocomplete="off" placeholder="选择报名开始时间" class="layui-input">
                                </div>
                            </div>

                            <div class="layui-col-md3">
                                <label class="layui-form-label" for="enroll-date-end">报名截止时间</label>
                                <div class="layui-input-block">
                                    <input type="text" readonly="readonly" name="enroll_date_end" value="{{ $class_announcement->enroll_date_end }}" id="enroll-date-end" autocomplete="off" placeholder="选择报名截止时间" class="layui-input">
                                </div>
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <div class="layui-col-md3">
                                <label class="layui-form-label" for="enroll-type">报名形式</label>
                                <div class="layui-input-block">
                                    <input type="radio" @if($class_announcement->enroll_type === 0) checked @endif name="enroll_type" id="enroll-type" value="0" title="网上报名" />
                                    <input type="radio" @if($class_announcement->enroll_type === 1) checked @endif name="enroll_type" id="enroll-type" value="1" title="线下报名" />
                                </div>
                            </div>

                            <div class="layui-col-md4">
                                <label class="layui-form-label" for="exam-type">考试形式</label>
                                <div class="layui-input-block">
                                    <input type="radio" @if($class_announcement->exam_type === 0) checked @endif name="exam_type" id="exam-type" value="0" title="笔试" />
                                    <input type="radio" @if($class_announcement->exam_type === 1) checked @endif name="exam_type" id="exam-type" value="1" title="面试" />
                                    <input type="radio" @if($class_announcement->exam_type === 2) checked @endif name="exam_type" id="exam-type" value="2" title="笔试+面试" />
                                </div>
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <div class="layui-col-md3">
                                <label class="layui-form-label" for="written-exam-activity-num">笔试活动人数</label>
                                <div class="layui-input-block">
                                    <input type="text" name="written_exam_activity_num" value="{{ $class_announcement->written_exam_activity_num }}" id="written-exam-activity-num" autocomplete="off" placeholder="请输入笔试活动人数" class="layui-input">
                                </div>
                            </div>

                            <div class="layui-col-md3">
                                <label class="layui-form-label" for="written-exam-date">笔试考试时间</label>
                                <div class="layui-input-block">
                                    <input type="text" readonly="readonly" name="written_exam_date" value="{{ $class_announcement->written_exam_date }}" id="written-exam-date" autocomplete="off" placeholder="选择笔试考试时间" class="layui-input">
                                </div>
                            </div>

                            <div class="layui-col-md3">
                                <label class="layui-form-label" for="written-exam-class-open">笔试是否开课</label>
                                <div class="layui-input-block">
                                    <input type="radio" @if($class_announcement->written_exam_class_open === 0) checked @endif name="written_exam_class_open" id="written-exam-class-open" value="0" title="是" />
                                    <input type="radio" @if($class_announcement->written_exam_class_open === 1) checked @endif name="written_exam_class_open" id="written-exam-class-open" value="1" title="否" />
                                </div>
                            </div>

                            <div class="layui-col-md3">
                                <label class="layui-form-label" for="written-exam-take-problem-sets">笔试是否拿题</label>
                                <div class="layui-input-block">
                                    <input type="radio" @if($class_announcement->written_exam_take_problem_sets === 0) checked @endif name="written_exam_take_problem_sets" id="written-exam-take-problem-sets" value="0" title="是" />
                                    <input type="radio" @if($class_announcement->written_exam_take_problem_sets === 1) checked @endif name="written_exam_take_problem_sets" id="written-exam-take-problem-sets" value="1" title="否" />
                                </div>
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <div class="layui-col-md3">
                                <label class="layui-form-label" for="written-exam-in-examination-num">笔试考试人数</label>
                                <div class="layui-input-block">
                                    <input type="text" name="written_exam_in_examination_num" value="{{ $class_announcement->written_exam_in_examination_num }}" id="written-exam-in-examination-num" autocomplete="off" placeholder="请输入笔试考试人数" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-col-md3">
                                <label class="layui-form-label" for="check-qualification-date">资格审查时间</label>
                                <div class="layui-input-block">
                                    <input type="text" readonly="readonly" name="check_qualification_date" value="{{ $class_announcement->check_qualification_date }}" id="check-qualification-date" autocomplete="off" placeholder="选择资格审查时间" class="layui-input">
                                </div>
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <div class="layui-col-md3">
                                <label class="layui-form-label" for="interview-activity-num">面试活动人数</label>
                                <div class="layui-input-block">
                                    <input type="text" name="interview_activity_num" value="{{ $class_announcement->interview_activity_num }}" id="interview-activity-num" autocomplete="off" placeholder="请输入面试活动人数" class="layui-input">
                                </div>
                            </div>

                            <div class="layui-col-md3">
                                <label class="layui-form-label" for="interview-date">面试时间</label>
                                <div class="layui-input-block">
                                    <input type="text" readonly="readonly" name="interview_date" value="{{ $class_announcement->interview_date }}" id="interview-date" autocomplete="off" placeholder="选择面试时间" class="layui-input">
                                </div>
                            </div>

                            <div class="layui-col-md3">
                                <label class="layui-form-label" for="interview-class-open">面试是否开课</label>
                                <div class="layui-input-block">
                                    <input type="radio" @if($class_announcement->interview_class_open === 0) checked @endif name="interview_class_open" id="interview-class-open" value="0" title="是" />
                                    <input type="radio" @if($class_announcement->interview_class_open === 1) checked @endif name="interview_class_open" id="interview-class-open" value="1" title="否" />
                                </div>
                            </div>

                            <div class="layui-col-md3">
                                <label class="layui-form-label" for="interview-take-problem-sets">面试是否拿题</label>
                                <div class="layui-input-block">
                                    <input type="radio" @if($class_announcement->interview_take_problem_sets === 0) checked @endif name="interview_take_problem_sets" id="interview-take-problem-sets" value="0" title="是" />
                                    <input type="radio" @if($class_announcement->interview_take_problem_sets === 1) checked @endif name="interview_take_problem_sets" id="interview-take-problem-sets" value="1" title="否" />
                                </div>
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <div class="layui-col-md3">
                                <label class="layui-form-label" for="pass-percent">自然通过率</label>
                                <div class="layui-input-block">
                                    <input type="text" name="pass_percent" value="{{ $class_announcement->pass_percent }}" id="pass-percent" autocomplete="off" placeholder="请输入自然通过率" class="layui-input">
                                </div>
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <div class="layui-col-md3">
                                <label class="layui-form-label" for="status">公告状态</label>
                                <div class="layui-input-block">
                                    <input type="radio" @if($class_announcement->status === 1) checked @endif name="status" id="status" value="1" title="启用" />
                                    <input type="radio" @if($class_announcement->status === 0) checked @endif name="status" id="status" value="0" title="停用" />
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="layui-form-item">
                            <div class="layui-input-block">
                                <input type="hidden" name="id" value="{{ $class_announcement->id }}" />
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
        class_announcements: {
            list: '{{ route_uri('class_announcements.list') }}',
            update: '{{ route_uri('class_announcements.update') }}',
        }
    };

    layui.use(['form', 'laydate'], function(){
        let form = layui.form;
        let laydate = layui.laydate;
        let $ = layui.$;

        let date_widgets = ['publish-date', 'enroll-date-start', 'enroll-date-end', 'written-exam-date', 'check-qualification-date', 'interview-date'];
        $.each(date_widgets, function(k,v) {
            laydate.render({
                elem: '#' + v,
                type: 'date',
                trigger: 'click'
            });
        });

        form.on('submit(form-submit)', function(obj){
            $.ajax({
                type: 'PUT',
                url: route(routes.class_announcements.update),
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