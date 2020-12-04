<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'The :attribute must be accepted.',
    'active_url' => 'The :attribute is not a valid URL.',
    'after' => 'The :attribute must be a date after :date.',
    'after_or_equal' => ':attribute 需要在 :date 之后或相同',
    'alpha' => 'The :attribute may only contain letters.',
    'alpha_dash' => 'The :attribute may only contain letters, numbers, dashes and underscores.',
    'alpha_num' => 'The :attribute may only contain letters and numbers.',
    'array' => 'The :attribute must be an array.',
    'before' => 'The :attribute must be a date before :date.',
    'before_or_equal' => 'The :attribute must be a date before or equal to :date.',
    'between' => [
        'numeric' => ':attribute需要输入:min到:max之间.',
        'file' => 'The :attribute must be between :min and :max kilobytes.',
        'string' => 'The :attribute must be between :min and :max characters.',
        'array' => 'The :attribute must have between :min and :max items.',
    ],
    'boolean' => 'The :attribute field must be true or false.',
    'confirmed' => 'The :attribute confirmation does not match.',
    'date' => 'The :attribute is not a valid date.',
    'date_equals' => 'The :attribute must be a date equal to :date.',
    'date_format' => 'The :attribute does not match the format :format.',
    'different' => 'The :attribute and :other must be different.',
    'digits' => 'The :attribute must be :digits digits.',
    'digits_between' => 'The :attribute must be between :min and :max digits.',
    'dimensions' => 'The :attribute has invalid image dimensions.',
    'distinct' => 'The :attribute field has a duplicate value.',
    'email' => ':attribute 格式不正确, 请输入正确的邮箱格式',
    'ends_with' => 'The :attribute must end with one of the following: :values.',
    'exists' => 'The selected :attribute is invalid.',
    'file' => 'The :attribute must be a file.',
    'filled' => 'The :attribute field must have a value.',
    'gt' => [
        'numeric' => 'The :attribute must be greater than :value.',
        'file' => 'The :attribute must be greater than :value kilobytes.',
        'string' => 'The :attribute must be greater than :value characters.',
        'array' => 'The :attribute must have more than :value items.',
    ],
    'gte' => [
        'numeric' => 'The :attribute must be greater than or equal :value.',
        'file' => 'The :attribute must be greater than or equal :value kilobytes.',
        'string' => 'The :attribute must be greater than or equal :value characters.',
        'array' => 'The :attribute must have :value items or more.',
    ],
    'image' => 'The :attribute must be an image.',
    'in' => 'The selected :attribute is invalid.',
    'in_array' => 'The :attribute field does not exist in :other.',
    'integer' => ':attribute 请输入整数',
    'ip' => 'The :attribute must be a valid IP address.',
    'ipv4' => 'The :attribute must be a valid IPv4 address.',
    'ipv6' => 'The :attribute must be a valid IPv6 address.',
    'json' => 'The :attribute must be a valid JSON string.',
    'lt' => [
        'numeric' => 'The :attribute must be less than :value.',
        'file' => 'The :attribute must be less than :value kilobytes.',
        'string' => 'The :attribute must be less than :value characters.',
        'array' => 'The :attribute must have less than :value items.',
    ],
    'lte' => [
        'numeric' => 'The :attribute must be less than or equal :value.',
        'file' => 'The :attribute must be less than or equal :value kilobytes.',
        'string' => 'The :attribute must be less than or equal :value characters.',
        'array' => 'The :attribute must not have more than :value items.',
    ],
    'max' => [
        'numeric' => 'The :attribute may not be greater than :max.',
        'file' => 'The :attribute may not be greater than :max kilobytes.',
        'string' => ':attribute 不能超过:max个字符',
        'array' => 'The :attribute may not have more than :max items.',
    ],
    'mimes' => 'The :attribute must be a file of type: :values.',
    'mimetypes' => 'The :attribute must be a file of type: :values.',
    'min' => [
        'numeric' => 'The :attribute must be at least :min.',
        'file' => 'The :attribute must be at least :min kilobytes.',
        'string' => ':attribute 最少 :min 个字符',
        'array' => 'The :attribute must have at least :min items.',
    ],
    'not_in' => 'The selected :attribute is invalid.',
    'not_regex' => 'The :attribute format is invalid.',
    'numeric' => ':attribute 请输入数字',
    'password' => 'The password is incorrect.',
    'present' => 'The :attribute field must be present.',
    'regex' => 'The :attribute format is invalid.',
    'required' => '请填写:attribute',
    'required_if' => 'The :attribute field is required when :other is :value.',
    'required_unless' => 'The :attribute field is required unless :other is in :values.',
    'required_with' => 'The :attribute field is required when :values is present.',
    'required_with_all' => 'The :attribute field is required when :values are present.',
    'required_without' => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same' => ':attribute 必须与 :other 一致',
    'size' => [
        'numeric' => 'The :attribute must be :size.',
        'file' => 'The :attribute must be :size kilobytes.',
        'string' => 'The :attribute must be :size characters.',
        'array' => 'The :attribute must contain :size items.',
    ],
    'starts_with' => 'The :attribute must start with one of the following: :values.',
    'string' => 'The :attribute must be a string.',
    'timezone' => 'The :attribute must be a valid zone.',
    'unique' => ':attribute 已存在, 请更换重试',
    'uploaded' => 'The :attribute failed to upload.',
    'url' => ':attribute 请输入正确格式的url地址',
    'uuid' => 'The :attribute must be a valid UUID.',

    // 自定义验证规则消息
    'verify_unsigned_integer' => ':attribute必须为正整数',
    'verify_unsigned_float' => ':attribute必须为正数',

    'check_password' => '新密码 需与 :attribute 一致',
    'username_unique' => '账户名已存在, 请更换重试',
    'email_unique' => '邮箱已存在, 请更换重试',
    'department_name_unique' => '部门名称已存在, 请更换名称重试',
    'exams_null' => '请至少选择一项 :attribute',
    'exam_categories_null' => '请至少选择一项 :attribute',
    'publish_date_format' => ':attribute 必须是 yyyy-MM-dd 日期格式',
    'book_sale_name_null' => '销售记录姓名不能为空, 如不需要, 请删除该行',
    'at_least_one' => '请至少选择一人推送要讯',
    'tq_id_exists' => 'TQID已存在, 请选择其他学员录入',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
//        'attribute-name' => [
//            'rule-name' => 'custom-message',
//        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [

        // 公用字段
        'start_time' => '开始时间',
        'end_time' => '结束时间',

        // 用户表字段
        'username' => '用户名',
        'email' => '邮箱',
        'password' => '密码',
        'o_password' => '旧密码',
        'n_password' => '新密码',
        '_password' => '密码确认',

        'book_name' => '书籍名称',
        'quantity_total' => '总数',
        'quantity_sold' => '出售量',
        'quantity_give' => '赠送量',
        'quantity_return' => '返还数量',
        'quantity_supplement' => '补充数量',

        'materiel_name' => '物料名称',
        'quantity_scrap' => '报废数量',
        'quantity_consume' => '消耗数量',
        'quantity_incomplete' => '残缺数量',

        'printer_name' => '印刷厂名称',
        'printed_matter_name' => '印刷品名称',
        'exam_name' => '考试名称',
        'exam_categories' => '考试大类',
        'exams' => '考试',
        'publish_date' => '发稿日期',
        'quantity_print' => '印刷品数量',
        'price_print' => '印刷品单价',
        'designer_quote_price' => '设计报价',
        'notice_type_name' => '要讯类型名称',
        'job_name' => '职务名称',
        'insurance_area_name' => '保险地区名称',
        'nation_name' => '民族名称',

        // 支付设置
        'payment_method_name' => '支付方式名称',

        // 图书售卖记录
        'book_sale_quantity' => '销售数量',
        'book_sale_name' => '姓名',
        'book_sale_cost' => '销售额',

        // 员工档案信息
        'employee_name' => '员工姓名',

        // 集团要讯
        'notice_title' => '要讯标题',
        'notice_content' => '要讯内容',

        // 开班管理
        'class_announcement_title' => '公告标题',
        'class_announcement_link' => '公告链接',
        'candidate_num' => '招考人数',
        'written_exam_activity_num' => '笔试活动人数',
        'written_exam_in_examination_num' => '笔试考试人数',
        'interview_activity_num' => '面试活动人数',
        'pass_percent' => '自然通过率',
        'class_examination_name' => '考试名称',
        'announcement_id' => '所属公告',
        'examination_id' => '所属考试',
        'discount_type_id' => '优惠类型',
        'examination_discount_amount' => '考试优惠金额',

        // 班型管理
        'class_type_name' => '班型名称',
        'written_examination_days' => '笔试白天',
        'written_examination_nights' => '笔试夜晚',
        'interview_days' => '面试白天',
        'interview_nights' => '面试夜晚',
        'total_tuition' => '总学费',
        'per_day_tuition' => '每日学费',
        'written_examination_refund' => '笔试退费',
        'interview_refund' => '面试退费',
        'type_id' => '所属班型',
        'type_discount_name' => '班型优惠名称',
        'type_discount_amount' => '班型优惠金额',

        // 班级管理
        'class_course_name' => '班级名称',
        'class_type_id' => '所属班型',
        'class_course_type_id' => '开课类型',
        'class_course_department_id' => '开课校区',
        'class_course_address' => '开课地址',
        'class_course_date' => '开课时间',
        'max_person_num' => '封班人数',

        // 学员管理
        'student_name' => '学员姓名',
        'tq_id' => 'TQ学员信息ID',
        'class_course_id' => '学员报班',

        // 教务管理
        'teacher_name' => '讲师姓名',
        'course_fee_id' => '课时费用',
        'teacher_group_id' => '讲师分组',
        'subject_name' => '科目名称',

    ],
];
