<?php

namespace App\Http\Controllers\ThyroidClass;

use App\Models\Banner;
use App\Models\ThyroidClassCourse;
use App\Models\ThyroidClassPhase;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\WebController;

/**
 * Class CourseController
 * @package App\Http\Controllers\ThyroidClass
 */
class CourseController extends WebController
{
    /**
     *
     */
    public function __construct()
    {
        $this->middleware('login');
        //$this->middleware('replenish');
        parent::__construct();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view(Request $request)
    {
        $date = date('Y-m-d H:i:s');
        \Statistics::updateCount($request->input('course_id'), $date);
        return view('thyroid-class.course.view', [
            'course' => ThyroidClassCourse::find($request->input('course_id')),
            'thyroidClassPhases' => ThyroidClassPhase::all(),
            'date' => $date,
            'banner' => Banner::where('page', 'view')->where('status', 1)->orderBy('weight', 'desc')->first()
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function timer(Request $request)
    {
        $courseId = $request->input('course_id');
        if ($courseId) {
            $date = $request->input('date');
            $logId = 'student_course_id:' . $this->studentId . '-' . $courseId;
            return response()->json([
                'success' => \Redis::command('HINCRBY', [$logId, $date, 30])
            ]);
        } else {
            return response()->json([
                'success' => false
            ]);
        }
    }
}
