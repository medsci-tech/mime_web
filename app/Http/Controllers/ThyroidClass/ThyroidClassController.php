<?php

namespace App\Http\Controllers\ThyroidClass;

use App\Http\Controllers\WebController;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\ThyroidClass\ThyroidClass;
use App\Models\ThyroidClassPhase;
use App\Models\ThyroidClassStudent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;

/**
 * Class ThyroidClassController
 * @package App\Http\Controllers\ThyroidClass
 */
class ThyroidClassController extends WebController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('thyroid-class.index', [
            'teachers' => Teacher::all(),
            'thyroidClass' => ThyroidClass::all()->first(),
            'thyroidClassPhases' => ThyroidClassPhase::all(),
            'studentCount' => ThyroidClassStudent::count()
        ]);
    }

    /**
     * @param Request $request
     */
    public function teachers(Request $request)
    {

    }

    /**
     * @param Request $request
     */
    public function questions(Request $request)
    {

    }

    /**
     * @param Request $request
     */
    public function phases(Request $request)
    {

    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function enter()
    {
        $this->middleware('login');
        $this->middleware('replenish');

        $student = Student::find(\Session::get('studentId'));
        if ($student->entered_at) {
            return response()->json(['success' => false, 'error_message' => '已报名']);
        } else {
            $student->entered_at = Carbon::now();
            $student->save();
            return response()->json(['success' => true]);
        }
    }

}
