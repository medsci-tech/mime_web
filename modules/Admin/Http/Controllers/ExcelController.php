<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Entities\PlayLog;
use Modules\Admin\Entities\Student;
use Modules\Admin\Entities\ThyroidClassCourse;
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
                $data['password'] = \Hash::make(substr($data['phone'], -6));
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
            foreach ($students as $student) {
                $studentsArray[$student->phone] = $student->id;
            }

            foreach ($excelData as $data) {
                $logData = [
                    'student_id' => $studentsArray[$data['phone']],
                    'thyroid_class_phase_id' => $data['thyroid_class_phase_id'],
                    'thyroid_class_course_id' => $data['thyroid_class_course_id'],
                    'play_times' => $data['play_times'],
                    'play_duration' => $data['play_duration'],
                    'student_course_id' => $studentsArray[$data['phone']] . '-' . $data['thyroid_class_course_id']
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
            foreach ($students as $student) {
                $studentsArray[$student->phone] = $student->id;
            }

            foreach ($excelData as $data) {
                $logId = 'student_course_id:' . $studentsArray[$data['phone']] . '-' . $data['thyroid_class_course_id'];
                $date = $data['clicked_at'];
                $this->getClickedAt($logId, $date);
                \Redis::command('HSET', [$logId, $date, $data['play_duration']]);
            }
        });
        return redirect('/admin/excel');
    }

    /**
     *
     */
    public function test()
    {
        //dd(\Redis::command('flushall'));
        $logs = PlayLog::all();
        foreach ($logs as $log) {
            $logId = 'student_course_id:' . $log->student_course_id;
            $data = \Redis::command('HGETALL', [$logId]);
            $playTimes = \Redis::command('HLEN', [$logId]);
            if ($log->play_times == $playTimes) {
                echo $log->id . ':success<br>';
                // 次数
                $playDuration = 0;
                foreach ($data as $item) {
                    $playDuration += $item;
                }
                if ($playDuration == $log->play_duration) {
                    echo 'play_duration:success';
                } else {
                    echo 'play_duration:fail;log_play_duration:' . $log->play_duration . ';redis_play_duration:' . $playDuration;
                }
                echo '<hr>';
            } else {
                // 次数
                echo $log->play_times;
                echo $playTimes;
                var_dump(\Redis::command('hgetall', [$logId]));
                echo $log->id . ':fail';
                // 时间
                $playDuration = 0;
                foreach ($data as $item) {
                    $playDuration += $item;
                }
                if ($playDuration == $log->play_duration) {
                    echo 'play_duration:success';
                } else {
                    echo 'play_duration:fail;log_play_duration:' . $log->play_duration . ';redis_play_duration:' . $playDuration;
                }

                echo '<hr>';
            }
        }
    }

    /**
     * @param $logId
     * @param $date
     */
    function getClickedAt($logId, &$date)
    {
        if (\Redis::command('HEXISTS', [$logId, $date])) {
            $date = date('Y-m-d H:i:s', strtotime('+1 second', strtotime($date)));;
            $this->getClickedAt($logId, $date);
        } else {
            return;
        }
    }

    /**
     * @param Request $request
     */
    function getLogDetail(Request $request)
    {
        //'student_course_id:' . $studentsArray[$data['phone']] .'-'.$data['thyroid_class_course_id'];
        $logId = 'student_course_id:' . $request->input('student_id') . '-' . $request->input('course_id');
        echo \Session::get('studentId');
        dd(\Redis::command('hgetall', [$logId]));
    }


    /**
     * @return \Illuminate\Http\RedirectResponse
     */
//    public function logs2Excel() {
//        $courses = ThyroidClassCourse::all();
//        $coursesArray = array();
//        foreach($courses as $course) {
//            $coursesArray[$course->id] = [
//                'course' => $course->sequence.$course->title,
//                'phase' => $course->thyroidClassPhase->title,
//            ];
//        }
//
//        $students = Student::get(['id', 'phone', 'name']);
//        $studentsArray = array();
//        foreach($students as $student) {
//            $studentsArray[$student->id] = ['name' => $student->name, 'phone' => $student->phone];
//        }
//
//        $studentCourseIds = \Redis::command('keys', ['student_course_id*']);
//        $cellData = [['单元名称', '课程名称', '学员姓名',  '学员电话', '起始观看时间', '观看时长(单位/秒)']];
//        foreach($studentCourseIds as $studentCourseId) {
//            //echo $studentCourseId.'<hr />';
//            $logs = \Redis::command('HGETAll', [$studentCourseId]);
//            $logArray = explode('-' ,substr($studentCourseId, strpos($studentCourseId, ':')+1));
//            foreach($logs as $key => $value) {
//                if($key > '2016-09-08 00:00:00' && $value > 7200) {
//                    $item = [
//                        $coursesArray[$logArray[1]]['phase'],
//                        $coursesArray[$logArray[1]]['course'],
//                        $studentsArray[$logArray[0]]['name'],
//                        $studentsArray[$logArray[0]]['phone'],
//                        $key,
//                        7200,
//                    ];
//                } else {
//                    $item = [
//                        $coursesArray[$logArray[1]]['phase'],
//                        $coursesArray[$logArray[1]]['course'],
//                        $studentsArray[$logArray[0]]['name'],
//                        $studentsArray[$logArray[0]]['phone'],
//                        $key,
//                        $value,
//                    ];
//                }
//                array_push($cellData, $item);
//            }
//        }
//
//        \Excel::create('公开课观看日志',function($excel) use ($cellData){
//            $excel->sheet(date('Y-M-D'), function($sheet) use ($cellData){
//                $sheet->rows($cellData);
//            });
//        })->export('xls');
//
//        return redirect('/admin/student');
//    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    /*public function logs2Excel(Request $request)
    {

        $site_id = $request->input('site_id');
        $courses = ThyroidClassCourse::where('site_id',$site_id)->get();
        $coursesArray = array();
        foreach ($courses as $course) {
            $coursesArray[$course->id] = [
                'course' => $course->sequence . $course->title,
                'phase' => $course->thyroid_class_phase_id?$course->thyroidClassPhase->title:''
            ];
            //dd($course->thyroidClassPhase->title);
        }

        $students = Student::where('site_id',$site_id)->get(['id', 'phone', 'name']);
        $studentsArray = array();
        foreach ($students as $student) {
            $studentsArray[$student->id] = ['name' => $student->name, 'phone' => $student->phone];
        }

        $playLogs = PlayLog::where('updated_at', '>', '2016-10-01')->get();
        $cellData = [['单元名称', '课程名称', '学员姓名', '学员电话', '起始观看时间', '观看时长(单位/秒)']];
        foreach ($playLogs as $playLog) {
            //echo $studentCourseId.'<hr />';
            foreach ($playLog->details as $key => $value) {
                $item = [
                    $coursesArray[$playLog->thyroid_class_course_id]['phase'],
                    $coursesArray[$playLog->thyroid_class_course_id]['course'],
                    $studentsArray[$playLog->student_id]['name'],
                    $studentsArray[$playLog->student_id]['phone'],
                    $key,
                    $value
                ];
                array_push($cellData, $item);
            }
        }
        \Excel::create('公开课观看日志', function ($excel) use ($cellData) {
            $excel->sheet(date('Y-m-d'), function ($sheet) use ($cellData) {
                $sheet->rows($cellData);
            });
        })->export('xls');

        return redirect('/admin/student');
    }*/

    public function logs2Excel(Request $request)
    {
        set_time_limit(0);
        ini_set('memory_limit','1024M');
        $site_id = $request->input('site_id');
        $courses = DB::table('thyroid_class_courses')->where(['site_id'=>$site_id,'is_show'=>1])->select('title','id','course_class_id','course_type')->get();
        //所有课程的id
        $course_id = DB::table('thyroid_class_courses')->where(['site_id'=>$site_id,'is_show'=>1])->pluck('id');
        //dd($courses);
        //导出表的第一行
        $cellData = [['ID编号','手机号', '学员姓名', '大区', '省', '市', '区', '医院', '医院等级', '科室', '职称', '邮箱','注册时间', '学员等级', '是否电话', '大区经理', '代表', '代表手机']];
        //基础数组的元素个数
        $baseArrNum = count($cellData[0]);
        //占位数组
        $tmparr = [];
        foreach ($courses as $course) {
            $cellData[0][] = $course->title.'(学习时长/min)';
            $cellData[0][] = $course->title.'(点击次数/次)';
        }
        $cellData[0][] = '必修课学习时长/min';
        $cellData[0][] = '选修课学习时长/min';
        $cellData[0][] = '理论课总时长/min';
        $cellData[0][] = '答疑课学习时长/min';
        $cellData[0][] = '学习总时长/min';
        $cellData[0][] = '理论课点击数';
        $cellData[0][] = '答疑课点击数';
        $cellData[0][] = '总点击数';
        //课程的总数
        $course_num = count($course_id);
        for ($i=0;$i<8+$course_num*2;$i++){
            $tmparr[] = '';//每节课两列 + 最后总的统计的8列
        }

        //dd($cellData);
        $doctors = Db::table('doctors')
            ->join('hospitals','doctors.hospital_id','=','hospitals.id')
            ->leftjoin('kzkt_classes','doctors.id','=','kzkt_classes.doctor_id')
            ->leftjoin('volunteers','kzkt_classes.volunteer_id','=','volunteers.id')
            ->leftjoin('represent_info as r','volunteers.number','=','r.initial')
            ->select('doctors.id','doctors.hospital_id','doctors.name as dname','doctors.phone as dp','doctors.email','doctors.created_at','doctors.office','doctors.title','doctors.rank','hospitals.hospital','hospitals.hospital_level','hospitals.province','hospitals.city','hospitals.country','volunteers.name','volunteers.phone','kzkt_classes.style','r.belong_area','r.belong_dbm')->get();
        //dd($doctors);
        foreach ($doctors as $doctor) {
            //dd($doctor);
            $item = [
                $doctor->id,
                ' '.$doctor->dp,
                $doctor->dname,
                $doctor->belong_area,
                $doctor->province,
                $doctor->city,
                $doctor->country,
                $doctor->hospital,
                $doctor->hospital_level,
                $doctor->office,
                $doctor->title,
                $doctor->email,
                $doctor->created_at,
                $doctor->rank,
                $doctor->style && in_array('phone',explode(',',$doctor->style)) ?'是':'否',
                $doctor->belong_dbm,
                $doctor->name,
                ' '.$doctor->phone,

            ];
            $item = array_merge($item,$tmparr);
            //dd($item);
            //统计必修课观看时长、选修课时长、答疑课时长、总学习时长、理论课点击次数、答疑课点击次数
            $rq_course = $op_course = $aq_course = $total = $th_click = $aq_click = 0;
            //学员观看课程次数
            $play_log = DB::table('study_logs')->select('course_id',DB::raw('sum(study_duration) as study_time,count(1) as study_num'))->where(['doctor_id'=>$doctor->id])->groupBy('doctor_id','course_id')->get();
            //dd($play_log);
            //如果存在观看记录，写入表中
            foreach ($play_log as $play){
                $lac = array_search($play->course_id,$course_id);
                if($lac!==false){
                    $item[$baseArrNum+$lac*2] = sprintf('%0.2f',$play->study_time);
                    $item[$baseArrNum+1+$lac*2] = $play->study_num;
                    //公开课
                    if($courses[$lac]->course_class_id==4){
                        //必修课
                        if($courses[$lac]->course_type==1){
                            //必修课观看时长
                            $rq_course += $play->study_time;
                        }elseif($courses[$lac]->course_type==1){
                            //选修课观看时长
                            $op_course += $play->study_time;
                        }
                        //理论课点击次数
                        $th_click += $play->study_num;

                    }elseif($courses[$lac]->course_class_id==2){//答疑课
                        $aq_course += $play->study_time;
                        $aq_click += $play->study_num;
                    }
                }
            }

            //dd($tmp);
            $item[$baseArrNum+$course_num*2] = sprintf('%0.2f',$rq_course/60);//必修课时长
            $item[$baseArrNum+1+$course_num*2] = sprintf('%0.2f',$op_course/60);//选修课时长
            $item[$baseArrNum+2+$course_num*2] = sprintf('%0.2f',($op_course+$rq_course)/60);//理论课时长
            $item[$baseArrNum+3+$course_num*2] = sprintf('%0.2f',$aq_course);//答疑课时长
            $item[$baseArrNum+4+$course_num*2] = sprintf('%0.2f',($aq_course+$op_course+$rq_course)/60);//学习总时长
            $item[$baseArrNum+5+$course_num*2] = $th_click;//理论课点击次数
            $item[$baseArrNum+6+$course_num*2] = $aq_click;//答疑课点击次数
            $item[$baseArrNum+7+$course_num*2] = $aq_click + $th_click;//总点击次数
            array_push($cellData, $item);
            //dd($cellData);

        }
        \Excel::create('学员学习记录'.date('Y-m-d'), function ($excel) use ($cellData) {
            $excel->sheet(date('Y-m-d'), function ($sheet) use ($cellData) {
                $sheet->rows($cellData);
            });
        })->export('xls');

        return redirect('/admin/student');
    }

    function exportPhone()
    {
        $students = Student::all();
        $array = [];
        foreach ($students as $student) {
            array_push($array, $student->phone);
        }
        dd(json_encode($array));
    }
}
