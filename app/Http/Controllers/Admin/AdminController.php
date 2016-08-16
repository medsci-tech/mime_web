<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.index');
    }

    public function studentLogs(Request $request) {
        $student = Student::where('phone', $request->input('phone'))->first();
        if($student) {
            $playLogs =  $student->playLogs;
            foreach($playLogs as &$playLog) {
                $logId =  'student_course_id:' . $playLog->student_course_id;
                $playLog->details = \Redis::command('HGETALL', [$logId]);
            }
            return view('admin.student.logs', [
                'student'=> $student,
                'playLogs'=> $playLogs
            ]);
        } else {
            dd('手机号未注册');
        }
    }
}
