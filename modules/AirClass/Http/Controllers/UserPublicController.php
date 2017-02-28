<?php namespace Modules\Airclass\Http\Controllers;

use Illuminate\Http\Request;

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
		dd('login');
	}
	public function login_post(Request $request)
	{
		dd('login');
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

