<?php

namespace Modules\Admin\Http\Controllers;

use Redis;
use Illuminate\Http\Request;

use App\Http\Requests;

class MsgController extends Controller
{
    public function index(){
        $redis = Redis::connection();;
        dd($redis);
    }

    public function set(){
        $key = 'user:name:6';
        $user = 'zhaiyu1';
        $redis = Redis::set($key,$user);
        dd($redis);
    }
    public function get(){
        $redis = Redis::get('user:name:6');
        dd($redis);
    }


}
