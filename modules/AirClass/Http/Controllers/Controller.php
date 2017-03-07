<?php namespace Modules\Airclass\Http\Controllers;

use Pingpong\Modules\Routing\Controller as BaseController;

class Controller extends BaseController
{
    protected $student_login_session_key = 'student_login_session_key'; // 用户登录session key
    protected $site_id = 1; // airClass site_id

    public function return_data_format($code = 200, $msg = null, $data = null)
    {
        return ['code' => $code, 'msg' => $msg, 'data' => $data];
    }

    protected function verify_code_post($phone, $code)
    {
        return $this->return_data_format(200);
    }
	
}

