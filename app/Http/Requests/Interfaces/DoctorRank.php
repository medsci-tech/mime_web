<?php

namespace App\Http\Requests\Interfaces;

use App\Http\Requests\Request;
use App\Models\{Doctor,StudyLog};
use Modules\AirClass\Entities\ThyroidClassCourse;
/**
 * Class DoctorRank
 * @package App\Http\Requests\Interfaces
 * @mixin Request
 */
trait DoctorRank
{
    /**
     * @var array
     */
    protected $doctor_user;
    protected $rank;
    protected $site_id = 2; // airClass site_id

    /**
     * @description 用户信息
     * @author      lxhui<772932587@qq.com>
     * @since 1.0
     * @return array
     */
    public function getUser(array $params)
    {
        if(!isset($params['id']))
            return false;
        $this->doctor_user = doctor::where('id', $params['id'])->firstOrFail();
        return $this->doctor_user ;
    }

    /**
     * @description 等级一：学员报名成功后即为等级一级别，可学习任意所有必修课；
     * 等级二：学员学习20节必修课程且每节课学习时长均>=10分钟后，进度到达等级二；
     * 等级三：在等级二的基础上，学完所有的选修课，且每节课学习时长>=10分钟，升级至等级三；
     * @author      lxhui<772932587@qq.com>
     * @since 1.0
     * @return array
     */
    public function setRank(array $params)
    {
        if(!isset($params['id']))
            return false;

        if($this->getUser($params)->rank)
        {
            if($this->getUser($params)->rank==1)
            {
                $courses = ThyroidClassCourse::where(['course_type'=>1,'is_show'=>1])->get()->toArray(); //  课程类型: 1必修课:
                $course_type_1 = $courses ?  array_column($courses, 'id') : [];
                /* 验证等级二 */
                $lists = \DB::table('study_logs')
                    ->select(\DB::raw('sum(study_duration) as study_total, course_id,doctor_id'))
                    ->where(['site_id'=>$this->site_id,'doctor_id'=>$params['id']])
                    ->whereIn('course_id',$course_type_1)
                    ->groupBy('course_id')
                    ->having('study_total', '>', config('params')['study_level']['course_duration'])
                    ->get();
                if(count($lists)>=config('params')['study_level']['course_public_min'])
                {
                    Doctor::where('id', $params['id'])->update(['rank' => 2]); // 升级为二级
                    $this->rank =2;
                }
                else
                    $this->rank =1;

            }
            if($this->getUser($params)->rank==2)
            {
                $courses = ThyroidClassCourse::where(['course_type'=>2,'is_show'=>1])->get()->toArray(); //  课程类型:2:选修课
                $course_type_2 = $courses ?  array_column($courses, 'id') : [];
                /* 验证等级三 */
                $lists = \DB::table('study_logs')
                    ->select(\DB::raw('sum(study_duration) as study_total, course_id,doctor_id'))
                    ->where(['site_id'=>$this->site_id,'doctor_id'=>$params['id']])
                    ->whereIn('course_id',$course_type_2)
                    ->groupBy('course_id')
                    ->having('study_total', '>', config('params')['study_level']['course_duration'])
                    ->get();
                if(count($lists)==count($course_type_2))
                {
                    Doctor::where('id', $params['id'])->update(['rank' => 3]); // 升级为三级
                    $this->rank =3;
                }
                else
                    $this->rank =2;
            }
        }
        else
            return $this->rank =0; // 未报名

        return $this;
    }

}