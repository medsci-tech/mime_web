<?php namespace Modules\Airclass\Http\Controllers;

use App\Models\StudyLog;
use App\Models\ThyroidClass;

class StudyLogController extends Controller
{

    /**
     * 注册用户学习详细记录
     * @param String $url  用户来源
     * @return String
     * @author  lxhui
     */
	public function storeSelf(Request $request)
	{
        $rules = [
            'course_id'=>'required',
        ];
        $message = [
            'course_id.required'=>'课程id不能为空!',
        ];
        $validator = \Validator::make($request->all(),$rules,$message);
        echo $messages->first('email');
        $response = [
            'status_code' => 200,
            'message' =>  $messages.$request->openid,
        ];
        $messages = $validator->errors();
        /* 输出错误消息 */
        foreach ($messages->get('phone') as $message) {
            return ['status_code' => 0,'message' =>$message];
        }
        foreach ($messages->get('code') as $message) {
            //return ['status_code' => 0,'message' =>$message];
        }


	}
	
}

