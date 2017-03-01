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
			Session::set('login_student_session',$user->id);
			return $this->return_data_format(200);
		}else{
			return $this->return_data_format(501, '用户名或密码错误');
		}
	}

	public function logout(Request $request)
	{
		Session::forget('login_student_session');
		redirect('/login');
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

