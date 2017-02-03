<?php

namespace Modules\Admin\Http\Controllers;

use Pingpong\Modules\Routing\Controller;
use App\Models\PlayLog;
use App\Models\Student;
use Illuminate\Http\Request;

/**
 * Class AdminController
 * @package App\Http\Controllers\Admin
 */
class AdminController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.index');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function studentLogs(Request $request) {
        $student = Student::where('phone', $request->input('phone'))->first();
        if($student) {
            $playLogs =  $student->playLogs;
            foreach($playLogs as $playLog) {
                $logId =  'student_course_id:' . $playLog->student_course_id;
                $details = \Redis::command('HGETALL', [$logId]);
                // update play duration
                $playDuration = 0;
                foreach ($details as $key => $value) {
                    $playDuration += $value;
                }
                if($playLog->play_duration != $playDuration) {
                    $log = PlayLog::find($playLog->id);
                    $log->play_duration = $playDuration;
                    $log->save();
                }
            }

            $playLogs =  $student->playLogs;
            foreach($playLogs as &$playLog) {
                $logId =  'student_course_id:' . $playLog->student_course_id;
                $details = \Redis::command('HGETALL', [$logId]);
                $playLog->details = $details;
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
