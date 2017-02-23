<?php

namespace Modules\Admin\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Cache;
use Modules\Admin\Entities\Site;

class MsgController extends Controller
{
    protected $all_msg_key = 'all_station_msg';
    protected $site_msg_key = 'site_station_msg';
    protected $user_msg_key = 'user_station_msg';

    public function all(){
        $cache = Cache::get($this->all_msg_key);
        $sites = Site::where('status',1)->get();

        return view('admin::backend.msg.index',[
            'lists' => $cache,
            'sites' => $sites,
            'list_row' => null,
        ]);
    }
    public function site(){
        $cache = Cache::get($this->site_msg_key);
        $sites = Site::where('status',1)->get();

        return view('admin::backend.msg.index',[
            'lists' => $cache,
            'sites' => $sites,
            'list_row' => [
                'th' => '站点',
                'td' => 'site_id',
            ],
        ]);
    }
    public function user(){
        $cache = Cache::get($this->user_msg_key);
        $sites = Site::where('status',1)->get();

        return view('admin::backend.msg.index',[
            'lists' => $cache,
            'sites' => $sites,
            'list_row' => [
                'th' => '用户',
                'td' => 'phone',
            ],
        ]);
    }

    public function setAllMsg(Request $request){
        $value = [
            'content' => $request->input('content'),
            'created_at' => Carbon::now(),
        ];
        $exits = Cache::has($this->all_msg_key);
        if($exits){
            $cache = Cache::get($this->all_msg_key);
            array_push($cache,$value);
            Cache::forever($this->all_msg_key,$cache);
        }else{
            Cache::forever($this->all_msg_key,[$value]);
        }
        $this->flash_success();
        return redirect(url('/msg/all'));
    }

    public function setSiteMsg(Request $request){
        $site_id = $request->input('site_id');
        if($site_id){
            $value = [
                'site_id' => $site_id,
                'content' => $request->input('content'),
                'created_at' => Carbon::now(),
            ];
            $exits = Cache::has($this->site_msg_key);
            if($exits){
                $cache = Cache::get($this->site_msg_key);
                array_push($cache,$value);
                Cache::forever($this->site_msg_key,$cache);
            }else{
                Cache::forever($this->site_msg_key,[$value]);
            }
            $this->flash_success();
        }else{
            $this->flash_error();
        }
        return redirect(url('/msg/site'));

    }


    public function setUserMsg(Request $request){
        $phone = $request->input('phone');
        if($phone){
            $value = [
                'phone' => $phone,
                'content' => $request->input('content'),
                'created_at' => Carbon::now(),
            ];
            $exits = Cache::has($this->user_msg_key);
            if($exits){
                $cache = Cache::get($this->user_msg_key);
                array_push($cache,$value);
                Cache::forever($this->user_msg_key,$cache);
            }else{
                Cache::forever($this->user_msg_key,[$value]);
            }
            $this->flash_success();
        }else{
            $this->flash_error();
        }
        return redirect(url('/msg/user'));
    }

    public function delete(){
        Cache::flush();
    }


}
