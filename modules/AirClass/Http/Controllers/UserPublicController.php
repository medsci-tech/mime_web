<?php namespace Modules\Airclass\Http\Controllers;

use App\Models\Doctor;
use App\Models\Hospital;
use Curl\Curl;
use Hash;
use Illuminate\Http\Request;
use DB;
use Mockery\CountValidator\Exception;
use Modules\AirClass\Entities\Student;
use Session;

class UserPublicController extends Controller
{

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


    }

    public function register_post(Request $request)
    {
        $req_phone = $request->input('phone'); //手机号
        $req_pwd = $request->input('password'); //密码
        $req_province = $request->input('province'); //省
        $req_city = $request->input('city'); //市
        $req_area = $request->input('area'); //区
        $req_hospital_level = $request->input('hospital_level'); //医院等级
        $req_hospital_name = $request->input('hospital_name'); //医院名称
        $req_office = $request->input('office'); //科室
        $req_title = $request->input('title'); //职称

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
            return $this->return_data_format(404, '添加医生信息失败');
        }
    }


    /**
     * @return mixed
     */
    public function login_view()
    {
        return 'login';

    }

    public function login_post(Request $request)
    {
        $password = $request->input('password');
        $username = $request->input('username');
        $user = Doctor::where('phone', $username)->first();
        if (Hash::check($password, $user['password'])) {
            Session::set($this->student_login_session_key, [
                'id' => $user->id,
                'nickname' => $user->nickname, // 昵称
                'headimgurl' => $user->headimgurl, // 头像
                'phone' => $user->phone,
                'province' => $user->province,
                'city' => $user->city,
                'area' => $user->area,
                'hospital_name' => $user->hospital_name, // 医院名称
                'office' => $user->office, // 科室
                'title' => $user->title, // 职称
            ]);
            return $this->return_data_format(200);
        } else {
            return $this->return_data_format(501, '用户名或密码错误');
        }
    }

    /**
     * @return mixed
     */
    public function pwd_recover_view()
    {
        dd('密码找回');
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
        $check_code = $this->verify_code_post($phone, $verify_code); // 校验短信验证码
        if($check_code['code'] == 200){
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
        }else{
            return $this->return_data_format(422, $check_code['msg']);
        }
    }


    public function send_code_post(Request $request)
    {

        dd('发送验证码接口');
    }




}

