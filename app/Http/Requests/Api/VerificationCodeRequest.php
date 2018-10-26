<?php

namespace App\Http\Requests\Api;

use Dingo\Api\Http\FormRequest;

// API 表单请求验证类
class VerificationCodeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * 确定用户是否有权提出此请求。
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * 获取适用于请求的验证规则
     * @return array
     */
    public function rules()
    {
        return [
            'captcha_key' => 'required|string',
            'captcha_code' => 'required|string',
        ];
    }

    public function attributes()
    {
        return [
            'captcha_key' => '图片验证码 key',
            'captcha_code' => '图片验证码',
        ];
    }
}
