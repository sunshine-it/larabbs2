<?php

namespace App\Http\Requests\Api;

// 登录表单认证类
class AuthorizationRequest extends FormRequest
{
    public function rules()
    {
        return [
            'username' => 'required|string',
            'password' => 'required|string|min:6',
        ];
    }
}
