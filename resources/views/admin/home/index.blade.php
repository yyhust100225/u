<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>layuiAdmin std - 通用后台管理模板系统（iframe标准版）</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="{{ asset('layuiadmin/layui/css/layui.css') }}" media="all">
    <link rel="stylesheet" href="{{ asset('layuiadmin/style/admin.css') }}" media="all">
    <link rel="stylesheet" href="{{ asset('layuiadmin/style/app.css') }}" media="all">
    <style>
        .layui-nav-bar {
            background-color: rgb(170, 49, 48);
        }
    </style>
</head>
<body class="layui-layout-body">

<div id="LAY_app">
    <div class="layui-layout layui-layout-admin">
        <div class="layui-header">
            <!-- 头部区域 -->
            <ul class="layui-nav layui-layout-left">
                <li class="layui-nav-item layadmin-flexible" lay-unselect>
                    <a href="javascript:;" layadmin-event="flexible" title="侧边伸缩">
                        <i class="layui-icon layui-icon-shrink-right" id="LAY_app_flexible"></i>
                    </a>
                </li>
                <li class="layui-nav-item layui-hide-xs" lay-unselect>
                    <a href="http://www.layui.com/admin/" target="_blank" title="前台">
                        <i class="layui-icon layui-icon-website"></i>
                    </a>
                </li>
                <li class="layui-nav-item" lay-unselect>
                    <a href="javascript:;" layadmin-event="refresh" title="刷新">
                        <i class="layui-icon layui-icon-refresh-3"></i>
                    </a>
                </li>
                <li class="layui-nav-item layui-hide-xs" lay-unselect>
                    <input type="text" placeholder="搜索..." autocomplete="off" class="layui-input layui-input-search" layadmin-event="serach" lay-action="template/search.html?keywords=">
                </li>
            </ul>
            <ul class="layui-nav layui-layout-right" lay-filter="layadmin-layout-right">

                <li class="layui-nav-item" lay-unselect>
                    <a lay-href="app/message/index.html" layadmin-event="message" lay-text="消息中心">
                        <i class="layui-icon layui-icon-notice"></i>

                        <!-- 如果有新消息，则显示小圆点 -->
                        <span class="layui-badge-dot"></span>
                    </a>
                </li>
                <li class="layui-nav-item layui-hide-xs" lay-unselect>
                    <a href="javascript:;" layadmin-event="theme">
                        <i class="layui-icon layui-icon-theme"></i>
                    </a>
                </li>
                <li class="layui-nav-item layui-hide-xs" lay-unselect>
                    <a href="javascript:;" layadmin-event="note">
                        <i class="layui-icon layui-icon-note"></i>
                    </a>
                </li>
                <li class="layui-nav-item layui-hide-xs" lay-unselect>
                    <a href="javascript:;" layadmin-event="fullscreen">
                        <i class="layui-icon layui-icon-screen-full"></i>
                    </a>
                </li>
                <li class="layui-nav-item" lay-unselect>
                    <a href="javascript:;">
                        <cite>{{ request()->user()->username }}</cite>
                    </a>
                    <dl class="layui-nav-child">
                        <dd style="text-align: center;"><a lay-href="set/user/info.html">基本资料</a></dd>
                        <dd style="text-align: center;"><a lay-href="{{ route('users.password') }}">修改密码</a></dd>
                        <hr>
                        <dd id="logout" style="text-align: center;"><a>退出</a></dd>
                    </dl>
                </li>

                <li class="layui-nav-item layui-hide-xs" lay-unselect>
                    <a href="javascript:;" layadmin-event="about"><i class="layui-icon layui-icon-more-vertical"></i></a>
                </li>
                <li class="layui-nav-item layui-show-xs-inline-block layui-hide-sm" lay-unselect>
                    <a href="javascript:;" layadmin-event="more"><i class="layui-icon layui-icon-more-vertical"></i></a>
                </li>
            </ul>
        </div>

        <!-- 侧边菜单 -->
        <div class="layui-side layui-side-menu">
            <div class="layui-side-scroll">
                <div class="layui-logo" lay-href="home/console.html">
                    <span>layuiAdmin</span>
                </div>

                <ul class="layui-nav layui-nav-tree" lay-shrink="all" id="LAY-system-side-menu" lay-filter="layadmin-system-side-menu">

                    <li data-name="home" class="layui-nav-item layui-nav-itemed">
                        <a href="javascript:;" lay-tips="主页" lay-direction="2">
                            <i class="layui-icon layui-icon-home"></i>
                            <cite>主页</cite>
                        </a>
                        <dl class="layui-nav-child">
                            <dd data-name="console" class="layui-this">
                                <a lay-href="home/console.html">控制台</a>
                            </dd>
                            <dd data-name="console">
                                <a lay-href="home/homepage1.html">主页一</a>
                            </dd>
                            <dd data-name="console">
                                <a lay-href="home/homepage2.html">主页二</a>
                            </dd>
                        </dl>
                    </li>

                    <li data-name="home" class="layui-nav-item">
                        <a href="javascript:;" lay-tips="主页" lay-direction="2">
                            <i class="layui-icon layui-icon-auz"></i>
                            <cite>权限设置</cite>
                        </a>
                        <dl class="layui-nav-child">
                            <dd data-name="users">
                                <a lay-href="users">用户列表</a>
                            </dd>
                            <dd data-name="roles">
                                <a lay-href="roles">角色列表</a>
                            </dd>
                            <dd data-name="permissions">
                                <a lay-href="permissions">权限列表</a>
                            </dd>
                        </dl>
                    </li>

                    <li data-name="home" class="layui-nav-item">
                        <a href="javascript:;" lay-tips="集团要讯" lay-direction="2">
                            <i class="layui-icon layui-icon-survey"></i>
                            <cite>集团要讯</cite>
                        </a>
                        <dl class="layui-nav-child">
                            <dd data-name="notices">
                                <a lay-href="notices">要讯通知</a>
                            </dd>
                            <dd data-name="notices/reviews">
                                <a lay-href="notices/reviews">要讯审核</a>
                            </dd>
                            <dd data-name="notices/publish">
                                <a lay-href="notices/publish">发布要讯</a>
                            </dd>
                        </dl>
                    </li>

                    {{-- 开班管理 --}}
                    <li data-name="home" class="layui-nav-item">
                        <a href="javascript:;" lay-tips="开班管理" lay-direction="2">
                            <i class="layui-icon layui-icon-read"></i>
                            <cite>开班管理</cite>
                        </a>
                        <dl class="layui-nav-child">
                            <dd data-name="class_announcements">
                                <a lay-href="class_announcements">开班公告</a>
                            </dd>
                        </dl>
                        <dl class="layui-nav-child">
                            <dd data-name="class_examinations">
                                <a lay-href="class_examinations">考试管理</a>
                            </dd>
                        </dl>
                    </li>

                    {{-- 行政结构 --}}
                    <li data-name="home" class="layui-nav-item">
                        <a href="javascript:;" lay-tips="行政结构" lay-direction="2">
                            <i class="layui-icon layui-icon-release"></i>
                            <cite>行政结构</cite>
                        </a>
                        <dl class="layui-nav-child">
                            <dd data-name="departments">
                                <a lay-href="departments">行政部门</a>
                            </dd>
                        </dl>
                    </li>
                    {{-- 人事部 --}}
                    <li data-name="home" class="layui-nav-item">
                        <a href="javascript:;" lay-tips="人事部" lay-direction="2">
                            <i class="layui-icon layui-icon-user"></i>
                            <cite>人事部</cite>
                        </a>
                        <dl class="layui-nav-child">
                            <dd data-name="employees">
                                <a lay-href="employees">员工档案</a>
                            </dd>
                        </dl>
                    </li>
                    {{-- 项目部 --}}
                    <li data-name="home" class="layui-nav-item">
                        <a href="javascript:;" lay-tips="项目部" lay-direction="2">
                            <i class="layui-icon layui-icon-component"></i>
                            <cite>项目部</cite>
                        </a>
                        <dl class="layui-nav-child">
                            <dd data-name="books">
                                <a lay-href="books">书籍库存</a>
                            </dd>
                        </dl>
                        <dl class="layui-nav-child">
                            <dd data-name="materiels">
                                <a lay-href="materiels">物料库存</a>
                            </dd>
                        </dl>
                        <dl class="layui-nav-child">
                            <dd data-name="printers">
                                <a lay-href="printers">印刷厂</a>
                            </dd>
                        </dl>
                        <dl class="layui-nav-child">
                            <dd data-name="printed_matters">
                                <a lay-href="printed_matters">印刷品</a>
                            </dd>
                        </dl>
                        <dl class="layui-nav-child">
                            <dd data-name="exam_categories">
                                <a lay-href="exam_categories">考试大类</a>
                            </dd>
                        </dl>
                        <dl class="layui-nav-child">
                            <dd data-name="exams">
                                <a lay-href="exams">考试管理</a>
                            </dd>
                        </dl>
                        <dl class="layui-nav-child">
                            <dd data-name="statements">
                                <a lay-href="statements">对账单</a>
                            </dd>
                        </dl>
                        <dl class="layui-nav-child">
                            <dd data-name="book_sales">
                                <a lay-href="book_sales">图书销售</a>
                            </dd>
                        </dl>
                    </li>
                    {{-- 系统设置 --}}
                    <li data-name="set" class="layui-nav-item">
                        <a href="javascript:;" lay-tips="系统设置" lay-direction="2">
                            <i class="layui-icon layui-icon-set"></i>
                            <cite>系统设置</cite>
                        </a>
                        <dl class="layui-nav-child">
                            <dd class="">
                                <a href="javascript:;">支付设置</a>
                                <dl class="layui-nav-child">
                                    <dd data-name="payment_methods">
                                        <a lay-href="payment_methods">支付方式设置</a>
                                    </dd>
                                </dl>
                            </dd>
                            <dd class="">
                                <a href="javascript:;">系统常量设置</a>
                                <dl class="layui-nav-child">
                                    <dd data-name="cities">
                                        <a lay-href="cities">城市设置</a>
                                    </dd>
                                    <dd data-name="nations">
                                        <a lay-href="nations">民族设置</a>
                                    </dd>
                                    <dd data-name="jobs">
                                        <a lay-href="jobs">员工职务</a>
                                    </dd>
                                    <dd data-name="insurance_areas">
                                        <a lay-href="insurance_areas">保险地区</a>
                                    </dd>
                                    <dd data-name="notice_types">
                                        <a lay-href="notice_types">要讯类型</a>
                                    </dd>
                                </dl>
                            </dd>
                        </dl>
                    </li>
                </ul>
            </div>
        </div>

        <!-- 页面标签 -->
        <div class="layadmin-pagetabs" id="LAY_app_tabs">
            <div class="layui-icon layadmin-tabs-control layui-icon-prev" layadmin-event="leftPage"></div>
            <div class="layui-icon layadmin-tabs-control layui-icon-next" layadmin-event="rightPage"></div>
            <div class="layui-icon layadmin-tabs-control layui-icon-down">
                <ul class="layui-nav layadmin-tabs-select" lay-filter="layadmin-pagetabs-nav">
                    <li class="layui-nav-item" lay-unselect>
                        <a href="javascript:;"></a>
                        <dl class="layui-nav-child layui-anim-fadein">
                            <dd layadmin-event="closeThisTabs"><a href="javascript:void(0);">关闭当前标签页</a></dd>
                            <dd layadmin-event="closeOtherTabs"><a href="javascript:;">关闭其它标签页</a></dd>
                            <dd layadmin-event="closeAllTabs"><a href="javascript:;">关闭全部标签页</a></dd>
                        </dl>
                    </li>
                </ul>
            </div>
            <div class="layui-tab" lay-unauto lay-allowClose="true" lay-filter="layadmin-layout-tabs">
                <ul class="layui-tab-title" id="LAY_app_tabsheader">
                    <li lay-id="home/console.html" lay-attr="home/console.html" class="layui-this"><i class="layui-icon layui-icon-home"></i></li>
                </ul>
            </div>
        </div>


        <!-- 主体内容 -->
        <div class="layui-body" id="LAY_app_body">
            <div class="layadmin-tabsbody-item layui-show">
                <iframe src="http://www.baidu.com" frameborder="0" class="layadmin-iframe"></iframe>
            </div>
        </div>

        <!-- 辅助元素，一般用于移动设备下遮罩 -->
        <div class="layadmin-body-shade" layadmin-event="shade"></div>
    </div>
</div>

<script src="{{ asset('layuiadmin/layui/layui.js') }}"></script>
<script>

    // 页面路由
    var routes = {
        users: {
            password: '{{ route_uri('users.password') }}',
        }
    };

    layui.config({
        base: 'layuiadmin/' //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
    }).use('index');

    layui.use('jquery', function(){
        var $ = layui.$;

        $('#logout').click(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('{{ route("logout") }}', {}, function(res){
                layer.msg(res.message, {time: 2000}, function(){
                    window.location.href = "{{ route('login.form') }}";
                })
            }, 'json');
        });


    });
</script>
</body>
</html>


