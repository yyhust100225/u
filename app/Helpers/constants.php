<?php

define('REQUEST_SUCCESS', 10000);
define('REQUEST_FAILED', 10001);
define('AUTHORITY_EXPIRED', 10002);

define('RESPONSE_SUCCESS', 0);

// 状态
define('STATUS_OFF', 0);
define('STATUS_ON', 1);

// 权限等级
define('AUTHORIZATION_LEVEL_ALL_ALLOWED', 3);
define('AUTHORIZATION_LEVEL_ON_USER', 2);
define('AUTHORIZATION_LEVEL_ALL_DENIED', 1);

// 对账单状态
define('STATEMENT_NOT_VERIFIED', 0);
define('STATEMENT_VALIDATION_FAILED', 1);
define('STATEMENT_VALIDATION_SUCCESSFUL', 2);

// 集团要讯状态
define('NOTICE_SAVED', 0);      // 已保存
define('NOTICE_SUBMITTED', 1);  // 已提交
define('NOTICE_VIEWED', 2);     // 已查看
define('NOTICE_APPROVED', 3);   // 审核通过
define('NOTICE_REJECT', 4);     // 审核驳回

// 学员管理 - TQ
define('TQ_SYNC_NOT_ALLOWED', 1);
define('TQ_SYNC_ALLOWED', 2);

/** 开班管理 **/

// 优惠类型
define('CLASS_EXAMINATION_DISCOUNT', 1);
define('CLASS_TYPE_DISCOUNT', 2);
