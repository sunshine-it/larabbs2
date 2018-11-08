<?php

namespace App\Http\Requests\Api;

use Dingo\Api\Http\FormRequest as BaseFormRequest;

class FormRequest extends BaseFormRequest
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
}
