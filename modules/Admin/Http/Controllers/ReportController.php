<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\CourseClass;
use App\Models\Doctor;
use App\Models\Hospital;
use App\Models\StudyLog;
use Illuminate\Http\Request;
use Excel;
use App\Http\Requests;
use Modules\OpenClass\Entities\ThyroidClassCourse;

class ReportController extends Controller
{
    public function index(){

        return view('admin::backend.report.index');
    }

    public function export2ExcelByProvince(){
        $site_id = 2; // 站点id
        $public_class_id = 4; // 公开课id
        $answer_class_id = 2; // 答疑课id
        $data[] = ['省份','学员总数','总时长', '答疑课', '理论课', '点击量', '等级一', '等级二', '等级三'];
        $course_lists = [];
        // 课程类别
        $course_categories = CourseClass::where(['site_id' => $site_id, 'status' => 1])->get();
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

        $hospital_groups = Hospital::groupBy('province')->get();
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
                foreach ($hospital_doctors as $hospital_doctor){
                    // 等级统计
                    $doctor_level[$hospital_doctor->rank]++;
                    // 时长统计
                    foreach ($course_lists as $course_list){
                        $study = StudyLog::whereIn('course_id', $course_list['course_ids'])
                            ->where(['site_id' => $site_id, 'doctor_id' => $hospital_doctor->id])
                            ->get();
                        if($course_list['id'] == $public_class_id){
                            $study_duration['public'] += $study->sum('study_duration');
                        }else if($course_list['id'] == $answer_class_id){
                            $study_duration['answer'] += $study->sum('study_duration');
                        }

                        $click_num += $study->count();

                    }
                }
//                dd($study);
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
        }

        Excel::create(date('Y-m-d') . '导出报表',function($excel) use ($data){
            $excel->sheet('score', function($sheet) use ($data){
                $sheet->rows($data);
            });
        })->export('xlsx');

        return 'hah';
    }

    public function export2ExcelDoctorInfo(){

    }

}
