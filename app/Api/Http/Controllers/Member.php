<?php

namespace App\Api\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\MemberVal;
use App\Models\Member as MemberModel;
use Illuminate\Http\Request;

class Member extends Controller
{
    /**
     * 获取用户关系
     */
    public function relation(Request $request)
    {
        // 获取登录的用户信息
        $member = auth('member')->user();
        // 判断是否为查询下级获取查询下级
        if (!in_array($request->relation, ['upper', 'lower'])) {
            return $this->error('错误参数');
        }
        // 判断是否为获取上级
        if ($request->relation == 'upper') {
            // 获取所有上级用户
            $query = $member->getAncestor();
            // 判断是否为直接关系
            if ($request->direct == 1) {
                // 获取直接上级
                $query = $query->where('member.id', $member['parent']);
            }
        } else {
            // 获取所有下级用户
            $query = $member->getDescendants();
            // 判断是否为直接关系
            if ($request->direct == 1) {
                // 获取所有直接关系的下级
                $query = $query->where('member.parent', $member['id']);
            }
        }
        return $query->get()->toArray();
    }

    /**
     * 用户登录
     */
    public function login(Request $request)
    {
        $input = $request->only('username', 'password');
        $token = auth('member')->attempt($input);
        if ($token) {
            return $this->success('success', ['token' => $token]);
        } else {
            return $this->error('用户密码错误');
        }
    }

    /**
     * 注册新的用户
     */
    public function reg(Request $request)
    {
        // 接送post数据并去除空数组
        $post = $this->filterNull($request->post());
        // 调用验证器验证数据是否正确
        $ver = $this->validatorData($post, new MemberVal());
        // 如果验证器返回结果不等于1
        if ($ver != 1) {
            // 输出验证错误信息
            return $this->error($ver);
        }
        // 判断用户上级是否不等于0
        if ($post['parent'] != '0') {
            // 获取上级信息
            $parent = MemberModel::find($post['parent']);
            // 如果上级不存在
            if (!$parent) {
                return $this->error('上级不存在');
            }
        }
        // 生成用户唯一uid
        $post['uid'] = $this->uid();
        // 登录密码进行加密
        $post['password'] = bcrypt($post['password']);
        // 创建新的用户
        MemberModel::create($post);
        return $this->success('注册成功');
    }
}
