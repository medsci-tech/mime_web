<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
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
