<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckMember
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // 获取登录的用户信息
        $member = auth('member')->user();
        // 判断没有登录
        if (!$member) {
            return response()->json(['code' => 401, 'msg' => '请先登录']);
        }
        return $next($request);
    }
}
