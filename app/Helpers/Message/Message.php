<?php

namespace App\Helpers\Message;

use App\Models\MessageVerify;

/**
 * Class Message
 * @package App\Helpers\Message
 */
class Message
{
    /**
     * @var string
     */
    protected $_apiKey;

    /**
     *
     */
    public function __construct()
    {
        $this->_apiKey = env('LUOSIMAO_API_KEY');
    }

    /**
     * 创建验证码
     *
     * @param $phone
     * @return bool
     */
    public function createVerify($phone)
    {
        $messageVerifyNumber = mt_rand(100000, 999999);
        $message = '验证码：尊敬的用户您好！获取的验证码为：'.$messageVerifyNumber.'如非本人操作请忽略本条短信【迈德科技】';
        $res = $this->sendMessageCode($phone, $message);
        //$res = '{"error":0,"msg":"ok"}';
        $res = json_decode($res);
        dd($res);
        if ($res->error == 0) {
            $messageVerify = new MessageVerify();
            $messageVerify->phone = $phone;
            $messageVerify->code = $messageVerifyNumber;
            $messageVerify->save();
            return $messageVerify->id;
        } else {
            return false;
        }
    }

    /**
     * @param $phone
     * @param $message
     *
     * @return mixed
     */
    public function sendMessageCode($phone, $message)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://sms-api.luosimao.com/v1/send.json");

        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, 'api:key-' . $this->_apiKey);

        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, array('mobile' => $phone, 'message' => $message));

        $res = curl_exec($ch);
        curl_close($ch);
        //$res  = curl_error( $ch );
        return $res;
    }

    /**
     * @param $phone
     * @param $message
     *
     * @return mixed
     */
    public function sendBatchMessageCode($phone, $message)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://sms-api.luosimao.com/v1/send_batch.json");
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, 'api:key-' . $this->_apiKey);

        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, array('mobile_list' => $phone, 'message' => $message));

        $res = curl_exec($ch);
        curl_close($ch);
        //$res  = curl_error( $ch );
        return $res;
    }

    /**
     * @param $verifyId
     * @param $verifyCode
     * @return bool
     */
    public function checkVerify($verifyId, $verifyCode)
    {
        $messageVerify = MessageVerify::find($verifyId);
        if ($messageVerify->code == $verifyCode and $messageVerify->status == 0) {
            $messageVerify->status = 1;
            $messageVerify->save();
            return true;
        }
        return false;
    }
}