<?php

namespace App\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminVal;
use App\Models\Admin as AdminModel;
use App\Models\AdminGroup;
use App\Models\AdminRule;
use App\Models\AdminRuleButton;
use Exception;
use Illuminate\Http\Request;

class Admin extends Controller
{

    /**
     * 列表
     */
    public function index(Request $request)
    {
        $data = AdminModel::orderBy('id', 'desc')->paginate($this->limit($request))->toArray();
        foreach ($data['data'] as &$val) {
            if ($val['gid'] == '0') {
                $val['group_title'] = '所有权限';
            } else {
                $val['group_title'] = AdminGroup::find($val['gid'])['title'];
            }
            $val['gid'] = strval($val['gid']);
        }
        return $this->success('success', $data['data'], $data['total']);
    }

    /**
     * 生成前端路由
     */
    public function router(Request $request)
    {
        return $this->success('success', $this->routers());
    }

    /**
     * 获取路由权限列表
     * $type    前端路由(web)   后端路由(admin)
     */
    public function routers($type = 'web')
    {
        $res = [];
        // 获取登录的用户信息
        $admin = auth()->user();
        if ($admin['gid'] == 0) {
            $data = AdminRule::where('show', 1)->orderBy('sort', 'asc')->get()->toArray();
        } else {
            // 获取管理员分组
            $group = AdminGroup::find($admin['gid']);
            // 查询分组规则id
            $rule_arr = explode(",", $group['rule']);
            // 查询所有的路由
            $data = AdminRule::whereIn('id', $rule_arr)->orderBy('sort', 'asc')->where('show', 1)->get()->toArray();
        }
        // 判断是否为前端路由
        if ($type == 'web') {
            // 循环所有的路由
            foreach ($data as $v) {
                // 获取对应的按钮
                $v['button'] = AdminRuleButton::where('show', '1')->where('rule_id', $v['id'])->get()->toArray();
                // 移除非必要字段
                unset($v['sort'], $v['admin'], $v['show'], $v['created_at'], $v['updated_at'], $v['deleted_at']);
                $res[] = $v;
            }
            // 路由转树
            $res = $this->getRouter($res);
        }
        // 判断是否为后端路由
        if ($type == 'admin') {
            // 循环所有的路由
            foreach ($data as $v) {
                // 判断admin(后端控制器/方法)是否存在
                if (isset($v['admin']) && $v['admin']) {
                    // 控制器方法字符串转为数组
                    $arr = explode('/', $v['admin']);
                    // 设置键和值
                    $res[$arr[0]][] = $arr[1];
                }
                // 获取对应的按钮
                if (isset($v['id'])) {
                    $button = AdminRuleButton::where('show', '1')->where('rule_id', $v['id'])->get()->toArray();
                    // 循环所有的按钮
                    foreach ($button as $b) {
                        // 判断admin(后端控制器/方法)是否存在
                        if ($b['admin'] && $v['admin']) {
                            // 控制器方法字符串转为数组
                            $arr = explode('/', $v['admin']);
                            // 设置键和值
                            $res[$arr[0]][] = $arr[1];
                        }
                    }
                }
            }
        }
        return $res;
    }

    /**
     * 生成菜单路由树
     */
    public function getRouter($list, $pid = 0)
    {
        $tree = [];
        if (!empty($list)) {
            $newList = [];
            foreach ($list as &$v) {
                if ($v['menu'] == 1) {
                    $v['meta']['menu'] = true;
                } else {
                    $v['meta']['menu'] = false;
                }
                if ($v['layout'] == 1) {
                    $v['meta']['layout'] = true;
                } else {
                    $v['meta']['layout'] = false;
                }
                $v['meta']['auth'] = true;

                unset($v['menu'], $v['layout']);
                $newList[$v['id']] = $v;
            }
            foreach ($newList as $value) {
                if ($pid == $value['pid']) {
                    $tree[] = &$newList[$value['id']];
                    $newList[$value['id']]['component'] = 'Layout';
                } elseif (isset($newList[$value['pid']])) {
                    $newList[$value['pid']]['children'][] = &$newList[$value['id']];
                }
//                unset($newList[$value['id']]['id'], $newList[$value['id']]['pid']);
            }
        }
        return $tree;
    }

    /**
     * 添加/更新
     */
    public function set(Request $request)
    {
        // 获取数据并且清除空数组
        $post = $this->filterNull($request->post());
        $ver = $this->validatorData($post, new AdminVal());
        // 检测验证是否通过
        if ($ver != 1) {
            // 输出验证失败信息
            return $this->error($ver);
        }
        if ($request->id) {
            try {
                // 判断是否有更新登录密码
                if ($request->password) {
                    $post['password'] = bcrypt($request->password);
                }
                // 移除非必要信息
                $post = $this->moveField($post, ['id', 'group_title']);
                AdminModel::find($request->id)->update($post);
                $res = $this->success('管理员更新成功');
            } catch (Exception $exception) {
                $res = $this->error($exception->getMessage());
            }
        } else {
            try {
                // 判断密码是否存在
                if (!$request->password) {
                    return $this->error('密码不能为空');
                }
                // 对密码进行加密
                $post['password'] = bcrypt($request->password);
                // 创建管理数据
                AdminModel::create($post);
                $res = $this->success('添加成功');
            } catch (Exception $exception) {
                $res = $this->error('数据库异常：', $exception->getMessage());
            }
        }
        return $res;
    }

    /**
     * 删除
     */
    public function destroy(Request $request)
    {
        try {
            AdminModel::find($request->id)->delete();
            $res = $this->success('删除成功');
        } catch (Exception $exception) {
            $res = $this->error($exception->getMessage());
        }
        return $res;
    }

    public function login(Request $request)
    {
        $input = $request->only('username', 'password');
        $token = auth()->attempt($input);
        if ($token) {
            $res = $this->success('登录成功', ['token' => $token]);
        } else {
            $res = $this->error('用户密码错误');
        }
        return $res;
    }

    public function logout(Request $request)
    {
        auth()->logout();
        return $this->success('用户退出成功,请重新登录');
    }
}
