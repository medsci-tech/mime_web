<?php namespace Modules\Airclass\Http\Controllers;

use Auth;
use Hash;
use Session;
use Illuminate\Http\Request;
use Modules\AirClass\Entities\Student;

class UserPublicController extends Controller
{

    /**
     * @return mixed
     */
	public function register_view()
	{
		dd(Session::get('login_student'));
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
		$password = '123456';
		$username = '13554498149';
		$user = Student::where('phone', $username)->first();
		if(Hash::check($password, $user['password'])){
			Session::set('login_student',$user->id);
		}else{
			dd(Hash::make($password));
		}
//		var_dump(session());
//		dd(Session::get('login_student'));
		dd(Session::all());
	}

	public function login_post(Request $request)
	{

		$password = $request->input('password');
		$username = $request->input('username');
		$user = Student::where('phone', $username)->first();
		if(Hash::check($password, $user['password'])){
			Auth::login($user);
			dd(Auth::user()); // 获取登录用户
		}else{
			dd(Hash::make($password));
		}
		dd('login');
	}

	public function logout(Request $request)
	{
		Auth::logout();
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

