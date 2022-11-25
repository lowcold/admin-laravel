<?php

namespace App\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AdminGroup as AdminGroupModel;
use Illuminate\Http\Request;

class AdminGroup extends Controller
{
    /**
     * 所有的列表
     */
    public function index(Request $request)
    {
        $data = AdminGroupModel::orderBy('id', 'desc')->paginate($this->limit($request))->toArray();
        return $this->success('success', $data['data'], $data['total'], 0);
    }

    /**
     * 新建/更新
     */
    public function set(Request $request)
    {
        $data['rule'] = -1;
        if ($request->tree) {
            $data['rule'] = $this->str($request->tree);
        }
        $data['title'] = $request->title;
        if ($request->id) {
            unset($data['id'], $data['create_at'], $data['update_at']);
            try {
                AdminGroupModel::find($request->id)->update($data);
                $res = $this->success('更新成功');
            } catch (\Exception $exception) {
                $res = $this->error($exception->getMessage());
            }
        } else {
            try {
                AdminGroupModel::create($data);
                $res = $this->success('添加成功');
            } catch (\Exception $exception) {
                $res = $this->error($exception->getMessage());
            }
        }
        return $res;
    }

    public function str($data)
    {
        $str = "";
        foreach ($data as &$val) {
            $str .= $val . ',';
        }
        if (strstr($str, ',')) {
            $str = rtrim($str, ",");
        }
        return $str;
    }

    /**
     * 删除
     */
    public function destroy(Request $request)
    {
        try {
            AdminGroupModel::find($request->id)->delete();
            $res = $this->success('删除成功');
        } catch (\Exception $exception) {
            $res = $this->error($exception->getMessage());
        }
        return $res;
    }
}
