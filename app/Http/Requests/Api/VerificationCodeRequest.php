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
            'phone' => [
                'required',
                'regex:/^((13[0-9])|(14[5,7])|(15[0-3,5-9])|(17[0,3,5-8])|(18[0-9])|166|198|199|(147))\d{8}$/',
                'unique:users'

            ],
        ];
    }
}
