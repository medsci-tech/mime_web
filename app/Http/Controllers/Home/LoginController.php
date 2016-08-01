<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Student;

class LoginController extends Controller
{
    //
    public function showLoginForm()
    {
        return view('home.login');
    }

    public function login(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'phone'     => 'required|digits:11|unique:students,phone,',
            'password'  => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } /*if>*/

        $student = Student::where('phone', '=', $request->input('phone'))->first();
        if (!$student)
        {
            return redirect()->back()->with('error_message', '电话号码不存在!')->withInput();
        } /*if>*/

        if (\Hash::check($request->input('password'), $student->password))
        {
            return redirect()->back()->with('error_message', '密码不匹配!')->withInput();
        } /*if>*/

        \Session::set('studentId', $student->id);

        return redirect('thyroid-class/index');
    }

} /*class*/
