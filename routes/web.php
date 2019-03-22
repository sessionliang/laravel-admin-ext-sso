<?php

use DM\SSO\Http\Controllers\SSOController;

// 应用跳转地址
Route::get('/sso/{ticket}', SSOController::class.'@sso');