<?php

namespace App\Http\Requests\Api;

use Dingo\Api\Http\FormRequest;

// API 第三方登录表单请求验证类
class SocialAuthorizationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'code' => 'required_without:access_token|string',
            'access_token' => 'required_without:code|string',
        ];
        if ($this->social_type == 'weixin' && !$this->code) {
            $rules['openid'] = 'required|string';
        }
        return $rules;
    }
}
