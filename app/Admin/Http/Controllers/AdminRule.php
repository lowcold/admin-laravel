<?php

namespace App\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AdminRule as AdminRuleModel;
use Illuminate\Http\Request;

class AdminRule extends Controller
{
    /**
     * 获取分组路由规则列表
     */
    public function index(Request $request)
    {
        $data = AdminRuleModel::orderBy('sort', 'asc')->where('show', 1)->get()->toArray();
        foreach ($data as &$val) {
            $val['label'] = $val['name'];
            $val['value'] = $val['id'];
        }
        return $this->success('success', $this->tree($data, 'pid'), count($data));
    }

    /**
     * 编辑分组路由规则
     */
    public function set(Request $request)
    {
        $post = $this->filterNull($request->post());
        // 判断是否传入了pid
        if ($request->pid) {
            // 判断传入的pid是否为数组
            if (is_array($request->pid)) {
                // 获取最后一个pid作为上级id
                $post['pid'] = end($request->pid);
            } else {
                $post['pid'] = $request->pid;
            }
        } else {
            // 如果没有传入pid，那把pid设置为0
            $post['pid'] = 0;
        }
        // 移除非必要字段
        $post = $this->moveField($post, ['id', 'label', 'value', 'children']);
        // 判断是否为更新数据
        if ($request->id) {
            AdminRuleModel::find($request->id)->update($post);
            $res = $this->success('更新成功');
        } else {
            // 创建一个新的权限规则
            AdminRuleModel::create($post);
            $res = $this->success('添加成功');
        }
        return $res;
    }

    /**
     * 修改排序
     */
    public function sort(Request $request)
    {
        $update = ['sort' => $request->sort];
        try {
            AdminRuleModel::find($request->id)->update($update);
            $res = $this->success('设置排序成功');
        } catch (\Exception $exception) {
            $res = $this->error($exception->getMessage());
        }
        return $res;
    }

    /**
     * 删除
     */
    public function destroy(Request $request)
    {
        try {
            AdminRuleModel::find($request->id)->delete();
            $res = $this->success('删除成功');
        } catch (\Exception $exception) {
            $res = $this->error($exception->getMessage());
        }
        return $res;
    }
}
