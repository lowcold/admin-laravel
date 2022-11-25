<?php

namespace App\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\MemberVal;
use App\Models\Member as MemberModel;
use Illuminate\Http\Request;

class Member extends Controller
{
    /**
     * 列表
     */
    public function index(Request $request)
    {
        $data = MemberModel::orderBy('id', 'desc')->paginate($this->limit($request))->toArray();
        return $this->success('success', $data['data'], $data['total']);
    }

    /**
     * 编辑/添加
     */
    public function set(Request $request)
    {
        // 去除空数组
        $post = $this->filterNull($request->post());
        // 使用验证器
        $ver = $this->validatorData($post, new MemberVal());
        if ($ver != 1) {
            return $this->error($ver);
        }
        // 判断是否为更新数据
        if ($request->id) {
            try {
                // 获取更新的用户信息
                $member = MemberModel::find($request->id);
                // 判断上级是否有更新
                if ($request->parent != $member['parent']) {
                    // 判断上级是不是自己
                    if ($request->parent == $member['id']) {
                        return $this->error('上级不能是自己');
                    }
                    if ($request->parent != '0') {
                        // 查询更新的上级是否存在
                        $parent = MemberModel::where('id', $request->parent)->orWhere('uid', $request->parent)->first();
                        if (!$parent) {
                            return $this->error('上级不存在');
                        }
                        // 移动用户(修改上级)
                        $member->move($parent);
                    } else {
                        // 把用户设置为顶级
                        $member->setRoot();
                    }
                }
                // 移除非必要字段
                $post = $this->moveField($post);
                MemberModel::find($request->id)->update($post);
                $res = $this->success('更新成功');
            } catch (\Exception $exception) {
                $res = $this->error('抛出异常', $exception->getMessage());
            }
        } else {
            try {
                // 判断有设置上级用户
                if ($request->parent and $request->parent != '0') {
                    // 查询上级是否存在
                    $parent = MemberModel::where('id', $request->parent)->orWhere('uid', $request->parent)->first();
                    if (!$parent) {
                        return $this->error('上级不存在');
                    }
                }
                // 添加一个用户
                MemberModel::create($post);
                $res = $this->success('添加成功');
            } catch (\Exception $exception) {
                $res = $this->error('抛出异常', $exception->getMessage());
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
            MemberModel::find($request->id)->delete();
            $res = $this->success('删除成功');
        } catch (\Exception $exception) {
            $res = $this->error($exception->getMessage());
        }
        return $res;
    }
}
