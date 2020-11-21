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
                <div class="layui-card-header">创建新学员</div>
                <div class="layui-card-body">
                <form class="layui-form" action="">
                    @csrf
                    <div class="layui-form-item">
                        <div class="layui-col-md4">
                            <label class="layui-form-label" for="name">学员名称</label>
                            <div class="layui-input-block">
                                <input type="text" name="name" id="name" autocomplete="off" placeholder="请输入学员名称" class="layui-input">
                            </div>
                        </div>

                        <div class="layui-col-md4">
                            <label class="layui-form-label" for="ID-card-no">身份证号</label>
                            <div class="layui-input-block">
                                <input type="text" name="ID_card_no" id="ID-card-no" autocomplete="off" placeholder="请输入身份证号" class="layui-input">
                            </div>
                        </div>

                        <div class="layui-col-md4">
                            <label class="layui-form-label" for="mobile">学员电话</label>
                            <div class="layui-input-block">
                                <input type="text" name="mobile" id="mobile" autocomplete="off" placeholder="请输入学员电话" class="layui-input">
                            </div>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <div class="layui-col-md12">
                            <label class="layui-form-label" for="remark">学员备注</label>
                            <div class="layui-input-block">
                                <textarea class="layui-textarea" name="remark" id="remark"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <div class="layui-col-md8">
                            <label class="layui-form-label" for="class-course-id">考试/班型</label>
                            <div class="layui-input-block">
                                <input readonly type="text" name="class_course_id" id="class-course-id" placeholder="请选择考试+班型" class="layui-input" />
                            </div>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <div class="layui-col-md4">
                            <label class="layui-form-label" for="class-open-date">开课日期</label>
                            <div class="layui-input-block">
                                <input type="text" readonly="readonly" name="class_open_date" id="class-open-date" autocomplete="off" placeholder="请输入开课日期" class="layui-input">
                            </div>
                        </div>
                    </div>

                    <div class="layui-form-item">

                        <div class="layui-col-md4">
                            <label class="layui-form-label" for="admission-ticket-no">准考证号</label>
                            <div class="layui-input-block">
                                <input type="text" name="admission_ticket_no" id="admission-ticket-no" autocomplete="off" placeholder="请输入准考证号" class="layui-input">
                            </div>
                        </div>

                        <div class="layui-col-md4">
                            <label class="layui-form-label" for="applicant-company">报考单位</label>
                            <div class="layui-input-block">
                                <input type="text" name="applicant_company" id="applicant-company" autocomplete="off" placeholder="请输入报考单位" class="layui-input">
                            </div>
                        </div>

                        <div class="layui-col-md4">
                            <label class="layui-form-label" for="applicant-job">报考职位</label>
                            <div class="layui-input-block">
                                <input type="text" name="applicant_job" id="applicant-job" autocomplete="off" placeholder="请输入报考职位" class="layui-input">
                            </div>
                        </div>

                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label" for="applicant-num">招考人数</label>
                        <div class="layui-input-inline">
                            <input type="text" name="applicant_num" id="applicant-num" autocomplete="off" placeholder="请输入招考人数" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <div class="layui-inline">
                            <label class="layui-form-label" for="applicant-percent-molecule">招考比例</label>
                            <div class="layui-input-inline">
                                <input type="text" name="applicant_percent_molecule" id="applicant-percent-molecule" autocomplete="off" placeholder="请输入招考比例分子" class="layui-input">
                            </div>
                            <div class="layui-form-mid">/</div>
                            <div class="layui-input-inline">
                                <input type="text" name="applicant_percent_denominator" id="applicant-percent-denominator" autocomplete="off" placeholder="请输入招考比例分母" class="layui-input">
                            </div>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label" for="rank">排名</label>
                        <div class="layui-input-inline">
                            <input type="text" name="rank" id="rank" autocomplete="off" placeholder="请输入排名" class="layui-input">
                        </div>
                        <div class="layui-form-mid layui-word-aux">提示: 攻擂/守擂</div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label" for="difference">分差</label>
                        <div class="layui-input-inline">
                            <input type="text" name="difference" id="difference" autocomplete="off" placeholder="请输入分差" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <div class="layui-inline">
                            <label class="layui-form-label" for="person-in-charge">咨询负责人</label>
                            <div class="layui-input-inline">
                                <select name="person_in_charge" id="person-in-charge" lay-search>
                                    <option value="">请选择咨询负责人</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->username }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <label class="layui-form-label" for="campus">归属地</label>
                            <div class="layui-input-inline">
                                <select name="campus" id="campus" lay-search>
                                    <option value="">请选择归属地</option>
                                    @foreach($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <div class="layui-inline">
                            <label class="layui-form-label" for="receivable-amount">应收金额</label>
                            <div class="layui-input-inline">
                                <input readonly="readonly" type="text" name="receivable_amount" id="receivable-amount" class="layui-input" />
                            </div>

                            <label class="layui-form-label" for="discount-amount">优惠金额</label>
                            <div class="layui-input-inline">
                                <input readonly="readonly" type="text" name="discount_amount" id="discount-amount" class="layui-input" />
                            </div>

                            <label class="layui-form-label" for="paid-amount">实缴金额</label>
                            <div class="layui-input-inline">
                                <input readonly="readonly" type="text" name="paid_amount" id="paid-amount" class="layui-input" />
                            </div>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <div class="layui-inline">
                            <label class="layui-form-label" for="written-examination-refund">笔试退费</label>
                            <div class="layui-input-inline">
                                <input readonly="readonly" type="text" name="written_examination_refund" id="written-examination-refund" class="layui-input" />
                            </div>

                            <label class="layui-form-label" for="interview-refund">面试退费</label>
                            <div class="layui-input-inline">
                                <input readonly="readonly" type="text" name="interview_refund" id="interview-refund" class="layui-input" />
                            </div>
                            <div class="layui-form-mid layui-word-aux">非协议班退费为：<span>0.00</span>元</div>
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
        students: {
            store: '{{ route_uri('students.store') }}',
            class_courses: '{{ route_uri('students.class_courses') }}',
        }
    };

    var course;

    layui.config({
        base: '/layuiadmin/layui/lay/modules/'
    }).use(['form', 'laydate'], function(){
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

        // 选择班级+班型
        $('input#class-course-id').on('click', function(){
            makeLayerForm(layer, '{{ trans('tips.layer form title') }}', route(routes.students.class_courses), function(){
                let html = '所属考试: ' + course.examination_name + ', 所属班型: ' + course.class_type_name + ', 所属班级: ' + course.name;
                $('input#class-course-id').val(html);

            });
        });

        form.on('submit(form-submit)', function(obj){
            $.ajax({
                type: 'POST',
                url: route(routes.students.store),
                data: obj.field,
                dataType: 'json',
                async: false,
                success: function(res){
                    if(res.code === {{ REQUEST_SUCCESS }}) {
                        var index = parent.layer.getFrameIndex(window.name);
                        layer.msg(res.message, {time: 1000}, function(){
                            parent.layer.close(index);
                            // parent.active.reload.call(this);
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
