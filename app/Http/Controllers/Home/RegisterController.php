<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    //
    public function create(Request $request)
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

        

    }

    public function sms(Request $request)
    {

    }
    
}
