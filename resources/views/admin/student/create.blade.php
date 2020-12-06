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
                                <input type="text" name="name" value="{{ $tq_student->name }}" id="name" autocomplete="off" placeholder="请输入学员名称" class="layui-input">
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
                                <input type="text" name="mobile" value="{{ $tq_student->mobile }}" id="mobile" autocomplete="off" placeholder="请输入学员电话" class="layui-input">
                            </div>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <div class="layui-col-md12">
                            <label class="layui-form-label" for="remark">学员备注</label>
                            <div class="layui-input-block">
                                <textarea class="layui-textarea" name="remark" id="remark">{{ $tq_student->remark }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <div class="layui-col-md8">
                            <label class="layui-form-label" for="class-type-id">考试/班型</label>
                            <div class="layui-input-block">
                                <input type="hidden" name="class_type_id" id="class-type-id">
                                <input readonly type="text" name="class_type" id="class-type" placeholder="请选择考试+班型" class="layui-input" />
                            </div>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <div class="layui-col-md5">
                            <label class="layui-form-label" for="class-examination-discounts">考试优惠</label>
                            <div class="layui-input-block">
                                <div id="class-examination-discounts"></div>
                            </div>
                        </div>

                        <div class="layui-col-md5">
                            <label class="layui-form-label" for="class-type-discounts">班型优惠</label>
                            <div class="layui-input-block">
                                <div id="class-type-discounts"></div>
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

                        <label class="layui-form-label" for="weighted-score">笔试加权分</label>
                        <div class="layui-input-inline">
                            <input type="text" name="weighted_score" id="weighted-score" autocomplete="off" placeholder="请输入笔试加权分" class="layui-input">
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
                                <input readonly="readonly" type="text" name="receivable_amount" value="0.00" id="receivable-amount" class="layui-input" />
                            </div>

                            <label class="layui-form-label" for="discount-amount">优惠金额</label>
                            <div class="layui-input-inline">
                                <input readonly="readonly" type="text" name="discount_amount" value="0.00" id="discount-amount" class="layui-input" />
                            </div>

                            <label class="layui-form-label" for="paid-amount">实缴金额</label>
                            <div class="layui-input-inline">
                                <input readonly="readonly" type="text" name="paid_amount" value="0.00" id="paid-amount" class="layui-input" />
                            </div>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <div class="layui-inline">
                            <label class="layui-form-label" for="written-examination-refund">笔试退费</label>
                            <div class="layui-input-inline">
                                <input readonly="readonly" type="text" name="written_examination_refund" value="0.00" id="written-examination-refund" class="layui-input" />
                            </div>

                            <label class="layui-form-label" for="interview-refund">面试退费</label>
                            <div class="layui-input-inline">
                                <input readonly="readonly" type="text" name="interview_refund" value="0.00" id="interview-refund" class="layui-input" />
                            </div>
                            <div class="layui-form-mid layui-word-aux">非协议班退费为：<span>0.00</span>元</div>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <div class="layui-input-block">
                            <input type="hidden" name="tq_id" value="{{ $tq_student->tq_id }}" />
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
<script type="text/javascript" src="{{ asset('assets/js/xm-select.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/custom.js') }}"></script>
<script>

    // 页面路由
    let routes = {
        students: {
            store: '{{ route_uri('students.store') }}',
            class_types: '{{ route_uri('students.class_types') }}',
        }
    };

    var class_type; // 考试班型班级信息

    layui.config({
        base: '/layuiadmin/layui/lay/modules/'
    }).use(['form', 'laydate'], function(){
        let form = layui.form;
        let laydate = layui.laydate;
        let $ = layui.$;

        laydate.render({
            elem: '#class-open-date',
            type: 'date',
            trigger: 'click',
            theme: '#393D49'
        });

        // 选择班级+班型
        $('input#class-type').on('click', function(){
            class_type = undefined;
            makeLayerForm(layer, '{{ trans('tips.layer form title') }}', route(routes.students.class_types), function(){
                // 关闭选择对话
                if(typeof class_type === 'undefined')
                    return false;

                // 选定考试班型班级后, 初始化选择各项金额
                let html = '所属考试: ' + class_type.examination + ', 所属班型: ' + class_type.name;
                $('input#class-type').val(html);
                $('input#class-type-id').val(class_type.id);
                $('input#receivable-amount').val(parseFloat(class_type.total_tuition).toFixed(2));
                $('input#discount-amount').val(0.00);
                $('input#paid-amount').val(parseFloat(class_type.total_tuition).toFixed(2));
                $('input#written-examination-refund').val(parseFloat(class_type.written_examination_refund).toFixed(2));
                $('input#interview-refund').val(parseFloat(class_type.interview_refund).toFixed(2));

                // 考试优惠计算
                let class_examination_discounts_options = [];
                $.each(class_type.class_examination_discounts, function(k,v){
                    let name = v.type.name + '(优惠:' + v.amount + '元)';
                    class_examination_discounts_options.push({name: name, value: v.id, amount: v.amount});
                });
                let class_examination_discounts_select = multi_select_init('class-examination-discounts', 'class_examination_discount_ids', class_examination_discounts_options, function(data){
                    calculate_amount(data.change[0].amount, data.isAdd);
                });

                // 班型优惠计算
                let class_type_discounts_options = [];
                $.each(class_type.class_type_discounts, function(k,v){
                    let name = v.name + '(优惠:' + v.amount + '元)';
                    class_type_discounts_options.push({name: name, value: v.id, amount: v.amount});
                });
                let class_type_discounts_select = multi_select_init('class-type-discounts', 'class_type_discount_ids', class_type_discounts_options, function(data){
                    calculate_amount(data.change[0].amount, data.isAdd);
                });
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
                        let index = parent.layer.getFrameIndex(window.name);
                        let p_index = parent.parent.layer.getFrameIndex(parent.window.name);
                        layer.msg(res.message, {time: 1000}, function(){
                            parent.layer.close(index);
                            parent.parent.layer.close(p_index);
                            parent.parent.active.reload.call(this);
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

        // 初始化优惠条件多选框
        let class_examination_discounts_init = multi_select_init('class-examination-discounts', 'class_examination_discount_ids', []);
        let class_type_discounts_init = multi_select_init('class-type-discounts', 'class_type_discount_ids', []);

        /**
         * 计算优惠价格
         * @param discount_amount 本次操作优惠价格
         * @param is_add 加或减
         * @returns {boolean}
         */
        let calculate_amount = function(discount_amount, is_add)
        {
            if(parseFloat(discount_amount).toFixed(2) === '0.00')
                return false;
            // 现有优惠价格
            let current_discount_amount = $('input#discount-amount').val();
            // 原价格
            let original_amount = $('input#receivable-amount').val();
            // 合计优惠价格
            let total_discount_amount;
            if(is_add) {
                total_discount_amount = floatObj.add(current_discount_amount, discount_amount);
            } else {
                total_discount_amount = floatObj.subtract(current_discount_amount, discount_amount);
            }
            let real_amount = floatObj.subtract(original_amount, total_discount_amount);
            $('input#discount-amount').val(parseFloat(total_discount_amount).toFixed(2));
            $('input#paid-amount').val(parseFloat(real_amount).toFixed(2));
            return true;
        }
    });
</script>

</body>
</html>
