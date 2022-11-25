<?php

use App\Admin\Http\Controllers\Admin;
use App\Admin\Http\Controllers\AdminGroup;
use App\Admin\Http\Controllers\AdminRule;
use App\Admin\Http\Controllers\Member;
use App\Admin\Http\Controllers\MemberGrade;
use App\Http\Middleware\CheckAdmin;
use Illuminate\Support\Facades\Route;

Route::post('login', [Admin::class, 'login']);
Route::get('test', [Admin::class, 'test']);
Route::middleware([CheckAdmin::class])->group(function () {

    Route::get('logout', [Admin::class, 'logout']);
    Route::get('router', [Admin::class, 'router']);

    Route::get('admin', [Admin::class, 'index']);
    Route::post('admin/set', [Admin::class, 'set']);
    Route::post('admin/del', [Admin::class, 'destroy']);

    Route::get('admin/group', [AdminGroup::class, 'index']);
    Route::post('admin/group/set', [AdminGroup::class, 'set']);
    Route::post('admin/group/del', [AdminGroup::class, 'destroy']);

    Route::get('admin/rule', [AdminRule::class, 'index']);
    Route::post('admin/rule/set', [AdminRule::class, 'set']);
    Route::post('admin/rule/sort', [AdminRule::class, 'sort']);
    Route::post('admin/rule/show', [AdminRule::class, 'show']);

    Route::get('member', [Member::class, 'index']);
    Route::post('member/set', [Member::class, 'set']);
    Route::post('member/del', [Member::class, 'destroy']);

    Route::get('member/grade', [MemberGrade::class, 'index']);
    Route::post('member/grade/set', [MemberGrade::class, 'set']);
    Route::post('member/grade/del', [MemberGrade::class, 'destroy']);
});
