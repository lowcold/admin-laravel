<?php

namespace App\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MemberGrade as MemberGradeModel;
use Illuminate\Http\Request;

class MemberGrade extends Controller
{
    /**
     * 列表
     */
    public function index(Request $request)
    {
        $data = MemberGradeModel::orderBy('id', 'desc')->paginate($this->limit($request))->toArray();
        return $this->success('success', $data['data'], $data['total']);
    }

    /**
     * 编辑/添加
     */
    public function set(Request $request)
    {
        $post = $this->filterNull($request->post());
        // 判断是否为更新数据
        if ($request->id) {
            try {
                // 移除非必要字段
                $post = $this->moveField($post);
                MemberGradeModel::find($request->id)->update($post);
                $res = $this->success('更新成功');
            } catch (\Exception $exception) {
                $res = $this->error('抛出异常', $exception->getMessage());
            }
        } else {
            try {
                MemberGradeModel::create($post);
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
            MemberGradeModel::find($request->id)->delete();
            $res = $this->success('删除成功');
        } catch (\Exception $exception) {
            $res = $this->error($exception->getMessage());
        }
        return $res;
    }
}
