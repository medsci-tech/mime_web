<?php namespace Modules\AirClass\Http\Controllers;

use App\Http\Requests\Interfaces\DoctorBean;
use Pingpong\Modules\Routing\Controller as BaseController;
use Validator;
use App\Http\Requests\Interfaces\DoctorRank;
class Controller extends BaseController
{
    use DoctorRank;
    protected $user;
    protected $user_login_session_key = 'user_login_session_key'; // 用户登录session key
    protected $site_id = 2; // airClass site_id
    protected $public_class_id = 4; // 公开课id
    protected $answer_class_id = 2; // 答疑课id
    protected $private_class_id = 3; // 空课项目私教课id

    public function __construct()
    {
        $this->user = \Session::get($this->user_login_session_key);
        $rank = $this->setRank(['id'=>$this->user['id'],'phone'=>$this->user['phone']])->rank;
        if($this->user['rank']!=$rank)
        {
            $this->user['rank'] = $rank;
            \Session::set($this->user_login_session_key, $this->user);
        }
    }

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
            $rules['password'] = 'required|regex:/^[\w\.-]{6,22}$/';
        }
        $msg = [
            'phone.required' => '手机号不能为空',
            'phone.regex' => '手机号格式错误',
            'password.required' => '密码不能为空',
            'password.regex' => '密码格式只支持6-22位字母数字下划线及-+_.组合',
        ];
        $validator = Validator::make($data, $rules, $msg);
        $validator_error_first = $validator->errors()->messages();
//        dd($validator_error_first);
        if($validator_error_first){
            return $this->return_data_format(444, $validator_error_first);
        }else{
            return $this->return_data_format(200);
        }
    }

	
}

