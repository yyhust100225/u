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
                <div class="layui-card-header">学员缴费</div>
                <div class="layui-card-body">
                <form class="layui-form" action="">
                    @csrf
                    <div class="layui-form-item">
                        <div class="layui-col-md4">
                            <label class="layui-form-label" for="paid-amount">应缴金额</label>
                            <div class="layui-input-block">
                                <input disabled type="text" name="paid_amount" value="{{ $student->paid_amount }}" id="paid-amount" autocomplete="off" class="layui-input">
                            </div>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <div class="layui-col-md4">
                            <label class="layui-form-label" for="already-paid-amount">已缴金额</label>
                            <div class="layui-input-block">
                                <input disabled type="text" name="already_paid_amount" value="{{ $student->already_paid_amount }}" id="already-paid-amount" autocomplete="off" class="layui-input">
                            </div>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <div class="layui-col-md4">
                            <label class="layui-form-label" for="payment-date">缴费时间</label>
                            <div class="layui-input-block">
                                <input disabled type="text" name="payment_date" value="{{ $today }}" id="payment-date" autocomplete="off" class="layui-input">
                            </div>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <div class="layui-col-md3">
                            <label class="layui-form-label" for="payment-place">缴费地</label>
                            <div class="layui-input-block">
                                <select name="payment_place" id="payment-place" lay-search>
                                    <option value="">请选择缴费地</option>
                                    @foreach($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <div class="layui-col-md4">
                            <label class="layui-form-label" for="bill-no">票据号</label>
                            <div class="layui-input-block">
                                <input type="text" name="bill_no" value="" id="bill-no" autocomplete="off" class="layui-input" placeholder="请输入票据号" />
                            </div>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">缴费方式</label>
                        <div class="layui-input-block">
                            <input type="checkbox" lay-filter="payment-method" name="payment_method[]" value="{{ PAYMENT_METHOD_CASH }}" title="现金" />
                            <input type="checkbox" lay-filter="payment-method" name="payment_method[]" value="{{ PAYMENT_METHOD_REMITTANCE }}" title="汇款" />
                            <input type="checkbox" lay-filter="payment-method" name="payment_method[]" value="{{ PAYMENT_METHOD_POS }}" title="POS" />
                            <input type="checkbox" lay-filter="payment-method" name="payment_method[]" value="{{ PAYMENT_METHOD_GPOS }}" title="GPOS" />
                        </div>
                    </div>

                    <div class="layui-form-item layui-hide payment_method_{{ PAYMENT_METHOD_CASH }}">
                        <div class="layui-col-md3">
                            <label class="layui-form-label" for="payment-method-cash">现金</label>
                            <div class="layui-input-inline">
                                <input type="text" name="payment_amount[{{ PAYMENT_METHOD_CASH }}]" id="payment-method-cash" autocomplete="off" class="layui-input" placeholder="请输入现金缴费额" />
                            </div>
                        </div>
                    </div>

                    <div class="layui-form-item layui-hide payment_method_{{ PAYMENT_METHOD_REMITTANCE }}">
                        <div class="layui-col-md3">
                            <label class="layui-form-label" for="payment-method-remittance">汇款</label>
                            <div class="layui-input-inline">
                                <input type="text" name="payment_amount[{{ PAYMENT_METHOD_REMITTANCE }}]" id="payment-method-remittance" autocomplete="off" class="layui-input" placeholder="请输入现金缴费额" />
                            </div>
                        </div>
                    </div>

                    <div class="layui-form-item layui-hide  payment_method_{{ PAYMENT_METHOD_POS }}">
                        <div class="layui-col-md3">
                            <label class="layui-form-label" for="payment-method-pos">POS</label>
                            <div class="layui-input-inline">
                                <input type="text" name="payment_amount[{{ PAYMENT_METHOD_POS }}]" id="payment-method-pos" autocomplete="off" class="layui-input" placeholder="请输入现金缴费额" />
                            </div>
                        </div>
                    </div>

                    <div class="layui-form-item layui-hide  payment_method_{{ PAYMENT_METHOD_GPOS }}">
                        <div class="layui-col-md3">
                            <label class="layui-form-label" for="payment-method-gpos">GPOS</label>
                            <div class="layui-input-inline">
                                <input type="text" name="payment_amount[{{ PAYMENT_METHOD_GPOS }}]" id="payment-method-gpos" autocomplete="off" class="layui-input" placeholder="请输入现金缴费额" />
                            </div>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">缴费类型</label>
                        <div class="layui-input-block">
                            <input type="radio" name="payment_type" value="{{ PAYMENT_TYPE_DEPOSIT }}" title="定金" checked />
                            <input type="radio" name="payment_type" value="{{ PAYMENT_TYPE_FULL }}" title="全款" />
                            <input type="radio" name="payment_type" value="{{ PAYMENT_TYPE_MISCELLANEOUS }}" title="学杂费" />
                            <input type="radio" name="payment_type" value="{{ PAYMENT_TYPE_SUPPLEMENT }}" title="补缴" />
                            <input type="radio" name="payment_type" value="{{ PAYMENT_TYPE_PROGRESS }}" title="进度款" />
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <div class="layui-col-md8">
                            <label class="layui-form-label" for="remark">缴费备注</label>
                            <div class="layui-input-block">
                                <textarea class="layui-textarea" name="remark" id="remark"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <div class="layui-input-block">
                            <input type="hidden" name="student_id" value="{{ $student->id }}" />
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
            pay: '{{ route_uri('students.pay') }}',
        }
    };

    layui.config({
        base: '/layuiadmin/layui/lay/modules/'
    }).use(['form'], function(){
        let form = layui.form;
        let $ = layui.$;

        form.on('submit(form-submit)', function(obj){
            $.ajax({
                type: 'POST',
                url: route(routes.students.pay),
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

        form.on('checkbox(payment-method)', function(data){
            if(data.elem.checked) {
                $('.payment_method_' + data.value).removeClass('layui-hide');
            } else {
                $('.payment_method_' + data.value).addClass('layui-hide');
            }
        });
    });
</script>

</body>
</html>
