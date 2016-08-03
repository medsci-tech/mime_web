<?php

namespace App\Http\Controllers\ThyroidClass;

use App\Models\ThyroidClass\ThyroidClass;
use App\Models\ThyroidClassPhase;
use App\Models\ThyroidClassStudent;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ThyroidClassController extends Controller
{
    
    //
    public function index()
    {
        return view('thyroid-class.index', [
            'thyroidClass' => ThyroidClass::all()->first(),
            'thyroidClassPhases' => ThyroidClassPhase::all(),
            'studentCount' => ThyroidClassStudent::count()
        ]);
    }

    public function teachers(Request $request)
    {

    }

    public function questions(Request $request)
    {

    }

    public function phases(Request $request)
    {

    }
    
}
