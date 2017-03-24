<?php

namespace App\Http\Requests\Interfaces;

use App\Http\Requests\Request;
use App\Models\{Doctor,StudyLog};

/**
 * Class DoctorRank
 * @package App\Http\Requests\Interfaces
 * @mixin Request
 */
trait DoctorBean
{
    /**
     * @var array
     */
    protected $bean;
    protected $site_id = 2; // airClass site_id

    /**
     * @description 获取用户的积分迈豆
     * @author      lxhui<772932587@qq.com>
     * @since 1.0
     * @return array
     */
    public function getBean(array $params)
    {
        if(!isset($params['id']) || !isset($params['phone']))
            return false;
        $response = \Helper::tocurl(env('MD_USER_API_URL'). '/v2/query-user-information?phone='.$params['phone'], null,0);

        if($response['httpCode']==200)// 服务器返回响应状态码,当电话存在时
        {
           // dd($response['result']['bean']['number']);

        }


    }

    /**
     * @description 答疑课每期课件学习时长≥ 10分钟,30积分
     * @author      lxhui<772932587@qq.com>
     * @since 1.0
     * @return array
     */
    public function setBean(array $params)
    {
        if(!isset($params['id']))
            return false;

        $lists = StudyLog::getUserAnswer(['course_class_id'=>2,'site_id'=>$this->site_id,'id'=>$params['id']]);
        if($lists)
        {
            foreach($lists as $val)
            {
                $key = "user:".$params['id'].':course_id:'.$val['course_id'];
                if(!\Redis::exists($key)){
                    try{
                        /* 如果答疑课每期课件学习时长≥10分钟,赠送积分end */
                        $post_data = array('phone'=> $params['phone'],'bean'=>config('params')['bean_rules']['answer_course']);
                        $response = \Helper::tocurl(env('MD_USER_API_URL'). '/v2/modify-bean', $post_data,1);
                        if($response['httpCode']==200)// 服务器返回响应状态码,当电话存在时
                            \Redis::set($key,$post_data['bean']);
                    }
                    catch (\Exception $e){
                        return false;
                    }
                }
            }

        }
        return true;
    }

}