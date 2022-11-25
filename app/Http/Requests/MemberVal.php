<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MemberVal extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules($id = 0)
    {
        // 唯一值需要忽略本身
        if ($id == 0) {
            return [
                'parent' => 'required',
                'password' => 'required',
                'username' => 'required|unique:member',
            ];
        } else {
            return [
                'username' => 'required|unique:member,username,' . $id,
            ];
        }
    }

    public function messages()
    {
        return [
            'parent.required' => '上级ID不能为空',
            'username.required' => '用户名称不能为空',
            'password.required' => '登录密码不能为空',
            'username.unique' => '用户名称不能重复',
        ];
    }
}
