<?php

namespace App\Http\Controllers\ThyroidClass;

use App\Helpers\Statistics\Facades\Statistics;
use App\Models\ThyroidClass;
use App\Models\ThyroidClass\ThyroidClassCourse;
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
        $this->middleware('replenish');
        parent::__construct();
    }

    public function view(Request $request)
    {
        \Statistics::updateCount($request->input('course_id'));
        $course = ThyroidClassCourse::find($request->input('course_id'));
        return view('thyroid-class.course.view', [
            'course' => $course,
            'phase' => $course->thyroidClassPhase,
            'thyroidClassPhases' => ThyroidClassPhase::all()
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function timer()
    {
        if (\Redis::command('EXISTS', ['studentId:' . $this->studentId])) {
            \Redis::command('INCRBYFLOAT', ['studentId:' . $this->studentId, 0.5]);
            return response()->json(['success' => true]);
        } else {
            return response()->json([
                'success' => \Redis::command('SET', ['studentId:' . $this->studentId, 0.5])
            ]);
        }
    }

}
