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
                <div class="layui-card-header">创建新图书销售记录</div>
                <div class="layui-card-body">
                <form class="layui-form" action="">
                    @csrf

                    <div class="layui-form-item">
                        <label class="layui-form-label" for="book-id">图书</label>
                        <div class="layui-input-inline">
                            <select name="book_id" id="book-id">
                                @foreach($books as $book)
                                    <option value="{{ $book->id }}">{{ $book->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label" for="department-id">归属地</label>
                        <div class="layui-input-inline">
                            <select name="department_id" id="department-id">
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <label class="layui-form-label" for="user-id">归属人</label>
                        <div class="layui-input-inline">
                            <select name="user_id" id="user-id">
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->username }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label" for="remark">备注</label>
                        <div class="layui-input-block">
                            <textarea class="layui-textarea" name="remark" id="remark"></textarea>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label" for="sale-record">销售记录</label>
                        <div class="layui-input-block">
                            <table id="sale-record" class="layui-table">
                                <thead>
                                <tr>
                                    <th>姓名</th>
                                    <th>性别</th>
                                    <th>身份证号</th>
                                    <th>电话</th>
                                    <th>销售数量</th>
                                    <th>缴费方式</th>
                                    <th>销售额</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td><input class="layui-input" name="name[]"></td>
                                    <td width="12%">
                                        <input type="radio" name="gender[]" value="0" title="男" checked>
                                        <input type="radio" name="gender[]" value="1" title="女">
                                    </td>
                                    <td><input class="layui-input" name="id_number[]"></td>
                                    <td><input class="layui-input" name="tel[]"></td>
                                    <td><input class="layui-input" name="quantity[]"></td>
                                    <td>
                                        <input class="layui-input" name="payment_method[]">
                                    </td>
                                    <td><input class="layui-input" name="cost[]"></td>
                                </tr>
                                </tbody>
                            </table>
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
    var routes = {
        book_sales: {
            list: '{{ route_uri('book_sales.list') }}',
            store: '{{ route_uri('book_sales.store') }}',
        }
    };

    layui.use(['form'], function(){
        var form = layui.form;
        var $ = layui.$;

        form.on('submit(form-submit)', function(obj){
            $.ajax({
                type: 'POST',
                url: route(routes.book_sales.store),
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
