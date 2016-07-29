<?php

namespace App\Http\Controllers\ThyroidClass;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CourseController extends Controller
{
    
    //
    public function __construct()
    {
        $this->middleware('replenish', ['only' => ['view', ]]);
    }

    public function view(Request $request)
    {

    }

}
