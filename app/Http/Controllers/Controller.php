<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * 默认获取10条数据
     */
    public function limit($request)
    {
        // 判断数量是否为空
        if ($request->limit) {
            // 数量不为空，获取没页显示的数量
            $limit = $request->limit;
        } else {
            // 默认为10条数据
            $limit = 10;
        }
        return $limit;
    }

    /**
     * 解决去空数组会去调0
     */
    public function filterData($arr)
    {
        if ($arr === '' || $arr === null) {
            return false;
        }
        return true;
    }

    /**
     * 去除非必要字段
     * $data    原数组数据
     * $arr     需要移除的字段
     */
    public function moveField($data, $arr = ['id'])
    {
        // 默认移除的字段
        $default = ['created_at', 'updated_at', 'deleted_at'];
        // 循环默认移除字段
        foreach ($default as $v) {
            if (isset($data[$v])) {
                // 移除对应的数组值
                unset($data[$v]);
            }
        }
        // 循环移除的数组值
        foreach ($arr as $v) {
            // 判断传入的数据是否存在传入数组的值
            if (isset($data[$v])) {
                // 移除对应的数组值
                unset($data[$v]);
            }
        }
        return $data;
    }

    /**
     * 数组去空
     */
    public function filterNull($arr, $null = 1)
    {
        if ($null == 1) {
            return array_filter($arr, array($this, 'filterData'));
        } else {
            return array_filter($arr);
        }
    }

    /**
     * 验证器验证规则
     * $data    验证的数据
     * $val     验证器
     */
    public function validatorData($data, $val)
    {
        // 查询id是否存在，用于判断是否是更新数据
        if (isset($data['id'])) {
            $validator = Validator::make($data, $val->rules($data['id']), $val->messages());
        } else {
            $validator = Validator::make($data, $val->rules(), $val->messages());
        }
        if ($validator->fails()) {
            $error = $validator->errors()->messages();
            foreach ($error as $value) {
                return $value[0];
            }
        } else {
            return 1;
        }
    }

    /**
     *返回错误信息
     * $msg     返回的错误信息
     * $data    返回数据
     * $code    返回code码
     */
    public function error($msg, $data = [], $code = 0)
    {
        $res['code'] = $code;
        $res['msg'] = $msg;
        if (!empty($data)) {
            $res['data'] = $data;
        }
        return response()->json($res);
    }

    /**
     * 返回正确信息
     * $msg     返回的信息
     * $data    返回的数据
     * $total   数据总条数
     * $code    返回code码
     */
    public function success($msg, $data = [], $total = 0, $code = 200)
    {
        $res['code'] = $code;
        $res['msg'] = $msg;
        if (!empty($data)) {
            $res['data'] = $data;
        }
        if ($total != 0) {
            $res['total'] = $total;
        }
        return response()->json($res);
    }

    /**
     * 生成用户uid
     */
    public function uid()
    {
        while (true) {
            // 生成随机的uid(6位)
            $uid = mt_rand(111111, 999999);
            // 检测uid是否存在
            $check = Member::where('uid', $uid)->count();
            // uid不存在
            if ($check == 0) {
                // 输出生成的uid
                return $uid;
                // 退出死循环
                break;
            }
        }
    }

    /**
     * 图片转换完整路径
     * $images      传入数据库保存的图片地址
     * $type        0是单图(返回字符串)，1是多图(返回数组)
     * $default     1如果没有返回一张默认图片
     */
    public function img($images, $type = 0, $default = 0)
    {
        // 获取服务器域名
        $domain = $_SERVER['APP_URL'];
        // 把字符串转为数组
        $arr = $this->strArray(',', $images);
        // 判断是否为空
        if (empty($arr)) {
            if ($default == 1) {
                $res = 'default';
            } else {
                $res = '';
            }
            return $res;
        }
        // 判断是否是单图
        if ($type == 0) {
            // 判断是否存在http
            if (strstr($arr[0], "http")) {
                // 如果存在http直接返回图片
                $res = $arr[0];
            } else {
                // 域名加图片路径
                $res = $domain . $arr[0];
            }
        } else {
            // 设置一个空数组
            $res = [];
            foreach ($arr as $value) {
                if (strstr($value, "http")) {
                    $res[] = $value;
                } else {
                    $res[] = $domain . $value;
                }
            }
        }
        return $res;
    }

    /**
     * 文字转数组
     * $str     转换的字符串(分割)
     * $data    转换的数据
     */
    public function strArray($str, $data)
    {
        // 判断是否有转换的字符串(分割)
        if (strstr($data, $str)) {
            $res = explode($str, $data);
        } else {
            $res = [$data];
        }
        return $res;
    }

    /**
     * 完整路径图片转换
     * $images 传入数据库保存的图片地址
     * $type 0是单图，1是多图
     */
    public function imgClear($images, $type = 0)
    {
        $domain = $_SERVER['APP_URL'];
        if ($type == 0) {
            return str_replace($domain, '', $images);
        } else {
            $res = [];
            if (strpos($images, ',')) {
                $arr = explode(",", $images);
                foreach ($arr as $value) {
                    $res[] = str_replace($domain, '', $value);
                }
            } else {
                $res[] = str_replace($domain, '', $images);
            }
            return implode(",", $res);
        }
    }

    /**
     * 编辑器图片和视频添加url
     * $str     字符串
     */
    public function editorUrl($str)
    {
        // 替换图片
        $images = str_ireplace('/images/', $_SERVER['APP_URL'] . '/images/', $str);
        // 替换视频并返回
        return str_ireplace('/video/', $_SERVER['APP_URL'] . '/video/', $images);
    }

    /**
     * 编辑器图片和视频去除url
     * $str     字符串
     */
    public function editorClearUrl($str)
    {
        // 替换图片
        $images = str_ireplace($_SERVER['APP_URL'] . '/images/', '/images/', $str);
        // 替换视频并返回
        return str_ireplace($_SERVER['APP_URL'] . '/video/', '/video/', $images);
    }

    /**
     * 百分比转换
     * $str     传入字符串
     * $type    0输出为0.xx，1输出为待转%的字符串
     */
    public function percentageStr($str, $type = 0)
    {
        if ($type == 0) {
            if (strstr($str, '%')) {
                $res = str_replace('%', '', $str) / 100;
            } else {
                $res = (int)$str / 100;
            }
        } else {
            if (!strstr($str, '%')) {
                $res = $str . '%';
            } else {
                $res = $str;
            }
        }
        return $res;
    }


    /**
     * 生成树
     * $list    数据
     * $name    上级的字段
     * $pid     上级ID，默认0
     */
    public function tree($list, $name, $pid = 0)
    {
        $tree = [];
        if (!empty($list)) {
            $newList = [];
            foreach ($list as $k => $v) {
                $newList[$v['id']] = $v;
            }
            foreach ($newList as $value) {
                if ($pid == $value[$name]) {
                    $tree[] = &$newList[$value['id']];
                } elseif (isset($newList[$value[$name]])) {
                    $newList[$value[$name]]['children'][] = &$newList[$value['id']];
                }
            }
        }
        return $tree;
    }
}
