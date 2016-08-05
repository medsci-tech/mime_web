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
        $messages = [
            'phone.required' => '手机号未填写',
            'phone.digits' => '收获格式不正确',
            'phone.unique' => '手机号已注册',
            'auth_code.required' => '验证码未填写',
            'auth_code.digits' => '验证码格式不正确',
            'password.required' => '密码未填写',
            'password.confirmed' => '两次密码不一致'
        ];

        $rules = [
            'phone' => 'required|digits:11|unique:students,phone,',
            'password' => 'required',
            'auth_code' => 'required|digits:6',
        ];

        $validator = \Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        } /*if>*/

        $messageVerify = MessageVerify::where('phone', '=', $request->input('phone'))->orderBy('created_at', 'desc')->first();
        if (!$messageVerify) {
            $validator->errors()->add('phone', '电话号码错误');
            return redirect()->back()->withErrors($validator->errors())->withInput();
        } /*if>*/

        if ($messageVerify->phone != $request->input('phone')) {
            $validator->errors()->add('phone', '电话号码错误');
            return redirect()->back()->withErrors($validator->errors())->withInput();
        } /*if>*/

        if ($messageVerify->code != $request->input('auth_code')) {
            $validator->errors()->add('auth_code', '验证码错误');
            return redirect()->back()->withErrors($validator->errors())->withInput();
        } /*if>*/

        $student = new Student();
        $student->phone = $request->input('phone');
        $student->password = \Hash::make($request->input('password'));
        $student->save();

        \Session::set('studentId', $student->id);

        return redirect('/home/replenish/create');
    }

    public function sms(Request $request)
    {
        $messages = [
            'phone.required' => '手机号未填写',
            'phone.digits' => '收获格式不正确',
            'phone.unique' => '手机号已注册'
        ];

        $validator = \Validator::make($request->all(), [
            'phone' => 'required|digits:11|unique:students,phone,'
        ], $messages);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error_message' => $validator->errors()->first()]);
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
