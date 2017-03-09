<?php namespace Modules\Airclass\Http\Controllers;

use App\Models\Address;
use App\Models\Doctor;
use App\Models\Hospital;

class SmsController extends Controller
{
    protected $code_prefix = 'phone_code_';
    /**
     * 发送手机验证码
     * @author zhaiyu
     * @param $phone
     * @param $type
     * @param $required ：1，必须有；-1，必须无；0，随意
     * @return array
     */
    public function send_sms($phone, $required = 0)
    {
        if($phone){
            $code   = \MessageSender::generateMessageVerify();
            $user = null;
            // 如果不是随意发送短信验证码，则验证用户存在与否
            if($required != 0){
                $user = Doctor::where('phone', $phone)->first();
            }
            if(($required == 1 && $user) || ($required == -1 && !$user) || $required == 0){
                $session_res= \Session::set($this->code_prefix . $phone, $code);
                if($session_res){
                    $res = \MessageSender::sendMessageVerify($phone, $code);
                    if(json_decode($res)->error == 0){
                        return ['code' => 200, 'msg'=>'success'];
                    }else{
                        return ['code' => 500, 'msg'=>'SMS interface call failed'];
                    }
                }else{
                    return ['code' => 500, 'msg'=>'service error'];
                }
            }elseif($user){
                return ['code' => 422, 'msg'=>'not found phone'];
            }else{
                return ['code' => 422, 'msg'=>'phone existed'];
            }
        }else{
            return ['code' => 422, 'msg'=>'params error'];
        }
    }


    public function verify_code_post($phone, $code)
    {
        return $this->return_data_format(200);
    }




}

