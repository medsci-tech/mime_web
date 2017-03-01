<?php namespace Modules\Airclass\Http\Controllers;

use Pingpong\Modules\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function return_data_format($code = 200, $msg = null, $data = null)
    {
        return ['code' => $code, 'msg' => $msg, 'data' => $data];
    }
	
}

