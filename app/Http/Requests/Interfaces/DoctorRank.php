<?php

namespace App\Http\Requests\Interfaces;

use App\Http\Requests\Request;
use App\Models\{Doctor,StudyLog};

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
     * 等级二：学员学习所有必修课程且每节课学习时长均>=10分钟后，进度到达等级二；
     * 等级三：在等级二的基础上，学完所有的选修课，且每节课学习时长>=10分钟，升级至等级三；
     * @author      lxhui<772932587@qq.com>
     * @since 1.0
     * @return array
     */
    public function setRank(array $params)
    {
        if(!isset($params['id']))
        {
            $this->rank=0;
            return $this;
        }

        if($this->getUser($params)->rank)
        {
            if($this->getUser($params)->rank==1)
            {
                $lists = StudyLog::setUserRank(['course_type'=>1,'site_id'=>$this->site_id,'id'=>$params['id']]);
                $course_count= $lists['course_type_count'];
                unset($lists['course_type_count']);
                /* 如果必修课每期课件学习时长≥10分钟,赠送积分begin */
                if($lists)
                {
                    foreach($lists as $val)
                    {
                        $key = "user:".$params['id'].':course_id:'.$val['course_id'];
                        if(!\Redis::exists($key)){
                            try{
                                //赠送迈豆积分
                                $post_data = array('phone'=> $params['phone'],'bean'=>config('params')['bean_rules']['required_course']);
                                $response = \Helper::tocurl(env('MD_USER_API_URL'). '/v2/modify-bean', $post_data,1);
                                if(array_key_exists('status', $response))// 服务器返回响应状态码,当电话存在时
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
                if(count($lists)==$course_count)
                {
                    try{
                        //赠送迈豆积分
                        $post_data = array('phone'=> $params['phone'],'bean'=>config('params')['bean_rules']['rank_level']);
                        $response = \Helper::tocurl(env('MD_USER_API_URL'). '/v2/modify-bean', $post_data,1);
                        if(array_key_exists('status', $response))// 服务器返回响应状态码,当电话存在时
                        {
                            Doctor::where('id', $params['id'])->update(['rank' => 2]); // 升级为二级
                            $this->rank =2;
                        }
                    }
                    catch (\Exception $e){
                        $this->rank =$this->getUser($params)->rank;
                    }
                }
                else
                    $this->rank =1;
            }
            if($this->getUser($params)->rank==2)
            {
                /* 验证等级三 */
                $lists = StudyLog::setUserRank(['course_type'=>2,'site_id'=>$this->site_id,'id'=>$params['id']]);
                $course_count = $lists['course_type_count'];
                unset($lists['course_type_count']);
                if(count($lists)==$course_count)
                {
                    try
                    {
                        //赠送迈豆积分
                        $post_data = array('phone'=> $params['phone'],'bean'=>config('params')['bean_rules']['rank_level']);
                        $response = \Helper::tocurl(env('MD_USER_API_URL'). '/v2/modify-bean', $post_data,1);
                        if(array_key_exists('status', $response))// 服务器返回响应状态码,当电话存在时
                        {
                            Doctor::where('id', $params['id'])->update(['rank' => 3]); // 升级为三级
                            $this->rank =3;
                        }
                    } catch (\Exception $e){
                        $this->rank =$this->getUser($params)->rank;
                    }
                }
                else
                    $this->rank =2;
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