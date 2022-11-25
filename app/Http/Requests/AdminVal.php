<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminVal extends FormRequest
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
        if ($id == 0) {
            return [
                'username' => 'required|unique:admin',
                'password' => 'required',
            ];
        } else {
            return [
                'username' => 'required|unique:admin,username,' . $id
            ];
        }
    }

    public function messages()
    {
        return [
            'username.required' => '管理员名称不能为空',
            'password.required' => '管理员密码不能为空',
            'username.unique' => '管理员名称不能重复',
        ];
    }
}
