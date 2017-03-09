<?php namespace Modules\Airclass\Http\Controllers;

use Pingpong\Modules\Routing\Controller as BaseController;
use \App\Model\Hospital;
use \App\Model\Address;
class Controller extends BaseController
{
    protected $student_login_session_key = 'student_login_session_key'; // 用户登录session key
    protected $site_id = 1; // airClass site_id

    public function return_data_format($code = 200, $msg = null, $data = null)
    {
        return ['code' => $code, 'msg' => $msg, 'data' => $data];
    }


	
}

