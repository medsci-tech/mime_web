<?php namespace Modules\Airclass\Http\Controllers;

use App\Models\Doctor;
use App\Models\Hospital;
use Hash;
use Illuminate\Http\Request;
use DB;
use Modules\AirClass\Entities\Student;
use Session;
use Validator;

class UserPublicController extends Controller
{

    protected $phone_rules = 'required|regex:/^1[35789]\d{9}$/';
    protected $password_rules = 'required|min:6|max:22|regex:/^[\w\.-]{6,22}$/';
    protected $validator_msg = [
        'phone.required' => '手机号不能为空',
        'phone.regex' => '手机号格式错误',
        'password.required' => '密码不能为空',
        'password.regex' => '密码格式只支持6-22位字母数字下划线及-+_.组合',
    ];

    public function validator_params(){

    }

    /**
     * @return mixed
     */
    public function register_view()
    {
        $save_data = [
            'phone' => '13554498149',
            'password' => '123456',
            'province' => '湖北省',
            'city' => '武汉市',
            'area' => '洪山区',
            'hospital_level' => '一级',
            'hospital_name' => '同济医院',
            'office' => '脑神经科',
            'title' => '主任',
        ];
        return csrf_token();

    }

    public function register_post(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'phone' => $this->phone_rules,
                'password' => $this->password_rules,
            ],
            $this->validator_msg
        );
        $validator_error_first = $validator->errors()->first();
        if($validator_error_first){
            return $this->return_data_format(422, $validator_error_first);
        }

        $req_phone = $request->input('phone'); //手机号
        $req_code = $request->input('code'); //手机验证码
        $req_pwd = $request->input('password'); //密码
        $req_province = $request->input('province'); //省
        $req_city = $request->input('city'); //市
        $req_area = $request->input('area'); //区
        $req_hospital_level = $request->input('hospital_level'); //医院等级
        $req_hospital_name = $request->input('hospital_name'); //医院名称
        $req_office = $request->input('office'); //科室
        $req_title = $request->input('title'); //职称

        // 检测手机验证码有效性
        $sms = new SmsController();
        $check_code = $sms->verify_code($req_phone, $req_code);
        if($check_code['code'] != 200){
            return $this->return_data_format($check_code['code'], $check_code['msg']);
        }
        // 检验手机号是否注册
        $doctor = Doctor::where('phone', $req_phone)->first();
        if($doctor){
            return $this->return_data_format(422, '手机号已注册');
        }
        // 检查医院信息，如果不存在则添加医院信息
        $hospital_where = [
            'hospital' => $req_hospital_name,
            'province' => $req_province,
            'city' => $req_city,
            'country' => $req_area,
        ];
        $hospital = Hospital::where($hospital_where)->first();
        if($hospital){
            $hospital_id = $hospital->id;
        }else{
            $add_hospital_data = [
                'hospital' => $req_hospital_name,
                'province' => $req_province,
                'city' => $req_city,
                'country' => $req_area,
                'hospital_level' => $req_hospital_level,
            ];
            $add_hospital = new HospitalController();
            $hospital = $add_hospital->addHospital($add_hospital_data);
            if($hospital['code'] == 200){
                $hospital_id = $hospital['data']['id'];
            }else{
                return $this->return_data_format(404, $hospital['msg']);
            }
        }
        DB::beginTransaction();
        /* 保存医生信息 */
        $add_doctor_data = [
            'phone' => $req_phone,
            'password' => Hash::make($req_pwd),
            'hospital_id' => $hospital_id,
            'office' => $req_office,
            'title' => $req_title,
        ];
        $add_doctor = Doctor::create($add_doctor_data);
        if($add_doctor){
            /* 同步注册用户中心 */
            $api_to_uc_data = [
                'phone' => $req_phone,
                'password' => $req_pwd,
                'office' => $req_office,
                'title' => $req_title,
                'province' => $req_province,
                'city' => $req_city,
                'hospital_name' => $req_hospital_name,
            ];
            $api_to_uc = new ApiToUserCenterController();
            $api_to_uc_res = $api_to_uc->register($api_to_uc_data);
            if($api_to_uc_res['code'] == 200){
                DB::commit();
                return $this->return_data_format(200, '注册成功');
            }else{
                DB::rollback();//事务回滚
                return $this->return_data_format(500, $api_to_uc_res['msg']);
            }
        }else{
            return $this->return_data_format(404, '注册失败');
        }
    }


    /**
     * @return mixed
     */
    public function login_view()
    {
        return 'login';

    }

    // 账号密码登陆
    public function login_account_post(Request $request)
    {
        $account = $request->input('account');
        $password = $request->input('password');
        $user = Doctor::where('phone', $account)->first();
        if (Hash::check($password, $user['password'])) {
            Session::set($this->student_login_session_key, [
                'id' => $user->id,
                'nickname' => $user->nickname, // 昵称
                'headimgurl' => $user->headimgurl, // 头像
                'phone' => $user->phone,
                'province' => $user->hospital->province,
                'city' => $user->hospital->city,
                'area' => $user->hospital->country,
                'hospital_name' => $user->hospital, // 医院名称
                'office' => $user->office, // 科室
                'title' => $user->title, // 职称
            ]);
            return $this->return_data_format(200);
        } else {
            return $this->return_data_format(501, '用户名或密码错误');
        }
    }

    // 手机验证码登陆
    public function login_phone_post(Request $request){
        $account = $request->input('account');
        $code = $request->input('code');
        $sms = new SmsController();
        $check_code = $sms->verify_code($account, $code);
        if($check_code['code'] != 200){
            return $this->return_data_format($check_code['code'], $check_code['msg']);
        }
        $user = Doctor::where('phone', $account)->first();
        if ($user) {
            Session::set($this->student_login_session_key, [
                'id' => $user->id,
                'nickname' => $user->nickname, // 昵称
                'headimgurl' => $user->headimgurl, // 头像
                'phone' => $user->phone,
                'province' => $user->hospital->province,
                'city' => $user->hospital->city,
                'area' => $user->hospital->country,
                'hospital_name' => $user->hospital, // 医院名称
                'office' => $user->office, // 科室
                'title' => $user->title, // 职称
            ]);
            return $this->return_data_format(200);
        } else {
            return $this->return_data_format(501, '手机号未注册');
        }
    }

    // 微信登陆 todo

    /**
     * @return mixed
     */
    public function pwd_recover_view()
    {
        return view('airclass::userPublic.pwd_recover');
    }

    /**
     * 找回密码--post
     * @param Request $request
     * @return array
     */
    public function pwd_recover_post(Request $request)
    {
        $phone = $request->input('phone'); // 手机号
        $verify_code = $request->input('verify_code'); // 短信验证码
        $password = $request->input('password'); // 密码
        $re_password = $request->input('re_password'); // 重复密码
        // 校验短信验证码
        $sms = new SmsController();
        $check_code = $sms->verify_code($phone, $verify_code);
        if($check_code['code'] != 200) {
            return $this->return_data_format($check_code['code'], $check_code['msg']);
        }
        // 验证两次密码输入是否一致
        if($password == $re_password){
            $user = Student::where('phone', $phone)->update('password', Hash::make($password));
            if($user){
                return $this->return_data_format(200, '两次密码输入不一致');
            }else{
                return $this->return_data_format(500, '两次密码输入不一致');
            }
        }else{
            return $this->return_data_format(422, '两次密码输入不一致');
        }

    }


    public function send_code_post(Request $request)
    {
        $phone = $request->input('phone');
        $sms = new SmsController();
        $res = $sms->send_sms($phone);
        if($res){
            return $this->return_data_format(200, '两次密码输入不一致');
        }else{
            return $this->return_data_format(500, '两次密码输入不一致');
        }
    }




}

