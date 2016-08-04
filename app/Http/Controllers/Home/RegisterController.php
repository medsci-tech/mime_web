<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\MessageVerify;
use App\Models\Student;

class RegisterController extends Controller
{
    //
    public function create()
    {
        return view('home.register.create');
    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'phone'     => 'required|digits:11|unique:students,phone,',
            'password'  => 'required',
            'auth_code' => 'required|digits:6',
        ]);
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        } /*if>*/

        $messageVerify = MessageVerify::where('phone', '=', $request->input('phone'))->orderBy('created_at', 'desc')->first();
        if (!$messageVerify)
        {
            return redirect()->back()->with('error_message', '电话号码不存在')->withInput();
        } /*if>*/

        if ($messageVerify->phone != $request->input('phone'))
        {
            return redirect()->back()->with('error_message', '电话号码错误')->withInput();
        } /*if>*/

        if ($messageVerify->code != $request->input('auth_code'))
        {
            return redirect()->back()->with('error_message', '验证码错误')->withInput();
        } /*if>*/

        $student = new Student();
        $student->phone = $request->input('phone');
        $student->password = \Hash::make($request->input('password'));
        $student->save();

        return redirect('home/register/success');
    }

    public function sms(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'phone' => 'required|digits:11|unique:students,phone,'
        ]);

        if ($validator->fails())
        {
            return response()->json(['success' => false, 'error_message' => $validator->errors()->getMessages()]);
        } /*if>*/

        $result = \Message::createVerify($request->input('phone'));
        if ($result) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function success()
    {
        return view('home.register.success');
    }

    public function error()
    {
        return view('home.register.error');
    }
    
}
