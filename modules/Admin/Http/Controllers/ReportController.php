<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\CourseClass;
use App\Models\Doctor;
use App\Models\Hospital;
use App\Models\KZKTClass;
use App\Models\StudyLog;
use Illuminate\Http\Request;
use Excel;
use App\Http\Requests;
use Modules\OpenClass\Entities\ThyroidClassCourse;

class ReportController extends Controller
{
    protected $site_id = 2; // 站点id
    protected $export_sign_info = 10; // 每页条数
    protected $public_class_id = 4; // 公开课id
    protected $answer_class_id = 2; // 答疑课id

    public function index(){

        $sign_info_counts = KZKTClass::where(['site_id' => $this->site_id, 'status' => 1])->count();
        return view('admin::backend.report.index', [
            'sign_info_page' => ceil($sign_info_counts / $this->export_sign_info),
        ]);
    }

    public function export2ExcelByProvince(){
        set_time_limit(0);
        $data[] = ['省份','学员总数','总时长', '答疑课', '理论课', '点击量', '等级一', '等级二', '等级三'];
        $course_lists = [];
        // 课程类别
        $course_categories = CourseClass::where(['site_id' => $this->site_id, 'status' => 1])->get();
        foreach ($course_categories as $key => $course_category){
            $course_lists[$key]['course_ids'] = [];
            $courses = ThyroidClassCourse::where(['is_show' => 1,'course_class_id' => $course_category->id])
                ->get();
            foreach ($courses as $k => $course){
                $course_lists[$key]['course_ids'][$k] = $course->id;
            }
            $course_lists[$key]['name'] = $course_category->name;
            $course_lists[$key]['id'] = $course_category->id;
        }
//        dd($course_lists);

        $hospital_groups = Hospital::groupBy('province')->get();
        dd($hospital_groups);
        foreach ($hospital_groups as $key => $hospital_group){
            $doctor_total = 0; // 医生总数
            // 医生等级
            $doctor_level = [
                1 => 0,
                2 => 0,
                3 => 0,
            ];
            // 学习时长
            $study_duration = [
                'total' => 0,
                'public' => 0,
                'answer' => 0,
            ];
            // 点击量
            $click_num = 0;
            $province_hospitals = Hospital::where('province', $hospital_group->province)->get();
            foreach ($province_hospitals as $province_hospital){
                $hospital_doctors = Doctor::where('hospital_id',$province_hospital->id)->get();
                $doctor_total += $hospital_doctors->count();
//                dd($hospital_doctors);
                foreach ($hospital_doctors as $hospital_doctor){
                    // 等级统计
                    $doctor_level[$hospital_doctor->rank]++;
                    // 时长统计
                    foreach ($course_lists as $course_list){
                        $study = StudyLog::whereIn('course_id', $course_list['course_ids'])
                            ->where(['site_id' => $this->site_id, 'doctor_id' => $hospital_doctor->id])
                            ->get();
                        if($course_list['id'] == $this->public_class_id){
                            $study_duration['public'] += $study->sum('study_duration');
                        }else if($course_list['id'] == $this->answer_class_id){
                            $study_duration['answer'] += $study->sum('study_duration');
                        }

                        $click_num += $study->count();

                    }
                }
            }

            $study_duration['total'] = $study_duration['public'] + $study_duration['answer'];

            $data[$key + 1][] = $hospital_group->province;
            $data[$key + 1][] = $doctor_total;
            $data[$key + 1][] = $study_duration['total'];
            $data[$key + 1][] = $study_duration['answer'];
            $data[$key + 1][] = $study_duration['public'];
            $data[$key + 1][] = $click_num;
            $data[$key + 1][] = $doctor_level[1];
            $data[$key + 1][] = $doctor_level[2];
            $data[$key + 1][] = $doctor_level[3];
            dd($data);
        }
dd($data);
        Excel::create(date('Y-m-d') . '导出报表',function($excel) use ($data){
            $excel->sheet('Sheet1', function($sheet) use ($data){
                $sheet->rows($data);
            });
        })->export('xlsx');

    }

    public function export2ExcelDoctorInfo(){
        $sign_info = KZKTClass::where(['site_id' => $this->site_id, 'status' => 1])->paginate($this->export_sign_info);
        foreach ($sign_info as $val){
            dd($val);
        }
        dd($sign_info);
    }

}
