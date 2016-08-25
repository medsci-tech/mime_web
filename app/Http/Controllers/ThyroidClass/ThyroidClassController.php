<?php

namespace App\Http\Controllers\ThyroidClass;

use App\Http\Controllers\WebController;
use App\Models\PlayLog;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\ThyroidClass\ThyroidClass;
use App\Models\ThyroidClassCourse;
use App\Models\ThyroidClassPhase;
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
            'studentCount' =>  \Redis::command('GET', 'enter_count'),
            'playCount' =>  \Redis::command('GET', 'play_count'),
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
            \Redis::command('INCRBY ', 'enter_count');
            return response()->json(['success' => true]);
        }
    }

    function updateStatistics() {
        \Redis::command('SET', ['enter_count', Student::whereNotNull('entered_at')->count()]);
        \Redis::command('SET', ['student_count', Student::all()->count()]);
        \Redis::command('SET', ['play_count', PlayLog::all()->sum('play_times')]);
        $courses = ThyroidClassCourse::all();
        foreach($courses as $course) {
            \Redis::command('HSET', ['course_play_count', 'thyroid_class_course_id:'.$course->id, PlayLog::where('thyroid_class_course_id', $course->id)->sum('play_times')]);
        }

        $phases = ThyroidClassPhase::all();
        foreach($phases as $phase) {
            \Redis::command('HSET', ['phase_play_count', 'thyroid_class_phase_id:'.$phase->id, PlayLog::where('thyroid_class_phase_id', $phase->id)->sum('play_times')]);
        }
    }
}
