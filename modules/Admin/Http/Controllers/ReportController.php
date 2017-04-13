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
    protected $export_sign_info = 100; // 每页条数
    protected $public_class_id = 4; // 公开课id
    protected $answer_class_id = 2; // 答疑课id

    public function index(){

        $sign_info_counts = KZKTClass::where(['site_id' => $this->site_id, 'status' => 1])->count();
        return view('admin::backend.report.index', [
            'sign_info_page' => ceil($sign_info_counts / $this->export_sign_info),
        ]);
    }

    public function course_category(){
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
        return $course_lists;
    }

    public function export2ExcelByProvince(){
        set_time_limit(0);
        $data[] = ['省份','学员总数','总时长', '答疑课', '理论课', '点击量', '等级一', '等级二', '等级三'];
        $course_lists = $this->course_category();
//        dd($course_lists);

        $hospital_groups = Hospital::groupBy('province')->get();
//        dd($hospital_groups);
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
                if($province_hospital){
                    $hospital_doctors = Doctor::where('hospital_id',$province_hospital->id)->get();
                    $doctor_total += $hospital_doctors->count();
//                dd($hospital_doctors);
                    var_dump($province_hospital->id);
                    foreach ($hospital_doctors as $hospital_doctor){
                        if($hospital_doctor){
                            // 等级统计
                            if($hospital_doctor->rank > 0){
                                $doctor_level[$hospital_doctor->rank]++;
                            }
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
//            dd($data);
        }
//dd($data);
        Excel::create(date('Y-m-d') . '导出报表',function($excel) use ($data){
            $excel->sheet('Sheet1', function($sheet) use ($data){
                $sheet->rows($data);
            });
        })->export('xlsx');

    }

    public function export2ExcelDoctorInfo(){
        set_time_limit(0);
        $data = [[
            '手机号', '学员姓名', '大区', '省', '市', '县', '医院', '医院等级', '科室', '职称','邮箱',
            '是否电话外呼', '大区经理', '代表', '代表手机号',
            '总时长', '答疑课时长', '理论课时长', '点击总数', '答疑课点击数','理论课点击数',
        ]];
        $course_lists = $this->course_category();

        $sign_info = KZKTClass::where(['site_id' => $this->site_id, 'status' => 1])
            ->paginate($this->export_sign_info);

        foreach ($sign_info as $key => $val){
            $data[$key + 1][] = $val->doctor->phone ?? '';
            $data[$key + 1][] = $val->doctor->name ?? '';
            $data[$key + 1][] = $val->volunteer->represent->belong_area ?? '';
            $data[$key + 1][] = $val->doctor->hospital->province ?? '';
            $data[$key + 1][] = $val->doctor->hospital->city ?? '';
            $data[$key + 1][] = $val->doctor->hospital->country ?? '';
            $data[$key + 1][] = $val->doctor->hospital->hospital ?? '';
            $data[$key + 1][] = $val->doctor->hospital->hospital_level ?? '';
            $data[$key + 1][] = $val->doctor->office ?? '';
            $data[$key + 1][] = $val->doctor->title ?? '';
            $data[$key + 1][] = $val->doctor->email;
            $data[$key + 1][] = $val->style == 'phone' ? '是' : '否';
            $data[$key + 1][] = $val->volunteer->represent->belong_dbm ?? '';
            $data[$key + 1][] = $val->volunteer->name ?? '';
            $data[$key + 1][] = $val->volunteer->phone ?? '';

            // 学习时长
            $study_duration = [
                'total' => 0,
                'public' => 0,
                'answer' => 0,
            ];
            // 点击量
            $click_num = [
                'total' => 0,
                'public' => 0,
                'answer' => 0,
            ];
            // 时长统计
            foreach ($course_lists as $course_list){
                $study = StudyLog::whereIn('course_id', $course_list['course_ids'])
                    ->where(['site_id' => $this->site_id, 'doctor_id' => $val->doctor->id])
                    ->get();
                if($course_list['id'] == $this->public_class_id){
                    $study_duration['public'] += $study->sum('study_duration');
                    $click_num['public'] = $study->count();
                }else if($course_list['id'] == $this->answer_class_id){
                    $study_duration['answer'] += $study->sum('study_duration');
                    $click_num['answer'] = $study->count();
                }
            }

            $study_duration['total'] = $study_duration['public'] + $study_duration['answer'];
            $data[$key + 1][] = $study_duration['total'];
            $data[$key + 1][] = $study_duration['answer'];
            $data[$key + 1][] = $study_duration['public'];
            $click_num['total'] = $click_num['public'] + $click_num['answer'];
            $data[$key + 1][] = $click_num['total'];
            $data[$key + 1][] = $click_num['answer'];
            $data[$key + 1][] = $click_num['public'];
        }
//        dd($data);
        Excel::create(date('Y-m-d') . '导出报表',function($excel) use ($data){
            $excel->sheet('Sheet1', function($sheet) use ($data){
                $sheet->rows($data);
            });
        })->export('xlsx');
    }

}
