<?php namespace Modules\Airclass\Http\Controllers;

use Illuminate\Http\Request;
use Modules\AirClass\Entities\Student;
use Session;

class UserController extends Controller
{
	protected $user = null;
	public function __construct()
	{
		$user = Session::get($this->student_login_session_key);
		if($user){
			$this->user = $user;
		}else{
			redirect(url('/login'));
		}
	}
	public function study()
	{
		dd('video');
	}

	public function msg()
	{
//		$messages =
		dd('video');
	}

	public function comment()
	{
		$comments = [];
		dd('comment');
	}
	public function edit_info()
	{
		dd('video');
	}
	public function edit_pwd()
	{
		dd('video');
	}

	public function info_update()
	{
		dd('资料修改');
	}

	public function pwd_update()
	{
		dd('密码修改');
	}


	public function logout(Request $request)
	{
		Session::forget($this->student_login_session_key);
		redirect('/login');
	}
	
}

