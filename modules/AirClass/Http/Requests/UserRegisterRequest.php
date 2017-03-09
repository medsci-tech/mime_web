<?php
namespace Modules\Airclass\Http\Requests;

use App\Http\Requests\Request;

class UserRegisterRequest extends Request
{
    
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'phone' => 'required|unique:doctors',
        ];
    }

    public function messages()
    {
        return [
            'phone' => [
                'required' => '手机号不能为空',
                'unique'  => '手机号已注册',
            ],
        ];
    }
}
