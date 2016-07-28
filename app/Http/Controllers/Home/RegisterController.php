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

    }

    public function sms(Request $request)
    {

    }

    public function error(Request $request)
    {
        return view('home.register.error');
    }

    public function success(Request $request)
    {
        return view('home.register.success');
    }

}
