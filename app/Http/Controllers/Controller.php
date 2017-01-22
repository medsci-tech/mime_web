<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

/**
 * Class Controller
 * @package App\Http\Controllers
 */
class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

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
