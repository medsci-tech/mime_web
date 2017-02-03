<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Pingpong\Modules\Routing\Controller;
class WebController extends Controller
{
    /**
     * @var mixed
     */
    protected $studentId;

    /**
     *
     */
    public function __construct()
    {
        $this->studentId = \Session::get('studentId');
    }
}
