<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PlayLog;
use App\Models\Student;
use App\Models\ThyroidClassPhase;
use Illuminate\Http\Request;

class ExcelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function excelForm()
    {
        return view('admin.excel');
    }

    public function student(Request $request)
    {
        $excel = $request->file('excel');
        \Excel::load($excel, function ($reader) use ($excel) {
            $excelData = \Excel::load($excel)->get()->toArray();
            foreach ($excelData as $data) {
                Student::create($data);
            }
        });
        return redirect('/admin/excel');
    }

    public function playLog(Request $request)
    {
        $excel = $request->file('excel');
        \Excel::load($excel, function ($reader) use ($excel) {
            $excelData = \Excel::load($excel)->get()->toArray();

            $students = Student::get(['id', 'phone']);
            $studentsArray = array();
            foreach($students as $student) {
                $studentsArray[$student->phone] = $student->id;
            }

            $phases = ThyroidClassPhase::get(['id', 'main_teacher_id']);
            $phasesArray = array();
            foreach($phases as $phase) {
                $phasesArray[$phase->id] = $phase->main_teacher_id;
            }

            foreach ($excelData as $data) {
                $logData = [
                    'student_id' => $studentsArray[$data['phone']],
                    'teacher_id' => $phasesArray[$data['thyroid_class_phase_id']],
                    'thyroid_class_phase_id' => $data['thyroid_class_phase_id'],
                    'thyroid_class_course_id' => $data['thyroid_class_course_id'],
                    'play_times' => $data['play_times'],
                    'play_duration' => $data['play_duration'],
                    'student_course_id' => $studentsArray[$data['phone']].'-'.$data['thyroid_class_course_id'],

                ];
                PlayLog::create($logData);
            }
        });
        return redirect('/admin/excel');
    }

    public function playLogDetail(Request $request)
    {
        $excel = $request->file('excel');
        \Excel::load($excel, function ($reader) use ($excel) {
            $excelData = \Excel::load($excel)->get()->toArray();

            $students = Student::get(['id', 'phone']);
            $studentsArray = array();
            foreach($students as $student) {
                $studentsArray[$student->phone] = $student->id;
            }

            foreach ($excelData as $data) {
                $logId =  'student_course_id:' . $studentsArray[$data['phone']] .'-'.$data['thyroid_class_course_id'];
                $date =  $data['clicked_at'];
                $this->getClickedAt($logId, $date);
                \Redis::command('HSET', [$logId, $date, $data['play_duration']]);
            }
        });
        return redirect('/admin/excel');
    }

    public function test() {
        //dd(\Redis::command('flushall'));
        $logs = PlayLog::all();
        foreach($logs as $log) {
            $logId =  'student_course_id:' . $log->student_course_id;
            $data = \Redis::command('HGETALL', [$logId]);
            $playTimes = \Redis::command('HLEN', [$logId]);
            if($log->play_times == $playTimes) {
                echo $log->id.':success<br>';
                // 次数
                $playDuration = 0;
                foreach($data as $item) {
                    $playDuration += $item;
                }
                if($playDuration == $log->play_duration) {
                    echo 'play_duration:success';
                } else {
                    echo 'play_duration:fail;log_play_duration:'.$log->play_duration.';redis_play_duration:'.$playDuration;
                }
                echo '<hr>';
            } else {
                // 次数
                echo $log->play_times;
                echo $playTimes;
                var_dump( \Redis::command('hgetall', [$logId]));
                echo $log->id.':fail';
                // 时间
                $playDuration = 0;
                foreach($data as $item) {
                    $playDuration += $item;
                }
                if($playDuration == $log->play_duration) {
                    echo 'play_duration:success';
                } else {
                    echo 'play_duration:fail;log_play_duration:'.$log->play_duration.';redis_play_duration:'.$playDuration;
                }

                echo '<hr>';
            }
        }
    }

    function getClickedAt($logId, &$date) {
        if (\Redis::command('HEXISTS', [$logId, $date])) {
            $date = date('Y-m-d H:i:s',strtotime('+1 second',strtotime($date)));;
            $this->getClickedAt($logId, $date);
        } else {
            return;
        }
    }
}
