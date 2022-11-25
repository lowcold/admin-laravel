<?php

namespace App\Http\Middleware;

use App\Admin\Http\Controllers\Admin;
use Closure;
use Illuminate\Http\Request;

class CheckAdmin
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
        // 获取用户信息
        $admin = auth()->user();
        // 判断用户没有登录
        if (!$admin) {
            // 返回401，提示登录
            return response()->json(['code' => 401, 'msg' => '请先登录']);
        }
        // 排除的admin方法
        $arr = ['login', 'router', 'routers'];
        // 调用admin控制器
        $adminController = new Admin();
        // 获取当前的方法
        $action = $this->getAction();
        // 获取当前的控制器
        $controller = $this->getController();
        // 获取权限列表
        $routers = $adminController->routers('admin');
        //  判断控制器是否为admin
        if ($controller == 'admin') {
            // 是否不等于排除的admin方法
            if (!in_array($action, $arr)) {
                // 判断权限中是否存在当前控制器
                if (!array_key_exists($controller, $routers)) {
                    return response()->json(['code' => 0, 'msg' => '没有操作权限']);
                }
                if (!in_array($action, $routers)) {
                    return response()->json(['code' => 0, 'msg' => '没有操作权限']);
                }
            }
        } else {
            if (!array_key_exists($controller, $routers)) {
                return response()->json(['code' => 0, 'msg' => '没有操作权限']);
            }
            if (!in_array($action, $routers)) {
                return response()->json(['code' => 0, 'msg' => '没有操作权限']);
            }
        }
        return $next($request);
    }

    public function getAction()
    {
        return request()->route()->getActionMethod();;
    }

    public function getController()
    {
        $str = request()->route()->getActionName();
        $str = explode('@', $str)[0];
        $str = explode('Controllers', $str)[1];
        $str = str_replace('\\', '', $str);
        return strtolower($str);
    }
}
