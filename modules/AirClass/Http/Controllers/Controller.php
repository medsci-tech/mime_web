<?php namespace Modules\Airclass\Http\Controllers;

use Pingpong\Modules\Routing\Controller as BaseController;

class Controller extends BaseController
{
    protected $user_login_session_key = 'user_login_session_key'; // 用户登录session key
    protected $site_id = 1; // airClass site_id
    protected $public_class_id = 4; // 公开课id
    protected $answer_class_id = 2; // 答疑课id
    protected $private_class_id = 3; // 空课项目私教课id

    public function return_data_format($code = 200, $msg = null, $data = null)
    {
        return ['code' => $code, 'msg' => $msg, 'data' => $data];
    }

    /**
     * 验证参数合法性
     * @param array $data
     * @return array
     */
    protected function validator_params(array $data){
        $rules = [];
        if(array_key_exists('phone', $data)){
            $rules['phone'] = 'required|regex:/^1[35789]\d{9}$/';
        }
        if(array_key_exists('password', $data)){
            $rules['password'] = 'required|min:6|max:22|regex:/^[\w\.-]{6,22}$/';
        }
        $msg = [
            'phone.required' => '手机号不能为空',
            'phone.regex' => '手机号格式错误',
            'password.required' => '密码不能为空',
            'password.regex' => '密码格式只支持6-22位字母数字下划线及-+_.组合',
        ];
        $validator = Validator::make($data, $rules, $msg);
        $validator_error_first = $validator->errors()->first();
        if($validator_error_first){
            return $this->return_data_format(422, $validator_error_first);
        }else{
            return $this->return_data_format(200);
        }
    }

	
}

