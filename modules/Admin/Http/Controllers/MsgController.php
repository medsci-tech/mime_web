<?php

namespace Modules\Admin\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Cache;
use App\Models\Message;
use App\Models\Doctor;
use Modules\Admin\Entities\Site;

class MsgController extends Controller
{

    public function all(){
        $sites = Site::where('status',1)->get();

        return view('admin::backend.msg.index',[
            'lists' => Message::paginate(20),
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

        $msg_type = $request->input('msg_type');
        $site_id = $request->input('site_id');
        $content = $request->input('content');
        if($msg_type ==3) // 个人消息
        {
            $phones= $request->input('phones');
            $phones = preg_replace("/(\n)|(\s)|(\t)|(\')|(')|(，)|(\.)/",',',$phones);
            $p_arr =explode(',',$phones);
            foreach($p_arr as $val)
            {
                $res = Doctor::where('phone', $val)->first();
                if($res)
                {
                    $data[] = [
                        'phone' => $val,
                        'msg_type'=> $msg_type,
                        'site_id'=> 0,
                        'content' => $content,
                        'created_at' => Carbon::now(),
                    ];
                }
            }
            Message::insert($data);
        }
        else // 群发
        {
            $res = \DB::table('doctors')->groupBy('phone')->get();
            foreach($res as $val)
            {
                $data[] = [
                    'phone' => $val->phone,
                    'msg_type'=> $msg_type,
                    'site_id'=> $site_id,
                    'content' => $content,
                    'created_at' => Carbon::now(),
                ];
            }
            Message::insert($data);
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
