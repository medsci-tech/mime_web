<?php namespace Modules\AirClass\Http\Controllers;

use Pingpong\Modules\Routing\Controller as BaseController;
use \App\Model\Hospital;
use \App\Model\Address;
class Controller extends BaseController
{
    protected $user_login_session_key = 'user_login_session_key'; // 用户登录session key
    protected $site_id = 1; // airClass site_id
    protected $public_class_id = 4; // 公开课id
    protected $answer_class_id = 2; // 答疑课id
    protected $private_class_id = 3; // 空课项目私教课id

    public function return_data_format($code = 200, $msg = null, $data = null)
    {
        return ['code' => $code, 'msg' => $msg, 'data' => $data];
    }


	
}

