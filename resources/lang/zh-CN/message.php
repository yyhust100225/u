<?php

return [
    // 日志记录信息
    'log' => [
        'an empty query occurred' => '有空查询发生',
    ],

    'errors' => [
        '401' => '身份认证失效或过期, 请刷新页面后重新登录',
        '404' => '抱歉, 找不到指定资源',
    ],

    'table' => [
        'time slot' => ':start 至 :end',
        'examination and class type' => '所属考试: :examination_name, 所属班型: :class_type_name',
        'full class course name' => '所属考试: :examination_name, 所属班型: :class_type_name, 所属班级: :class_course_name',
    ],

    'db' => [
        'tq sync error' => 'TQ同步出错, 请排查原因',
    ],
];
