<?php namespace Modules\Airclass\Http\Controllers;


use Modules\AirClass\Entities\Student;

class UserController extends Controller
{
	public function index()
	{
		$password = '123456';
		$user = Student::where(['phone' => '13554498149'])->first();
//		if($user['password'] == \Hash::make($password)){
//			\Auth::login($user);
//		}else{
//			dd(\Hash::make($password));
//		}
		$abc = \Auth::attempt(['phone' => '13554498149','password' => '123456']);
//		$students = Student::where('')


		dd($abc);
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

