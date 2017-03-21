<?php namespace Modules\AirClass\Http\Controllers;

use App\Models\StudyLog;
use App\Models\ThyroidClass;

class StudyLogController extends Controller
{

    public function __construct()
    {
        $this->middleware('login');
        parent::__construct();

    }
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
            'times'=>'required',
        ];
        $message = [
            'course_id.required'=>'课程id不能为空!',
            'times.required'=>'学习时长不能为空!',
        ];
        $validator = \Validator::make($request->all(),$rules,$message);
        $messages = $validator->errors();
        if ($messages->has('course_id'))
            return ['code' => 0,'message' =>$messages->first('course_id')];
        if ($messages->has('times'))
            return ['code' => 0,'message' =>$messages->first('times')];
        /* 记录用户时长 */
        $user = App\Post::find(1);
        $post->comments()->save($comment);





    }
	
}

