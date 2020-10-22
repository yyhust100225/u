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
                <div class="layui-card-header">创建新员工档案</div>
                <div class="layui-card-body">
                <form class="layui-form" action="">
                    @csrf

                    <blockquote class="layui-elem-quote">
                        <p>1. (<b style="color: red;">*</b>)为必填项</p>
                        <p>2. (<b style="color: orangered;">!</b>)为重要项, 请谨慎填写或选择</p>
                        <p>3. 若员工没有TQ账号, 请填写0, 勿要空置</p>
                    </blockquote>

                    <fieldset class="layui-elem-field">
                        <legend>基础资料</legend>
                        <div class="layui-field-box">
                            <div class="layui-form-item">
                                <label class="layui-form-label" for="name">员工姓名</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="name" id="name" autocomplete="off" placeholder="请输入员工姓名" class="layui-input">
                                </div>

                                <label class="layui-form-label" for="job-no">工号</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="job_no" id="job-no" autocomplete="off" placeholder="请输入员工工号" class="layui-input">
                                </div>

                                <label class="layui-form-label" for="TQ-no">TQ账号</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="TQ_no" id="TQ-no" autocomplete="off" placeholder="请输入员工TQ账号" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label" for="department-id">部门</label>
                                <div class="layui-input-inline">
                                    <select name="department_id" id="department-id" lay-search>
                                        @foreach($departments as $department)
                                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <label class="layui-form-label" for="group-id">组别</label>
                                <div class="layui-input-inline">
                                    <select name="group_id" id="group-id" lay-search>
                                        <option value="0">无组别</option>
                                    </select>
                                </div>

                                <label class="layui-form-label" for="job-id">职务</label>
                                <div class="layui-input-inline">
                                    <select name="job_id" id="job-id" lay-search>
                                        @foreach($jobs as $job)
                                            <option value="{{ $job->id }}">{{ $job->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <label class="layui-form-label" for="level">级别</label>
                                <div class="layui-input-inline">
                                    <select name="level" id="level" lay-search>
                                        <option value="初级一">初级一</option>
                                        <option value="初级二">初级二</option>
                                        <option value="初级三">初级三</option>
                                        <option value="中级一">中级一</option>
                                        <option value="中级二">中级二</option>
                                        <option value="中级三">中级三</option>
                                        <option value="高级一">高级一</option>
                                        <option value="高级二">高级二</option>
                                        <option value="高级三">高级三</option>
                                    </select>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label" for="staff-no">职工编码</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="staff_no" id="staff-no" autocomplete="off" placeholder="请输入职工编码" class="layui-input">
                                </div>

                                <label class="layui-form-label" for="mic-no">医保卡账号</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="mic_no" id="mic-no" autocomplete="off" placeholder="请输入医保卡账号" class="layui-input">
                                </div>

                                <label class="layui-form-label" for="paf-no">公积金账号</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="paf_no" id="paf-no" autocomplete="off" placeholder="请输入公积金账号" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label" for="status">现状态</label>
                                <div class="layui-input-inline">
                                    <select name="status" id="status" lay-filter="status">
                                        <option value="0">试用期</option>
                                        <option value="1">正式员工</option>
                                        <option value="2">离职</option>
                                    </select>
                                </div>
                            </div>
                            <div class="package-departure layui-hide">
                                <div class="layui-form-item">
                                    <label class="layui-form-label" for="departure-date">离职时间</label>
                                    <div class="layui-input-inline">
                                        <input type="text" readonly="readonly" name="departure_date" id="departure-date" autocomplete="off" placeholder="年-月-日" class="layui-input">
                                    </div>

                                    <label class="layui-form-label" for="mic-no">离职方式</label>
                                    <div class="layui-input-inline">
                                        <input type="radio" name="departure_type" id="departure-type" value="0" title="辞职" checked />
                                        <input type="radio" name="departure_type" id="departure-type" value="1" title="辞退" />
                                    </div>

                                    <label class="layui-form-label" for="direction">离职去向</label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="direction" id="direction" autocomplete="off" placeholder="请输入离职去向" class="layui-input">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                <label class="layui-form-label" for="conversation-content">面谈详情</label>
                                <div class="layui-input-block">
                                    <textarea name="conversation_content" id="conversation-content" class="layui-textarea"></textarea>
                                </div>
                            </div>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset class="layui-elem-field">
                        <legend>入职时间节点</legend>
                        <div class="layui-field-box">
                            <div class="layui-form-item">
                                <label class="layui-form-label" for="hire-date">入职时间</label>
                                <div class="layui-input-inline">
                                    <input type="text" readonly="readonly" name="hire_date" id="hire-date" autocomplete="off" placeholder="员工入职时间" class="layui-input">
                                </div>

                                <label class="layui-form-label" for="last-contract-date">签约时间</label>
                                <div class="layui-input-inline">
                                    <input type="text" readonly="readonly" name="last_contract_date" id="last-contract-date" autocomplete="off" placeholder="最近员工合同签约时间" class="layui-input">
                                </div>

                                <label class="layui-form-label" for="contract-expire-date">到期时间</label>
                                <div class="layui-input-inline">
                                    <input type="text" readonly="readonly" name="contract_expire_date" id="contract-expire-date" autocomplete="off" placeholder="员工合同到期时间" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label" for="regular">是否转正</label>
                                <div class="layui-input-inline">
                                    <select name="regular" id="regular" lay-filter="regular">
                                        <option value="0">否</option>
                                        <option value="1">是</option>
                                    </select>
                                </div>
                                <div class="package-regular layui-hide">
                                    <label class="layui-form-label" for="regular-date">转正时间</label>
                                    <div class="layui-input-inline">
                                        <input type="text" readonly="readonly" name="regular_date" id="regular-date" autocomplete="off" placeholder="员工转正时间" class="layui-input">
                                    </div>
                                </div>
                                <label class="layui-form-label" for="insurance-area-id">入险地区</label>
                                <div class="layui-input-inline">
                                    <select name="insurance_area_id" id="insurance-area-id" lay-filter="insurance">
                                        <option value="0">未交保险</option>
                                        @foreach($insurance_areas as $insurance_area)
                                            <option value="{{ $insurance_area->id }}">{{ $insurance_area->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="package-insurance layui-hide">
                                    <label class="layui-form-label" for="insurance-date">转正时间</label>
                                    <div class="layui-input-inline">
                                        <input type="text" readonly="readonly" name="insurance_date" id="insurance-date" autocomplete="off" placeholder="员工转正时间" class="layui-input">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset class="layui-elem-field">
                        <legend>员工信息</legend>
                        <div class="layui-field-box">
                            <div class="layui-form-item">
                                <label class="layui-form-label" for="gender">性别</label>
                                <div class="layui-input-inline">
                                    <input type="radio" id="gender" name="gender" value="0" title="男" checked />
                                    <input type="radio" id="gender" name="gender" value="1" title="女" />
                                </div>
                                <label class="layui-form-label" for="nation-id">民族</label>
                                <div class="layui-input-inline">
                                    <select name="nation_id" id="nation-id" lay-search>
                                        @foreach($nations as $nation)
                                            <option value="{{ $nation->id }}">{{ $nation->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <label class="layui-form-label" for="political-status">政治面貌</label>
                                <div class="layui-input-inline">
                                    <select name="political_status" id="political-status" lay-search>
                                        <option value="0">群众</option>
                                        <option value="1">党员</option>
                                    </select>
                                </div>
                                <label class="layui-form-label" for="marry">婚姻状况</label>
                                <div class="layui-input-inline">
                                    <select name="marry" id="marry" lay-search>
                                        <option value="0">未婚</option>
                                        <option value="1">已婚</option>
                                    </select>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label" for="register-residence-type">户口类型</label>
                                <div class="layui-input-inline">
                                    <select name="register_residence_type" id="register-residence-type" lay-search>
                                        <option value="0">农村</option>
                                        <option value="1">城镇</option>
                                    </select>
                                </div>
                                <label class="layui-form-label" for="id-card-no">身份证号</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="id_card_no" id="id-card-no" class="layui-input" placeholder="员工身份证号" />
                                </div>
                                <label class="layui-form-label" for="tel">电话</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="tel" id="tel" class="layui-input" placeholder="员工联系方式" />
                                </div>
                                <label class="layui-form-label" for="birthday">生日</label>
                                <div class="layui-input-inline">
                                    <input readonly="readonly" type="text" name="birthday" id="birthday" class="layui-input" placeholder="员工生日" />
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label" for="alias">教学用名</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="alias" id="alias" class="layui-input" placeholder="教师艺名/绰号" />
                                </div>
                                <label class="layui-form-label" for="teacher-certification">教师资格证</label>
                                <div class="layui-input-inline">
                                    <input type="radio" id="teacher-certification" name="teacher_certification" value="0" title="未持有" checked />
                                    <input type="radio" id="teacher-certification" name="teacher_certification" value="1" title="持有" />
                                </div>
                                <label class="layui-form-label" for="emergency-contact">紧急联系人</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="emergency_contact" id="emergency-contact" class="layui-input" placeholder="员工紧急联系人" />
                                </div>
                                <label class="layui-form-label" for="emergency-tel">联系人电话</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="emergency_tel" id="emergency-tel" class="layui-input" placeholder="紧急联系人电话" />
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label" for="id-card-address">身份证地址</label>
                                <div class="layui-input-block">
                                    <input type="text" name="id_card_address" id="id-card-address" class="layui-input" placeholder="身份证地址" />
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label" for="current-address">现居住地址</label>
                                <div class="layui-input-block">
                                    <input type="text" name="current_address" id="current-address" class="layui-input" placeholder="身份证地址" />
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label" for="work-experience">工作经历</label>
                                <div class="layui-input-block">
                                    <textarea name="work_experience" id="work-experience" class="layui-textarea" placeholder="员工以往工作经历"></textarea>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label" for="remark">员工备注</label>
                                <div class="layui-input-block">
                                    <textarea name="remark" id="remark" class="layui-textarea" placeholder="员工备注"></textarea>
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset class="layui-elem-field">
                        <legend>教育经历</legend>
                        <div class="layui-field-box">
                            <div class="layui-form-item">
                                <label class="layui-form-label" for="educational-background">学历</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="educational_background" id="educational-background" autocomplete="off" placeholder="员工学历" class="layui-input">
                                </div>

                                <label class="layui-form-label" for="academic-degree">学位</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="academic_degree" id="academic-degree" autocomplete="off" placeholder="员工学位" class="layui-input">
                                </div>

                                <label class="layui-form-label" for="major">专业</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="major" id="major" autocomplete="off" placeholder="所学专业" class="layui-input">
                                </div>

                                <label class="layui-form-label" for="university">毕业院校</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="university" id="university" autocomplete="off" placeholder="毕业院校" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label" for="learn-model">学习形式</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="learn_model" id="learn-model" autocomplete="off" placeholder="在校学习模式" class="layui-input">
                                </div>

                                <label class="layui-form-label" for="graduate-date">毕业时间</label>
                                <div class="layui-input-inline">
                                    <input type="text" readonly="readonly" name="graduate_date" id="graduate-date" autocomplete="off" placeholder="毕业时间" class="layui-input">
                                </div>

                                <label class="layui-form-label" for="other-certificates">其他证书</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="other_certificates" id="other-certificates" autocomplete="off" placeholder="其他证书" class="layui-input">
                                </div>

                            </div>
                        </div>
                    </fieldset>

                    <fieldset class="layui-elem-field">
                        <legend>薪资信息</legend>
                        <div class="layui-field-box">
                            <div class="layui-form-item">
                                <label class="layui-form-label" for="base-salary-1">基本薪资1</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="base_salary_1" id="base-salary-1" autocomplete="off" placeholder="基本薪资1" class="layui-input">
                                </div>

                                <label class="layui-form-label" for="base-salary-2">基本薪资2</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="base_salary_2" id="base-salary-2" autocomplete="off" placeholder="基本薪资2" class="layui-input">
                                </div>

                                <label class="layui-form-label" for="merits-salary">绩效工资</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="merits_salary" id="merits-salary" autocomplete="off" placeholder="绩效工资" class="layui-input">
                                </div>

                                <label class="layui-form-label" for="job-subsidy">岗位补助</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="job_subsidy" id="job-subsidy" autocomplete="off" placeholder="岗位补助" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label" for="live-subsidy">生活补助</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="live_subsidy" id="live-subsidy" autocomplete="off" placeholder="生活补助" class="layui-input">
                                </div>

                                <label class="layui-form-label" for="local-subsidy">地方补助</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="local_subsidy" id="local-subsidy" autocomplete="off" placeholder="地方补助" class="layui-input">
                                </div>

                                <label class="layui-form-label" for="public-service-subsidy">公共服务</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="public_service_subsidy" id="public-service-subsidy" autocomplete="off" placeholder="公共服务补助" class="layui-input">
                                </div>

                                <label class="layui-form-label" for="class-subsidy">课时补助</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="class_subsidy" id="class-subsidy" autocomplete="off" placeholder="课时补助" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label" for="no-insurance-subsidy">无保险补助</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="no_insurance_subsidy" id="no-insurance-subsidy" autocomplete="off" placeholder="放弃保险补助" class="layui-input">
                                </div>

                                <label class="layui-form-label" for="other-subsidy">其他补助</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="other_subsidy" id="other-subsidy" autocomplete="off" placeholder="其他补助" class="layui-input">
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset class="layui-elem-field">
                        <legend>银行账户信息</legend>
                        <div class="layui-field-box">
                            <div class="layui-form-item">
                                <label class="layui-form-label" for="bank-card-no-5">银行卡号1</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="bank_card_no_5" id="bank-card-no-5" autocomplete="off" placeholder="5日工资卡卡号" class="layui-input">
                                </div>
                                <label class="layui-form-label" for="bank-of-account-5">开户支行1</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="bank_of_account_5" id="bank-of-account-5" autocomplete="off" placeholder="5日工资卡开户支行" class="layui-input">
                                </div>
                                <label class="layui-form-label" for="bank-card-no-10">银行卡号2</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="bank_card_no_10" id="bank-card-no-10" autocomplete="off" placeholder="10日工资卡卡号" class="layui-input">
                                </div>
                                <label class="layui-form-label" for="bank-of-account-10">开户支行2</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="bank_of_account_10" id="bank-of-account-10" autocomplete="off" placeholder="10日工资卡开户支行" class="layui-input">
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset class="layui-elem-field">
                        <legend>动态记录</legend>
                        <div class="layui-field-box">
                            <div class="layui-form-item">
                                <label class="layui-form-label" for="exception-action">异动记录</label>
                                <div class="layui-input-block">
                                    <textarea name="exception_action" id="exception-action" class="layui-textarea" placeholder="员工异动记录"></textarea>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label" for="leave-records">休假记录</label>
                                <div class="layui-input-block">
                                    <textarea name="leave_records" id="leave-records" class="layui-textarea" placeholder="员工休假记录"></textarea>
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    <div class="layui-form-item">
                        <div class="layui-input-block">
                            <input type="hidden" name="user_id" value="1" />
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

<script src="{{ asset('layuiadmin/layui/layui.js') }}"></script>
<script src="{{ asset('assets/js/custom.js') }}"></script>
<script>

    // 页面路由
    var routes = {
        employees: {
            list: '{{ route_uri('employees.list') }}',
            store: '{{ route_uri('employees.store') }}',
        }
    };

    layui.use(['form', 'laydate'], function(){
        let form = layui.form;
        let laydate = layui.laydate;
        let $ = layui.$;

        form.on('submit(form-submit)', function(obj){
            $.ajax({
                type: 'POST',
                url: route(routes.employees.store),
                data: obj.field,
                dataType: 'json',
                async: false,
                success: function(res){
                    if(res.code === {{ REQUEST_SUCCESS }}) {
                        var index = parent.layer.getFrameIndex(window.name);
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
                        layer.msg(e.responseJSON.message);
                    }
                }
            });
            return false;
        });
        form.on('select(status)', function(data){
            if(data.value === '2') {
                $('.package-departure').removeClass('layui-hide');
            } else {
                $('.package-departure').addClass('layui-hide');
            }
        });
        form.on('select(regular)', function(data){
            if(data.value === '1') {
                $('.package-regular').removeClass('layui-hide');
            } else {
                $('.package-regular').addClass('layui-hide');
            }
        });
        form.on('select(insurance)', function(data){
            if(data.value !== '0') {
                $('.package-insurance').removeClass('layui-hide');
            } else {
                $('.package-insurance').addClass('layui-hide');
            }
        });

        let plugin_ids = ['departure-date', 'hire-date', 'regular-date', 'last-contract-date', 'contract-expire-date', 'insurance-date', 'birthday', 'graduate-date'];
        $.each(plugin_ids, function(k,v){
            laydate.render({
                elem: '#' + v,
                type: 'date',
                trigger: 'click',
            });
        });
    });
</script>

</body>
