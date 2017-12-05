<?php
namespace Modules\AirClass\Http\Controllers;

use Illuminate\Http\Request;
use Modules\AirClass\Entities\Wenjuan;

class ActivityController extends Controller{
    public function __construct(){
        $this->middleware('login');
        parent::__construct();
    }

    public function questionNaire(Request $request){
        if($request->isMethod('post')){
            $wenjuan = new Wenjuan();
            $wenjuan->uid = $this->user['id'];
            $wenjuan->q1 = $request->q1;
            $wenjuan->q2 = $request->q2;
            $wenjuan->q3 = $request->q3;
            $wenjuan->q4 = $request->q4;
            $wenjuan->q5 = $request->q5;
            $wenjuan->q6 = $request->q6;
            $wenjuan->q7 = $request->q7;
            $wenjuan->q8 = $request->q8;
            if(!$wenjuan->save()){
                return Response()->json(['code'=>0,'status'=>'提交失败','data'=>[]]);
            }
            \Redis::set('wenjuan_'.$this->user['id'],1);
            return Response()->json(['code'=>1,'msg'=>'提交成功','data'=>[]]);
        }
        return view('modules.airclass.layouts.wenjuan');
    }
}