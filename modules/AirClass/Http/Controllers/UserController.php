<?php namespace Modules\Airclass\Http\Controllers;

use Illuminate\Http\Request;
use Modules\AirClass\Entities\Student;

class UserController extends Controller
{
	public function index(Request $request)
	{
		$user = \Session::get('login_student');
		dd($user);
	}

	public function info_update()
	{
		dd('资料修改');
	}

	public function pwd_update()
	{
		dd('密码修改');
	}


	
}

