<?php

namespace App\Models;
use Modules\AirClass\Entities\ThyroidClassCourse;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Banner
 * @package App\Models
 * @mixin \Eloquent
 */
class StudyLog extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'course_id',
        'doctor_id',
        'created_at',
        'updated_at',
        'site_id',
        'study_duration',
        'video_duration',
        'progress',
    ];

    /**
     * @description 用户等级
     * @author      lxhui<772932587@qq.com>
     * @since 1.0
     * @return array
     */
    public static  function setUserRank(array $params)
    {
        if(!isset($params['course_type']) || !isset($params['id']))
            return false;

        $courses = ThyroidClassCourse::where(['course_type'=>$params['course_type'],'is_show'=>1])->get()->toArray(); //  课程类型: 1必修课:
        $course_type_arr = $courses ?  array_column($courses, 'id') : [];
        /* 验证等级 */
        $lists = \DB::table('study_logs')
            ->select(\DB::raw('sum(study_duration) as study_total, course_id,doctor_id'))
            ->where(['site_id'=>$params['site_id'],'doctor_id'=>$params['id']])
            ->whereIn('course_id',$course_type_arr)
            ->groupBy('course_id')
            ->having('study_total', '>', config('params')['study_level']['course_duration'])
            ->get();
        $lists = json_decode(json_encode($lists),true);
        $lists['course_type_count']= count($course_type_arr);
        return $lists;
    }


    /**
     * @description 答疑课统计
     * @author      lxhui<772932587@qq.com>
     * @since 1.0
     * @return array
     */
    public static  function getUserAnswer(array $params)
    {
        if(!isset($params['course_class_id']) || !isset($params['id']))
            return false;

        $courses = ThyroidClassCourse::where(['course_class_id'=>$params['course_class_id'],'is_show'=>1])->get()->toArray();
        $course_type_arr = $courses ?  array_column($courses, 'id') : [];
        $lists = \DB::table('study_logs')
            ->select(\DB::raw('sum(study_duration) as study_total, course_id,doctor_id'))
            ->where(['site_id'=>$params['site_id'],'doctor_id'=>$params['id']])
            ->whereIn('course_id',$course_type_arr)
            ->groupBy('course_id')
            ->having('study_total', '>', config('params')['study_level']['course_duration'])
            ->get();
        $lists = json_decode(json_encode($lists ? $lists : []),true);
        return $lists;
    }


}
