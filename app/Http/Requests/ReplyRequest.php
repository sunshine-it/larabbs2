<?php

namespace App\Http\Requests;

// 表单验证类
class ReplyRequest extends Request
{
    public function rules()
    {
       return [
            'content' => 'required|min:2',
       ];
    }

    public function messages()
    {
        return [
            // Validation messages
        ];
    }
}
