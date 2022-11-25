<?php

use App\Api\Http\Controllers\Member;
use App\Http\Middleware\CheckMember;
use Illuminate\Support\Facades\Route;

Route::post('member/reg', [Member::class, 'reg']);
Route::post('member/login', [Member::class, 'login']);

// 使用登录中间件，必须要登录
Route::middleware([CheckMember::class])->group(function () {
    Route::get('member/relation', [Member::class, 'relation']);
});
