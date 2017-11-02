<?php

namespace App\Http\Requests\Interfaces;

use App\Http\Requests\Request;
use App\Models\Doctor;
use App\Models\StudyLog;
use App\Models\KZKTClass;
use App\Models\Volunteer;
use Carbon\Carbon;
use Modules\Admin\Entities\ThyroidClassCourse;

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
    protected $setup_time_need = 0; // 晋升需要的课时

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
        $this->doctor_user = Doctor::where('id', $params['id'])->firstOrFail();
        return $this->doctor_user ;
    }

    /**
     * @description 等级一：学员报名成功后即为等级一级别，可学习任意所有必修课；
     * （旧规则）等级二：学员学习所有必修课程且每节课学习时长均>=10分钟后，进度到达等级二；
     * 等级二：学习总时长累计180分钟达到二级学员
     * (旧规则)等级三：在等级二的基础上，学完所有的选修课，且每节课学习时长>=10分钟，升级至等级三；
     * 等级三：选修课累计达到190分钟成为3级学员
     * @author      lxhui<772932587@qq.com>
     * @since 1.0
     * @return array
     */
    public function setRank(array $params)
    {
        if(!isset($params['id']))
        {
            $this->rank=0;
            $this->setup_time_need = config('params')['up_to_second'];
            return $this;
        }

        if($this->getUser($params)->rank)
        {
            if($this->getUser($params)->rank==1)
            {
                $lists = StudyLog::setUserRank(['course_type'=>1,'site_id'=>$this->site_id,'id'=>$params['id']]);
                $course_count= $lists['course_type_count'];//公开课下必修课的总集数
                unset($lists['course_type_count']);
                // 如果必修课每期课件学习时长≥10分钟,赠送积分begin
                if($lists)
                {
                    foreach($lists as $val)
                    {
                        $key = "user:".$params['id'].':course_id:'.$val['course_id'];
                        if(!\Redis::exists($key)){
                            try{
                                //赠送迈豆积分
                                $post_data = array('phone'=> $params['phone'],'bean'=>config('params')['bean_rules']['required_course']);
                                $this->getUser($params)->increment('credit', $post_data['bean']);
//                                $response = \Helper::tocurl(env('MD_USER_API_URL'). '/v2/modify-bean', $post_data,1);
//                                if(array_key_exists('status', $response))// 服务器返回响应状态码,当电话存在时
                                    \Redis::set($key,$post_data['bean']);
                            }
                            catch (\Exception $e){
                                $this->rank =$this->getUser($params)->rank;
                            }
                        }
                    }

                }
                /* 如果必修课每期课件学习时长≥10分钟,赠送积分end */
                //if(count($lists)>=config('params')['study_level']['course_public_min'])
                //总学习时长
                $courses = ThyroidClassCourse::where(['course_type'=>1,'is_show'=>1,'course_class_id'=>4])->get()->toArray(); //  课程类型: 1.必修课
                $course_type_arr = $courses ?  array_column($courses, 'id') : [];
                $study_time = \DB::table('study_logs')
                    ->where(['site_id'=>$this->site_id,'doctor_id'=>$params['id']])
                    ->whereIn('course_id',$course_type_arr)
                    ->sum('study_duration');

                //学习总时长累计180分钟达到二级学员
                if($study_time/60 >= config('params')['up_to_second'])
                {
                    try{
                        //赠送迈豆积分
                        $post_data = config('params')['bean_rules']['rank_level'];
                        //限时活动 ：
                        //1.学员晋升后，获得1000迈豆（已升级的不管，每晋升一次给1000）
                        //2.学员晋升后，相应的代表获得迈豆（已升级的不管，晋升合格500，晋升优秀300)
                        if(Carbon::createFromDate(2017,11,30)->gte(Carbon::now())){
                            $post_data = 1000;
                            //代表获取迈豆
                            $volunteer = KZKTClass::where('doctor_id',$params['id'])->first()->volunteer;
                            if($volunteer){
                                Volunteer::where('id',$volunteer->id)->increment('credit',500);
                            }
                        }
                        //$response = \Helper::tocurl(env('MD_USER_API_URL'). '/v2/modify-bean', $post_data,1);
                        $this->getUser($params)->increment('credit', $post_data, array('rank' => 2));
                        //Doctor::where('id', $params['id'])->update(['rank' => 2]); // 升级为二级
                        $this->rank =2;
//                        if(array_key_exists('status', $response))// 服务器返回响应状态码,当电话存在时
//                        {
//                            Doctor::where('id', $params['id'])->update(['rank' => 2]); // 升级为二级
//                            $this->rank =2;
//                        }
                    }
                    catch (\Exception $e){
                        $this->rank =$this->getUser($params)->rank;
                    }
                }
                else{
                    $this->setup_time_need = config('params')['up_to_second']-intval($study_time/60);
                    $this->rank =1;
                }

            }
            if($this->getUser($params)->rank==2)
            {
                /* 验证等级三 */
                //$lists = StudyLog::setUserRank(['course_type'=>2,'site_id'=>$this->site_id,'id'=>$params['id']]);
                /*$course_count = $lists['course_type_count'];
                unset($lists['course_type_count']);*/

                $courses = ThyroidClassCourse::where(['course_type'=>2,'is_show'=>1,'course_class_id'=>4])->get()->toArray(); //  课程类型: 2.选修课
                $course_type_arr = $courses ?  array_column($courses, 'id') : [];
                //选修课学习总时长
                $study_time = \DB::table('study_logs')
                    ->where(['site_id'=>$this->site_id,'doctor_id'=>$params['id']])
                    ->whereIn('course_id',$course_type_arr)
                    ->sum('study_duration');

                //选修课累计达到190分钟成为3级学员
                if($study_time/60 >= config('params')['up_to_third'])
                {
                    try
                    {
                        //赠送迈豆积分
                        $post_data = config('params')['bean_rules']['rank_level'];
                        //限时活动 ：
                        //1.学员晋升后，获得1000迈豆（已升级的不管，每晋升一次给1000）
                        //2.学员晋升后，相应的代表获得迈豆（已升级的不管，晋升合格500，晋升优秀300)
                        if(Carbon::createFromDate(2017,11,30)->gte(Carbon::now())){
                            $post_data = 1000;
                            //代表获取迈豆
                            $volunteer = KZKTClass::where('doctor_id',$params['id'])->first()->volunteer;
                            if($volunteer){
                                Volunteer::where('id',$volunteer->id)->increment('credit',300);
                            }
                        }
                        $this->getUser($params)->increment('credit', $post_data, array('rank' => 3));
                        $this->rank =3;
//                        $response = \Helper::tocurl(env('MD_USER_API_URL'). '/v2/modify-bean', $post_data,1);
//                        if(array_key_exists('status', $response))// 服务器返回响应状态码,当电话存在时
//                        {
//                            Doctor::where('id', $params['id'])->update(['rank' => 3]); // 升级为三级
//                            $this->rank =3;
//                        }
                    } catch (\Exception $e){
                        $this->rank =$this->getUser($params)->rank;
                    }
                }
                else{
                    $this->setup_time_need = config('params')['up_to_third']-intval($study_time/60);
                    $this->rank =2;
                }
            }
            if($this->getUser($params)->rank==3){
                $this->rank = 3;
            }
        }
        else
            $this->rank =0; // 未报名

        return $this;
    }


}