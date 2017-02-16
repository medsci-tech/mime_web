<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Redis;

class MsgController extends Controller
{
    public function index(){
        $redis = Redis::connection();;
        dd($redis);
    }

    public function set(){
//        $key = 'user:name:6';
//        $user = json_encode(['324','rewr']);
//        $redis = Redis::set($key,$user);

//        $redis = Redis::pipeline(function ($pipe) {
//            for ($i = 0; $i < 10; $i++) {
//                $pipe->set("key:$i", $i);
//            }
//        });

        $redis = Redis::publish('test-channel', 'hehe123214');
        dd($redis);
    }
    public function get(){
//        $redis = Redis::get('test-channel');
//        $redis = Redis::exists('user:name:6');
        $redis = \Artisan::call('redis:subscribe');
        dd($redis);
    }


}
