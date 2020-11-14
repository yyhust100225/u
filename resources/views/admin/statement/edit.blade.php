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
                <div class="layui-card-header">编辑对账单</div>
                <div class="layui-card-body">
                    <form class="layui-form" action="">
                        @csrf
                        <div class="layui-form-item">
                            <label class="layui-form-label" for="printer-id">印刷厂名称</label>
                            <div class="layui-input-inline">
                                <select name="printer_id" id="printer-id">
                                    @foreach($printers as $printer)
                                        <option @if($statement->printer_id == $printer->id) selected @endif value="{{ $printer->id }}">{{ $printer->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label" for="publish-date">发稿日期</label>
                            <div class="layui-input-inline">
                                <input value="{{ $statement->publish_date }}" class="layui-input" type="text" name="publish_date" placeholder="yyyy-MM-dd" id="publish-date" />
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">考试大类</label>
                            <div class="layui-input-block">
                                @foreach($exam_categories as $exam_category)
                                    <input @if(in_array($exam_category->id, $statement->exam_category_ids)) checked @endif type="checkbox" name="exam_categories[{{ $exam_category->id }}]" title="{{ $exam_category->name }}" lay-skin="primary" />
                                @endforeach
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label">考试名称</label>
                            <div class="layui-input-inline">
                                <div id="exams"></div>
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label" for="department-id">隶属部门</label>
                            <div class="layui-input-inline">
                                <select name="department_id" id="department-id">
                                    @foreach($departments as $department)
                                        <option @if($statement->department_id == $department->id) selected @endif value="{{ $department->id }}">{{ $department->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label" for="printed-matter-id">印刷品名称</label>
                            <div class="layui-input-inline">
                                <select name="printed_matter_id" id="printed-matter-id">
                                    @foreach($printed_matters as $printed_matter)
                                        <option @if($statement->printed_matter_id == $printed_matter->id) selected @endif value="{{ $printed_matter->id }}">{{ $printed_matter->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label" for="print-detail">印刷明细</label>
                            <div class="layui-input-block">
                                <textarea class="layui-textarea" name="print_detail" id="print-detail">{{ $statement->print_detail }}</textarea>
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label" for="quantity-print">数量</label>
                            <div class="layui-input-inline">
                                <input value="{{ $statement->quantity_print }}" class="layui-input" type="text" name="quantity_print" id="quantity-print" />
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label" for="price-print">单价</label>
                            <div class="layui-input-inline">
                                <input value="{{ $statement->price_print }}" class="layui-input" type="text" name="price_print" id="price-print" />
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label" for="designer-quote-price">设计师报价</label>
                            <div class="layui-input-inline">
                                <input value="{{ $statement->designer_quote_price }}" class="layui-input" type="text" name="designer_quote_price" id="designer-quote-price" />
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <label class="layui-form-label" for="remark">账单备注</label>
                            <div class="layui-input-block">
                                <textarea class="layui-textarea" name="remark" id="remark">{{ $statement->remark }}</textarea>
                            </div>
                        </div>

                        <div class="layui-form-item">
                            <div class="layui-input-block">
                                <input type="hidden" name="id" value="{{ $statement->id }}">
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
<script src="{{ asset('assets/js/xm-select.js') }}"></script>
<script>

    // 页面路由
    let routes = {
        statements: {
            list: '{{ route_uri('statements.list') }}',
            update: '{{ route_uri('statements.update') }}',
        }
    };

    layui.use(['form', 'laydate'], function(){
        let form = layui.form;
        let laydate = layui.laydate;
        let $ = layui.$;

        form.on('submit(form-submit)', function(obj){
            $.ajax({
                type: 'PUT',
                url: route(routes.statements.update),
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

        laydate.render({
            elem: '#publish-date',
            type: 'date'
        });
    });

    let exams_select = xmSelect.render({
        el: '#exams',
        language: 'zn',
        filterable: true,
        autoRow: true,
        name: 'exams',
        data: [
            @foreach($exams as $exam)
                {name: '{{ $exam->name }}', value: {{ $exam->id }} @if(in_array($exam->id, $statement->exam_ids)) ,selected: true @endif},
            @endforeach
        ]
    })

</script>

</body>
</html>
