<?php namespace Modules\Airclass\Http\Controllers;

use App\Models\Comment;
use Modules\Admin\Entities\ThyroidClassCourse;
use Session;

class VideoController extends Controller
{
	protected $user = null;
	public function __construct()
	{
		$user = Session::get($this->student_login_session_key);
		if($user){
			$this->user = $user;
		}
	}

	/**
	 * @param $id
	 */
	public function index($id)
	{
		$class = ThyroidClassCourse::where(['site_id' => $this->site_id, 'is_show' => 1, 'id' => $id])->first();
		if($class){
			// 评论
			$comments = [];
			// 一级评论
			$one_comments = Comment::where(['status' => 1, 'class_id' => $class->id, 'parent_id' => 0])->get();
			if($one_comments){
				foreach ($one_comments as $key => $one_comment){
					$comments[$key] = [
						'id' => $one_comment->id,
						'class_id' => $one_comment->class_id,
						'parent_id' => $one_comment->parent_id,
						'from_id' => $one_comment->from_id,
						'from_name' => $one_comment->from_name,
						'to_id' => $one_comment->to_id,
						'to_name' => $one_comment->to_name,
						'content' => $one_comment->content,
					];
					// 一级评论
					$two_comments = Comment::where(['status' => 1, 'class_id' => $class->id, 'parent_id' => $one_comment->id])->get();
					if($two_comments){
						foreach ($two_comments as $k => $two_comment){
							$comments[$key]['child'][$k] = [
								'id' => $two_comment->id,
								'class_id' => $two_comment->class_id,
								'parent_id' => $two_comment->parent_id,
								'from_id' => $two_comment->from_id,
								'from_name' => $two_comment->from_name,
								'to_id' => $two_comment->to_id,
								'to_name' => $two_comment->to_name,
								'content' => $two_comment->content,
							];
						}
					}
				}
			}
			dd($comments);
			$user = $this->user;
			// 查询用户是否登陆
			if($user){
				// 查询用户是否报名  调接口

			}else{
				dd('no login');
			}
			dd($class);
		}else{
			abort(404);
		}
	}


	
}

