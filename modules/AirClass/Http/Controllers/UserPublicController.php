<?php namespace Modules\Airclass\Http\Controllers;

use Curl\Curl;
use Hash;
use Illuminate\Http\Request;
use Mockery\CountValidator\Exception;
use Modules\AirClass\Entities\Student;
use Session;

class UserPublicController extends Controller
{

    /**
     * @return mixed
     */
    public function register_view(Request $request)
    {
//        $url = 'http://volunteers.mime.org.cn/api/register';
        $url = 'http://airclass.mimeweb.dev/register/post';
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
        try{
            $curl = new Curl();
            $curl->post($url, array(
                'username' => 'myusername',
                'password' => 'mypassword',
            ));
            if ($curl->error) {
                echo $curl->error_code;
            }
            else {
                echo $curl->response;
            }
        }catch (Exception $e){
            return 'youwenti';
        }
    }

    public function register_post(Request $request)
    {
        // 调用户中心接口
//        $save_data = [
//            'phone' => '13554498149',
//            'password' => '123456',
//            'province' => '湖北省',
//            'city' => '武汉市',
//            'area' => '洪山区',
//            'hospital_level' => '一级',
//            'hospital_name' => '同济医院',
//            'office' => '脑神经科',
//            'title' => '主任',
//        ];

        return 'login';
//        $save_data = $request->all();
//        $save_data['password'] = Hash::make($save_data['password']);
//        $result = Student::create($save_data);
//        if($result){
//            return $this->return_data_format(200);
//        } else {
//            return $this->return_data_format(501, '用户名或密码错误');
//        }
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
        $user = Student::where('phone', $username)->first();
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

