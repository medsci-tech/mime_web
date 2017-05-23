<?php

namespace App\Http\Requests\Interfaces;

use App\Http\Requests\Request;
use App\Models\{Doctor,StudyLog};
use PhpParser\Comment\Doc;

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
    protected $user;
    protected $site_id = 2; // airClass site_id
    protected $user_login_session_key = 'user_login_session_key'; // 用户登录session key

    /**
     * @description 获取用户的积分迈豆
     * @author      lxhui<772932587@qq.com>
     * @since 1.0
     * @return array
     */
    public function getBean(array $params)
    {
        if(!isset($params['id']) || !isset($params['phone']))
            $this->bean = 0;
        try
        {
            $this->user = \Session::get($this->user_login_session_key);
            $this->bean = isset($this->user['credit']) ? $this->user['credit']: 0;
//            $response = \Helper::tocurl(env('MD_USER_API_URL'). '/v2/query-user-information?phone='.$params['phone'], null,0);
//            if($response['httpCode']==200)// 服务器返回响应状态码,当电话存在时
//                $this->bean = isset($response['result']['bean']['number']) ? $response['result']['bean']['number'] : 0;
        }
        catch (\Exception $e){
            $this->bean = 0;
        }

        return $this;

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

        $this->user = \Session::get($this->user_login_session_key);
        $lists = StudyLog::getUserAnswer(['course_class_id'=>2,'site_id'=>$this->site_id,'id'=>$params['id']]);
        if($lists)
        {
            foreach($lists as $val)
            {
                $key = "user:".$params['id'].':course_id:'.$val['course_id'];
                if(!\Redis::exists($key)){
                    try{
                        /* 如果答疑课每期课件学习时长≥10分钟,赠送积分 */
                        $post_data = array('phone'=> $params['phone'],'bean'=>config('params')['bean_rules']['answer_course']);
                        Doctor::find($this->user['id'])->increment('credit', $post_data['bean']);
//                        $response = \Helper::tocurl(env('MD_USER_API_URL'). '/v2/modify-bean', $post_data,1);
//                        if($response['httpCode']==200)// 服务器返回响应状态码,当电话存在时
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

    /**
     * @description 视频点击数,每节课点击可获得积分上限：4积分 ,即单节课最多加4次
     * @author      lxhui<772932587@qq.com>
     * @since 1.0
     * @return array
     */
    public function setVideoBean(array $params)
    {
        if(!isset($params['id']) || !isset($params['course_id']) || !isset($params['phone']))
            return false;
        $this->user = \Session::get($this->user_login_session_key);
        $key = "user:".$params['id'].':course_id:'.$params['course_id'].':video';

        if(\Redis::get($key)<=4) //积分上限：4次积分
        {
            try{
                /* 视频点击数,赠送积分 */
                $post_data = array('phone'=> $params['phone'],'bean'=>config('params')['bean_rules']['click_course']);
//                $response = \Helper::tocurl(env('MD_USER_API_URL'). '/v2/modify-bean', $post_data,1);
//                if($response['httpCode']==200)// 服务器返回响应状态码,当电话存在时
                Doctor::find($this->user['id'])->increment('credit', $post_data['bean']);
                    \Redis::incrBy($key, 1);
            }
            catch (\Exception $e){
                return false;
            }
        }

        return true;
    }

    /**
     * @description 提问问题,每节课提问问题可获得积分上限：20积分/次
     * @author      lxhui<772932587@qq.com>
     * @since 1.0
     * @return array
     */
    public function setQuestionBean(array $params)
    {
        if(!isset($params['id']) || !isset($params['course_id']) || !isset($params['phone']))
            return false;
        $this->user = \Session::get($this->user_login_session_key);
        $key = "user:".$params['id'].':course_id:'.$params['course_id'].':question';

        if(\Redis::get($key)<=2) //积分上限：2次积分
        {
            try{
                /* 视频点击数,赠送积分 */
                $post_data = array('phone'=> $params['phone'],'bean'=>config('params')['bean_rules']['ask_question_max']);
                Doctor::find($this->user['id'])->increment('credit', $post_data['bean']);
//                $response = \Helper::tocurl(env('MD_USER_API_URL'). '/v2/modify-bean', $post_data,1);
//                if($response['httpCode']==200)// 服务器返回响应状态码,当电话存在时
                    \Redis::incrBy($key, 1);
            }
            catch (\Exception $e){
                return false;
            }
        }

        return true;
    }

}