<?php namespace Modules\Airclass\Http\Controllers;

use App\Models\AnswerLog;
use App\Models\Comment;
use Illuminate\Http\Request;
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
		//## 当前课程信息
		$class = ThyroidClassCourse::where(['site_id' => $this->site_id, 'is_show' => 1, 'id' => $id])->first();
		if($class){
			//## 章节列表
			$chapter_classes = ThyroidClassCourse::where([
				'site_id' => $this->site_id,
				'is_show' => 1,
				'course_class_id' => $class->course_class_id,
				'thyroid_class_phase_id' => $class->thyroid_class_phase_id,
			])->orderBy('sequence')->get();
//			dd($chapter_classes);
			//## 评论
			$comments = [];
			// 一级评论
			$one_comments = Comment::where(['status' => 1, 'class_id' => $class->id, 'parent_id' => 0])->orderBy('id', 'desc')->get();
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
					// 二级评论
					$two_comments = Comment::where(['status' => 1, 'class_id' => $class->id, 'parent_id' => $one_comment->id])->orderBy('id', 'desc')->get();
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
//			dd($comments);
			//## 随机推荐课程
			// 当前相同类别推荐
			$recommend_class_num = 4; // 推荐课程个数
			$add_recommend_classes = null; // 追加推荐课程
			$recommend_classes = ThyroidClassCourse::where([
				'site_id' => $this->site_id,
				'is_show' => 1,
				'course_class_id' => $class->course_class_id,
				['thyroid_class_phase_id', '>', $class->thyroid_class_phase_id],
			])->orderBy('sequence')->limit($recommend_class_num)->get();
			$recommend_class_count = $recommend_classes->count();
			// 如果下个单元推荐课程少于4个，则追加其他分类课程
			if($recommend_class_count < $recommend_class_num){
				$add_recommend_classes = ThyroidClassCourse::where([
					'site_id' => $this->site_id,
					'is_show' => 1,
					['course_class_id', '>', $class->course_class_id],
				])->orderBy('sequence')->limit($recommend_class_num - $recommend_class_count)->get();
			}
//			dd($add_recommend_classes);
			$user = $this->user;
			// 查询用户是否登陆
			if($user){
				// 查询用户是否报名  调接口
				// 如果已答题，显示答题信息和解析，未答题，显示题目

			}else{
				dd('no login');
			}
			dd($class);
			return view('airclass::video.index',[
				'class' => $class, // 当前课程信息
				'chapter_classes' => $chapter_classes, // 相关章节列表
				'comments' => $comments, // 评论列表
				'recommend_classes' => $recommend_classes, // 推荐课程列表
				'add_recommend_classes' => $add_recommend_classes, // 追加推荐课程列表
				'user' => $user, // 登陆用户信息
			]);
		}else{
			abort(404);
			return false;
		}
	}

	// 评论
	public function comment(Request $request){
		$request_data = $request->all();
		$result = Comment::create($request_data);
		if($result){
			return $this->return_data_format(200);
		}else{
			return $this->return_data_format(500);
		}
	}

	// 答题
	public function answer(Request $request){
		$request_data = $request->all();
		dd($request_data);
		$save_data = [
			'',
		];
		$result = AnswerLog::create($save_data);
		if($result){
			return $this->return_data_format(200);
		}else{
			return $this->return_data_format(500);
		}
	}


	
}

