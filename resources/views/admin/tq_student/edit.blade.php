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
                <div class="layui-card-header">编辑学员</div>
                <div class="layui-card-body">
                <form class="layui-form" action="">
                    @csrf
                    <div class="layui-form-item">
                        <label class="layui-form-label" for="name">学员姓名</label>
                        <div class="layui-input-inline">
                            <input type="text" name="name" value="{{ $tq_student->name }}" id="name" autocomplete="off" placeholder="请输入学员姓名" class="layui-input">
                        </div>

                        <label class="layui-form-label" for="gender">性别</label>
                        <div class="layui-input-inline">
                            <input type="radio" @if($tq_student->gender == 1) checked @endif name="gender" value="1" id="gender" title="男" />
                            <input type="radio" @if($tq_student->gender == 2) checked @endif name="gender" value="2" id="gender" title="女" />
                        </div>

                        <label class="layui-form-label" for="mobile">手机</label>
                        <div class="layui-input-inline">
                            <input type="text" name="mobile" value="{{ $tq_student->mobile }}" id="mobile" autocomplete="off" placeholder="请输入手机号" class="layui-input">
                        </div>

                        <label class="layui-form-label" for="telephone">联系方式</label>
                        <div class="layui-input-inline">
                            <input type="text" name="telephone" value="{{ $tq_student->telephone }}" id="telephone" autocomplete="off" placeholder="请输入联系方式" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label" for="qq">QQ号</label>
                        <div class="layui-input-inline">
                            <input type="text" name="qq" value="{{ $tq_student->qq }}" id="qq" autocomplete="off" placeholder="请输入QQ号" class="layui-input">
                        </div>

                        <label class="layui-form-label" for="wechat">微信</label>
                        <div class="layui-input-inline">
                            <input type="text" name="wechat" value="{{ $tq_student->wechat }}" id="wechat" autocomplete="off" placeholder="请输入微信" class="layui-input">
                        </div>

                        <label class="layui-form-label" for="level">学员等级</label>
                        <div class="layui-input-inline">
                            <select name="level" id="level">
                                <option @if($tq_student->level == 5) selected @endif value="5">A</option>
                                <option @if($tq_student->level == 4) selected @endif value="4">B</option>
                                <option @if($tq_student->level == 3) selected @endif value="3">C</option>
                                <option @if($tq_student->level == 2) selected @endif value="2">D</option>
                            </select>
                        </div>

                        <label class="layui-form-label" for="department-id">所属部门</label>
                        <div class="layui-input-inline">
                            <select name="department_id" id="department-id">
                                <option value="">请选择所属部门</option>
                                @foreach($departments as $department)
                                    <option @if($tq_student->department_id == $department->id) selected @endif value="{{ $department->id }}">{{ $department->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label" for="common-tested">参加公考</label>
                        <div class="layui-input-inline">
                            <input type="radio" @if($tq_student->common_tested == 1) checked @endif name="common_tested" value="1" id="common-tested" title="否" />
                            <input type="radio" @if($tq_student->common_tested == 2) checked @endif name="common_tested" value="2" id="common-tested" title="是" />
                        </div>

                        <label class="layui-form-label" for="trained">参加培训</label>
                        <div class="layui-input-inline">
                            <div class="layui-input-inline">
                                <input type="radio" @if($tq_student->trained == 1) checked @endif name="trained" value="1" id="trained" title="否" />
                                <input type="radio" @if($tq_student->trained == 2) checked @endif name="trained" value="2" id="trained" title="是" />
                            </div>
                        </div>

                        <label class="layui-form-label" for="resource-method">获取资源方式</label>
                        <div class="layui-input-inline">
                            <div class="layui-input-inline">
                                <input type="radio" @if($tq_student->resource_method == 1) checked @endif name="resource_method" value="1" id="resource-method" title="线下" />
                                <input type="radio" @if($tq_student->resource_method == 2) checked @endif name="resource_method" value="2" id="resource-method" title="线上" />
                            </div>
                        </div>

                        <label class="layui-form-label" for="belongs-to-department">资源归属部门</label>
                        <div class="layui-input-inline">
                            <select name="belongs_to_department" id="belongs-to-department">
                                <option value="">请选择资源归属部门</option>
                                <option @if($tq_student->belongs_to_department == 6) selected @endif value="6">科信在线</option>
                                <option @if($tq_student->belongs_to_department == 5) selected @endif value="5">公务员项目部</option>
                                <option @if($tq_student->belongs_to_department == 4) selected @endif value="4">企事业项目部</option>
                                <option @if($tq_student->belongs_to_department == 3) selected @endif value="3">教师项目部</option>
                                <option @if($tq_student->belongs_to_department == 2) selected @endif value="2">网络事业部</option>
                                <option @if($tq_student->belongs_to_department == 1) selected @endif value="1">高校事业部</option>
                            </select>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label" for="exam-type">考试方式</label>
                        <div class="layui-input-inline">
                            <select name="exam_type" id="exam-type">
                                <option value="">请选择考试方式</option>
                                <option @if($tq_student->exam_type == 1) selected @endif value="1">面试</option>
                                <option @if($tq_student->exam_type == 2) selected @endif value="2">笔试</option>
                            </select>
                        </div>

                        <label class="layui-form-label" for="way-to-visit">来访途径</label>
                        <div class="layui-input-inline">
                            <select name="way_to_visit" id="way-to-visit">
                                <option value="">请选择来访途径</option>
                                <option @if($tq_student->way_to_visit == 1) selected @endif value="1">网询</option>
                                <option @if($tq_student->way_to_visit == 2) selected @endif value="2">面询</option>
                                <option @if($tq_student->way_to_visit == 3) selected @endif value="3">电询</option>
                            </select>
                        </div>

                        <label class="layui-form-label" for="education">学历</label>
                        <div class="layui-input-inline">
                            <select name="education" id="education">
                                <option value="">请选择学历</option>
                                <option @if($tq_student->education == 7) selected @endif value="7">中专</option>
                                <option @if($tq_student->education == 6) selected @endif value="6">高中</option>
                                <option @if($tq_student->education == 5) selected @endif value="5">大专</option>
                                <option @if($tq_student->education == 4) selected @endif value="4">本科</option>
                                <option @if($tq_student->education == 3) selected @endif value="3">硕士</option>
                                <option @if($tq_student->education == 2) selected @endif value="2">博士</option>
                                <option @if($tq_student->education == 1) selected @endif value="1">博士后</option>
                            </select>
                        </div>

                        <label class="layui-form-label" for="identity">考生身份</label>
                        <div class="layui-input-inline">
                            <select name="identity" id="identity">
                                <option value="">请选择学历</option>
                                <option @if($tq_student->identity == 3) selected @endif value="3">在职</option>
                                <option @if($tq_student->identity == 2) selected @endif value="2">应届</option>
                                <option @if($tq_student->identity == 1) selected @endif value="1">其他</option>
                            </select>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label" for="party-number">是否党员</label>
                        <div class="layui-input-inline">
                            <input type="radio" @if($tq_student->party_number == 1) checked @endif name="party_number" value="1" id="party-number" title="是" />
                            <input type="radio" @if($tq_student->party_number == 2) checked @endif name="party_number" value="2" id="party-number" title="否" />
                        </div>

                        <label class="layui-form-label" for="belong-to">归属地</label>
                        <div class="layui-input-inline">
                            <select name="belong_to" id="belong-to">
                                @foreach($cities as $city)
                                    <option @if($tq_student->belong_to == $city->id) selected @endif value="{{ $city->id }}">{{ $city->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <div class="layui-col-md8">
                            <label class="layui-form-label" for="address">现住址</label>
                            <div class="layui-input-block">
                                <input type="text" name="address" value="{{ $tq_student->address }}" id="address" autocomplete="off" placeholder="请输入现住址" class="layui-input">
                            </div>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <div class="layui-col-md8">
                            <label class="layui-form-label" for="attestation">资格证</label>
                            <div class="layui-input-block">
                                <input type="text" name="attestation" value="{{ $tq_student->attestation }}" id="attestation" autocomplete="off" placeholder="请输入微信" class="layui-input">
                            </div>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label" for="school">毕业院校</label>
                        <div class="layui-input-inline">
                            <input type="text" name="school" value="{{ $tq_student->school }}" id="school" autocomplete="off" placeholder="请输入学员姓名" class="layui-input">
                        </div>

                        <label class="layui-form-label" for="major">专业</label>
                        <div class="layui-input-inline">
                            <input type="text" name="major" value="{{ $tq_student->major }}" id="major" autocomplete="off" placeholder="请输入学员姓名" class="layui-input">
                        </div>

                        <label class="layui-form-label" for="company">报考单位</label>
                        <div class="layui-input-inline">
                            <input type="text" name="company" value="{{ $tq_student->company }}" id="company" autocomplete="off" placeholder="请输入学员姓名" class="layui-input">
                        </div>

                        <label class="layui-form-label" for="job">报考职位</label>
                        <div class="layui-input-inline">
                            <input type="text" name="job" value="{{ $tq_student->job }}" id="job" autocomplete="off" placeholder="请输入学员姓名" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label" for="ID-card-no">身份证号</label>
                        <div class="layui-input-inline">
                            <input type="text" name="ID_card_no" value="{{ $tq_student->ID_card_no }}" id="ID-card-no" autocomplete="off" placeholder="请输入学员姓名" class="layui-input">
                        </div>

                        <label class="layui-form-label" for="examination">考试</label>
                        <div class="layui-input-inline">
                            <input type="text" name="examination" value="{{ $tq_student->examination }}" id="examination" autocomplete="off" placeholder="请输入学员姓名" class="layui-input">
                        </div>

                        <label class="layui-form-label" for="class-type">班型</label>
                        <div class="layui-input-inline">
                            <input type="text" name="class_type" value="{{ $tq_student->class_type }}" id="class-type" autocomplete="off" placeholder="请输入学员姓名" class="layui-input">
                        </div>

                        <label class="layui-form-label" for="political">政治面貌</label>
                        <div class="layui-input-inline">
                            <input type="text" name="political" value="{{ $tq_student->political }}" id="political" autocomplete="off" placeholder="请输入学员姓名" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label" for="english-level">英语等级</label>
                        <div class="layui-input-inline">
                            <input type="text" name="english_level" value="{{ $tq_student->english_level }}" id="english-level" autocomplete="off" placeholder="请输入学员姓名" class="layui-input">
                        </div>

                        <label class="layui-form-label" for="current-address">目前所在地</label>
                        <div class="layui-input-inline">
                            <input type="text" name="current_address" value="{{ $tq_student->current_address }}" id="current-address" autocomplete="off" placeholder="请输入学员姓名" class="layui-input">
                        </div>

                        <label class="layui-form-label" for="resource-owner">资源获取人</label>
                        <div class="layui-input-inline">
                            <input type="text" name="resource_owner" value="{{ $tq_student->resource_owner }}" id="resource-owner" autocomplete="off" placeholder="请输入学员姓名" class="layui-input">
                        </div>

                        <label class="layui-form-label" for="resource-activity">资源归属活动</label>
                        <div class="layui-input-inline">
                            <input type="text" name="resource_activity" value="{{ $tq_student->resource_activity }}" id="resource-activity" autocomplete="off" placeholder="请输入学员姓名" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <div class="layui-col-md8">
                            <label class="layui-form-label" for="remark">备注</label>
                            <div class="layui-input-block">
                                <textarea name="remark" id="remark" class="layui-textarea">{{ $tq_student->remark }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <div class="layui-input-block">
                            <input type="hidden" name="id" value="{{ $tq_student->id }}">
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
        TQ_students: {
            update: '{{ route_uri('TQ_students.update') }}',
        }
    };

    layui.use(['form'], function(){
        let form = layui.form;
        let $ = layui.$;

        form.on('submit(form-submit)', function(obj){
            $.ajax({
                type: 'PUT',
                url: route(routes.TQ_students.update),
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
                    else {
                        console.log(e);
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
