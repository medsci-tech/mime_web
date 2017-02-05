<?php

namespace Modules\Admin\Http\Controllers;

use Pingpong\Modules\Routing\Controller as BaseController;
/**
 * Class Controller
 * @package App\Http\Controllers
 */
class Controller extends BaseController
{

    public function flash_success(){
        \Session::flash('alert', [
            'type' => 'success',
            'title' => '成功',
            'message' => '操作成功'
        ]);
    }
    public function flash_error(){
        \Session::flash('alert', [
            'type' => 'danger',
            'title' => '失败',
            'message' => '操作失败'
        ]);
    }
}
