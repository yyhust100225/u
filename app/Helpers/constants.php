<?php

define('REQUEST_SUCCESS', 10000);
define('REQUEST_FAILED', 10001);

define('RESPONSE_SUCCESS', 0);

// 权限等级
define('AUTHORIZATION_LEVEL_ALL_ALLOWED', 3);
define('AUTHORIZATION_LEVEL_ON_USER', 2);
define('AUTHORIZATION_LEVEL_ALL_DENIED', 1);

// 对账单状态
define('STATEMENT_NOT_VERIFIED', 0);
define('STATEMENT_VALIDATION_FAILED', 1);
define('STATEMENT_VALIDATION_SUCCESSFUL', 2);

// 集团要讯状态
define('NOTICE_SUBMITTED', 1);  // 已提交
define('NOTICE_VIEWED', 2);     // 已查看
define('NOTICE_APPROVED', 3);   // 审核通过
define('NOTICE_REJECT', 4);     // 审核驳回
