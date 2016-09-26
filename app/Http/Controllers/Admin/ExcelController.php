<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PlayLog;
use App\Models\Student;
use App\Models\ThyroidClassCourse;
use App\Models\ThyroidClassPhase;
use Illuminate\Http\Request;

/**
 * Class ExcelController
 * @package App\Http\Controllers\Admin
 */
class ExcelController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function excelForm()
    {
        return view('admin.excel');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function student(Request $request)
    {
        $excel = $request->file('excel');
        \Excel::load($excel, function ($reader) use ($excel) {
            $excelData = \Excel::load($excel)->get()->toArray();
            foreach ($excelData as $data) {
                $data['password'] = \Hash::make(substr($data['phone'],-6));
                Student::create($data);
            }
        });
        return redirect('/admin/excel');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
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

            foreach ($excelData as $data) {
                $logData = [
                    'student_id' => $studentsArray[$data['phone']],
                    'thyroid_class_phase_id' => $data['thyroid_class_phase_id'],
                    'thyroid_class_course_id' => $data['thyroid_class_course_id'],
                    'play_times' => $data['play_times'],
                    'play_duration' => $data['play_duration'],
                    'student_course_id' => $studentsArray[$data['phone']].'-'.$data['thyroid_class_course_id']
                ];
                PlayLog::create($logData);
            }
        });
        return redirect('/admin/excel');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
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

    /**
     *
     */
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

    /**
     * @param $logId
     * @param $date
     */
    function getClickedAt($logId, &$date) {
        if (\Redis::command('HEXISTS', [$logId, $date])) {
            $date = date('Y-m-d H:i:s',strtotime('+1 second',strtotime($date)));;
            $this->getClickedAt($logId, $date);
        } else {
            return;
        }
    }

    /**
     * @param Request $request
     */
    function getLogDetail(Request $request) {
        //'student_course_id:' . $studentsArray[$data['phone']] .'-'.$data['thyroid_class_course_id'];
        $logId =  'student_course_id:' . $request->input('student_id').'-'.$request->input('course_id');
        echo \Session::get('studentId');
        dd(\Redis::command('hgetall', [$logId]));
    }


    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function Logs2Excel() {
        $courses = ThyroidClassCourse::all();
        $coursesArray = array();
        foreach($courses as $course) {
            $coursesArray[$course->id] = [
                'course' => $course->sequence.$course->title,
                'phase' => $course->thyroidClassPhase->title,
            ];
        }

        $students = Student::get(['id', 'phone', 'name']);
        $studentsArray = array();
        foreach($students as $student) {
            $studentsArray[$student->id] = ['name' => $student->name, 'phone' => $student->phone];
        }

        $studentCourseIds = \Redis::command('keys', ['student_course_id*']);
        $cellData = [['单元名称', '课程名称', '学员姓名',  '学员电话', '起始观看时间', '观看时长(单位/秒)']];
        foreach($studentCourseIds as $studentCourseId) {
            $logs = \Redis::command('HGETAll', [$studentCourseId]);
            $logArray = explode('-' ,substr($studentCourseId, strpos($studentCourseId, ':')+1));
            foreach($logs as $key => $value) {
                $item = [
                    $coursesArray[$logArray[1]]['phase'],
                    $coursesArray[$logArray[1]]['course'],
                    $studentsArray[$logArray[0]]['name'],
                    $studentsArray[$logArray[0]]['phone'],
                    $key,
                    $value,
                ];
                array_push($cellData, $item);
            }
        }

        \Excel::create('公开课观看日志',function($excel) use ($cellData){
            $excel->sheet(date('Y-M-D'), function($sheet) use ($cellData){
                $sheet->rows($cellData);
            });
        })->export('xls');

        return redirect()->back();
    }
}
