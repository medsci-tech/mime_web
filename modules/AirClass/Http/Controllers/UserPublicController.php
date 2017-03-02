<?php namespace Modules\Airclass\Http\Controllers;

use Hash;
use Illuminate\Http\Request;
use Modules\AirClass\Entities\Student;
use Session;

class UserPublicController extends Controller
{

    /**
     * @return mixed
     */
	public function register_view()
	{
		dd('register');
	}

	public function register_post(Request $request)
	{
		dd('register');
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
		if(Hash::check($password, $user['password'])){
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
		}else{
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

	public function pwd_recover_post(Request $request)
	{
		dd('密码找回');
	}


	public function send_code_post(Request $request)
	{
		dd('发送验证码接口');
	}

	public function verify_code_post(Request $request)
	{
		dd('检验验证码');
	}

	
}

