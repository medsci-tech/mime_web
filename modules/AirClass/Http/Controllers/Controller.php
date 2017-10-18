<?php namespace Modules\AirClass\Http\Controllers;

use App\Http\Requests\Interfaces\DoctorBean;
use App\Models\Doctor;
use Illuminate\Support\Facades\Redis;
use Pingpong\Modules\Routing\Controller as BaseController;
use Validator;
use App\Http\Requests\Interfaces\DoctorRank;
class Controller extends BaseController
{
    use DoctorRank;
    protected $user;
    protected $user_login_session_key = 'user_login_session_key'; // 用户登录session key
    protected $user_login_code = 'user_login_code'; // 用户登录session key
    protected $site_id = 2; // airClass site_id
    protected $public_class_id = 4; // 公开课id
    protected $answer_class_id = 2; // 答疑课id
    protected $private_class_id = 3; // 空课项目私教课id

    public function __construct()
    {
        $user_cookie = \Cookie::get($this->user_login_code);
        $this->user = \Session::get($this->user_login_session_key);
        if(!$this->user && $user_cookie){
            $user = Doctor::where('phone', $user_cookie)->first();
            if($user){
                $this->save_session($user);
            }
        }
        $rank = $this->setRank(['id'=>$this->user['id'],'phone'=>$this->user['phone']])->rank;
        if($this->user['rank']!=$rank)
        {
            $this->user['rank'] = $rank;
            \Session::set($this->user_login_session_key, $this->user);
        }
    }

    public function return_data_format($code = 200, $msg = null, $data = null,$url=null)
    {
        return ['code' => $code, 'msg' => $msg, 'data' => $data,'url'=>$url];
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

    /**
     * 账号登陆和短信登陆公共方法
     * @param $user
     * @return array
     */
    public function save_session($user){
        $save_data = [
            'id' => $user->id,
            'name' => $user->name, // 昵称
            'email' => $user->email, // 邮箱
            'nickname' => $user->nickname, // 昵称
            'headimgurl' => $user->headimgurl, // 头像
            'phone' => $user->phone,
            'office' => $user->office, // 科室
            'title' => $user->title, // 职称
            'rank' => $user->rank, // 等级
            'credit' => $user->credit, // 积分
        ];
        if($user->hospital){
            $save_data['province'] = $user->hospital->province;
            $save_data['city'] = $user->hospital->city;
            $save_data['area'] = $user->hospital->country;
            $save_data['hospital_name'] = $user->hospital->hospital;
            $save_data['hospital_level'] = $user->hospital->hospital_level;
        }else{
            $save_data['province'] = '';
            $save_data['city'] = '';
            $save_data['area'] = '';
            $save_data['hospital_name'] = '';
            $save_data['hospital_level'] = '';
        }
        \Session::set($this->user_login_session_key, $save_data);
        //记录用户登入显示活动图片
        $key = 'user:'.$user->id.':activity';
        $timestamp = strtotime('2017-11-01');
        if(time()<$timestamp){//活动未结束
            if(!Redis::exists($key)){
                Redis::set($key,1);
            }else{
                Redis::incr($key);
            }
        }
        return $save_data;
    }

	
}

