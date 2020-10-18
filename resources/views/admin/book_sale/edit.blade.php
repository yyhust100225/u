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
                <div class="layui-card-header">编辑新图书销售记录</div>
                <div class="layui-card-body">
                <form class="layui-form" action="">
                    @csrf

                    <div class="layui-form-item">
                        <label class="layui-form-label" for="book-id">图书</label>
                        <div class="layui-input-inline">
                            <select name="book_id" id="book-id">
                                @foreach($books as $book)
                                    <option @if($book_sale->book_id == $book->id) selected @endif value="{{ $book->id }}">{{ $book->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label" for="department-id">归属地</label>
                        <div class="layui-input-inline">
                            <select name="department_id" id="department-id">
                                @foreach($departments as $department)
                                    <option @if($book_sale->department_id == $department->id) selected @endif value="{{ $department->id }}">{{ $department->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <label class="layui-form-label" for="user-id">归属人</label>
                        <div class="layui-input-inline">
                            <select name="user_id" id="user-id">
                                @foreach($users as $user)
                                    <option @if($book_sale->user_id == $user->id) selected @endif value="{{ $user->id }}">{{ $user->username }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label" for="remark">备注</label>
                        <div class="layui-input-block">
                            <textarea class="layui-textarea" name="remark" id="remark">{{ $book_sale->remark }}</textarea>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <div class="layui-input-block">
                            <input type="hidden" name="id" value="{{ $book_sale->id }}">
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
            update: '{{ route_uri('book_sales.update') }}',
        }
    };

    layui.use(['form'], function(){
        var form = layui.form;
        var $ = layui.$;

        form.on('submit(form-submit)', function(obj){
            $.ajax({
                type: 'PUT',
                url: route(routes.book_sales.update),
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
