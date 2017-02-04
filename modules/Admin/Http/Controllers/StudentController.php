<?php

namespace Modules\Admin\Http\Controllers;

use Modules\Admin\Entities\Student;
use Pingpong\Modules\Routing\Controller;
use Modules\Admin\Entities\ThyroidClassCourse;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $courseArray = [];
        foreach (ThyroidClassCourse::all() as $course) {
            $courseArray[$course->id] = $course->title;
        }
        if ($request->has('search')) {
            $search = $request->input('search');
            return view('admin::backend.tables.student', [
                'students' => Student::search($search)->paginate('10'),
                'courseArray' => $courseArray,
                'search' => $search
            ]);
        } else {
            return view('admin::backend.tables.student', [
                'students' => Student::paginate('10'),
                'courseArray' => $courseArray
            ]);
        }
    }

    /**
     *
     */
    public function Logs2Excel()
    {
        $keys = \Redis::command('keys ', ["student_course_id*"]);
        $logs = \Redis::command('HGETALL ', $keys);
        dd($logs);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function resetPwd(Request $request)
    {
        $phone = $request->input('phone');
        $password = \Hash::make(substr($phone, -6));
        $student = Student::where('phone', $phone)->first();
        $student->password = $password;

        return response()->json([
            'success' => $student->save()
        ]);
    }
}
