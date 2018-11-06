<?php

namespace App\Http\Requests\Api;

use Dingo\Api\Http\FormRequest;

// 登录表单认证类
class AuthorizationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'username' => 'required|string',
            'password' => 'required|string|min:6',
        ];
    }
}
