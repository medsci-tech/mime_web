<?php

namespace App\Http\Controllers\Admin;

use App\Models\Student;
use App\Http\Controllers\Controller;
use App\Models\ThyroidClassCourse;
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
            return view('backend.tables.student', [
                'students' => Student::search($search)->paginate('10'),
                'courseArray' => $courseArray,
                'search' => $search
            ]);
        } else {
            return view('backend.tables.student', [
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
        dd($password);
        $phone = $request->input('phone');
        $password = \Hash::make(substr($phone, -6));
        $student = Student::where('phone', $phone)->first();
        $student->$password;
        $student->save();

        return response()->json([
            'success' => false
        ]);
    }
}
