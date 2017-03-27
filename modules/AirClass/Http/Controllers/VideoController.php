<?php namespace Modules\AirClass\Http\Controllers;

use App\Models\AnswerLog;
use App\Models\Comment;
use App\Models\KZKTClass;
use App\Models\StudyLog;
use Illuminate\Http\Request;
use Modules\Admin\Entities\Exercise;
use Modules\Admin\Entities\ThyroidClassCourse;
use Modules\AirClass\Entities\ThyroidClassPhase;
use Session;
use App\Http\Requests\Interfaces\DoctorBean;
class VideoController extends Controller
{
    use DoctorBean;
	protected $user = null;
	protected $get_comment_every_time = 10; // 每次加载评论条数
	public function __construct()
	{
		$user = Session::get($this->user_login_session_key);
		if($user){
			$this->user = $user;
		}
	}

	/**
	 * @param $id
	 * @return bool
	 */
	public function index($id)
	{
		//## 当前课程信息
		$class = ThyroidClassCourse::where(['site_id' => $this->site_id, 'is_show' => 1, 'id' => $id])->first();
        if($class->course_type==2)//达到等级二才能看选修课
        {
            if($this->user['rank']<2)
                exit('<script>alert("请升级您的会员等级后观看哦!");history.back(-1);</script>');
        }
        $chapter = ThyroidClassPhase::where(['id'=>$class['thyroid_class_phase_id']])->first(); // 当前单元
		if($class){
			//## 章节列表
			if($chapter){
				$chapter_classes = ThyroidClassCourse::where([
					'site_id' => $this->site_id,
					'is_show' => 1,
					'course_class_id' => $class->course_class_id,
					'thyroid_class_phase_id' => $class->thyroid_class_phase_id,
				])->orderBy('sequence')->get();
			}else{
				$chapter_classes = ThyroidClassCourse::where([
					'site_id' => $this->site_id,
					'is_show' => 1,
					'id' => $id,
				])->orderBy('sequence')->get();
			}

			//## 评论
			$comments = [];
			// 一级评论
			$one_comments = Comment::where([
				'status' => 1,
				'class_id' => $class->id,
				'parent_id' => 0,
				'site_id' => $this->site_id,
			])->orderBy('id', 'asc')->paginate($this->get_comment_every_time);
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
						'created_at' => $one_comment->created_at,
						'child' => [],
					];
					// 二级评论
					$two_comments = Comment::where([
						'status' => 1,
						'class_id' => $class->id,
						'parent_id' => $one_comment->id,
						'site_id' => $this->site_id,
					])->orderBy('id', 'asc')->paginate($this->get_comment_every_time);
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
								'created_at' => $two_comment->created_at,
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
			//## 问题
			$questions  = Exercise::whereIn('id', explode(',', $class->exercise_ids))->get();
			//## 答题
			$answer_logs = [];
			//## 答题状态消息
			$answer_status_mag = '';
			//## 视频观看状态消息
			$video_status_mag = '';
			// 查询用户是否登陆
			if($user){
				// 查询用户是否报名
				$sing_up = KZKTClass::where('doctor_id', $user['id'])->first();
				if($sing_up){
					// 如果已答题，显示答题信息和解析，未答题，显示题目
					$answer_logs = AnswerLog::where([
						'user_id' => $user['id'],
						'site_id' => $this->site_id,
						'class_id' => $class->id,
					])->get();
					if($answer_logs){
						if ($answer_logs->count()){
							$answer_status_mag = '已答过题';
						}
					}
				}else{
					$answer_status_mag = '报名后才能答题';
					$video_status_mag = '报名后继续观看';
				}
			}else{
				$answer_status_mag = '登陆后才能答题';
				$video_status_mag = '登陆后继续观看';
			}

			return view('airclass::video.index',[
				'class' => $class, // 当前课程信息
                'chapter' => $chapter, // 当前单元信息
				'chapter_classes' => $chapter_classes, // 相关章节列表
				'comments' => $comments, // 评论列表
				'get_comment_num' => $this->get_comment_every_time, // 评论列表
				'recommend_classes' => $recommend_classes, // 推荐课程列表
				'add_recommend_classes' => $add_recommend_classes, // 追加推荐课程列表
				'user' => $user, // 登陆用户信息
				'questions' => $questions, // 问题信息
				'answer_logs' => $answer_logs, // 答题信息
				'answer_status_mag' => $answer_status_mag, // 可答题状态
				'current_id' => $id, // 答题信息
                'video_status_mag' => $video_status_mag,// 可观看状态
			]);
		}else{
			abort(404);
			return false;
		}
	}

	// 答题
	public function answer(Request $request, $id){
		if($id){
			$request_data = $request->all();
			// 未填答案
			if(!$request_data){
				return $this->return_data_format(500, '请填完所有测试题');
			}
			// 用户信息
			$user = $this->user;
			if(!$user){
				return $this->return_data_format(500, '未登陆');
			}
			// 已答题
			$check_answer = AnswerLog::where([
				'class_id' => $id,
				'user_id' => $user['id'],
			])->first();
			if($check_answer){
				return $this->return_data_format(555, '已答过题');
			}
			$result = [];
			foreach ($request_data as $key => $val){
				$save_data = [];
				$temp_arr = explode('_', $key);
				$save_data['exercise_id'] = $temp_arr[1];// 试题id
				$save_data['answer'] = $val;// 答题卡，单选
				$save_data['class_id'] = $id; // 课程id
				$save_data['site_id'] = $this->site_id; // 站点id
				$save_data['user_id'] = $user['id']; // 用户id
				$result[] = AnswerLog::create($save_data);
			}
//			dd($result);
			if($result){
				//调用用户中心接口
				$api = new ApiToUserCenterController();
				$api_result = $api->modify_beans($user['phone'], config('params')['bean_rules']['watch_video']);
				if($api_result['code'] == 200){
					return $this->return_data_format(200, '恭喜您，完成答题获得15积分');
				}else{
					return $this->return_data_format(200, '恭喜您，完成答题');
				}
			}else{
				return $this->return_data_format(500, '答题失败');
			}
		}else{
			abort(404);
			return false;
		}
	}

	/**
	 * 登陆用户记录视频播放记录
	 * @param Request $request
	 * @return array
	 */
	public function video_heartbeat_log(Request $request){
		$user = $this->user;
		$req_data = $request->all();
		$class_id = $request->input('class_id');
		$save_data = [];
		if($user && $class_id){
			$where = [
				'site_id' => $this->site_id,
				'doctor_id' => $user['id'],
				'course_id' => $class_id,
			];
			$save_data['site_id'] = $this->site_id;
			$save_data['doctor_id'] = $user['id'];
			$save_data['course_id'] = $class_id;
			$save_data['study_duration'] = $req_data['times'] * config('params')['video_heartbeat_times'];
			$save_data['video_duration'] = $req_data['video_duration'];
			$save_data['progress'] = $req_data['progress'];
			// 查询是否有过观看记录
			$video_logs = StudyLog::where($where)->first();
			if($video_logs){
				StudyLog::where($where)->orderBy('id','desc')->first()->update($save_data);
			}else{
				StudyLog::create($save_data);
				ThyroidClassCourse::find($class_id)->increment('play_count');
			}
		}

		if(ThyroidClassCourse::find($class_id)->course_class_id==$this->answer_class_id)
            $this->setBean(['id'=>$this->user['id'],'phone'=>$this->user['phone']]); //统计答疑课积分

        $this->setVideoBean(['id'=>$this->user['id'],'course_id'=>$class_id,'phone'=>$this->user['phone']]);// 观看视频积分

		return $this->return_data_format(200);
	}

	/**
	 * 登陆用户记录观看记录
	 * @param Request $request
	 * @return array
	 */
	public function watch_times_log(Request $request){
		$class_id = $request->input('class_id');
		$user = $this->user;
		if($class_id){
			$save_data = [
				'site_id' => $this->site_id,
				'course_id' => $class_id,
			];
			if($user){
				$save_data['doctor_id'] = $user['id'];
				StudyLog::create($save_data);
			}
			ThyroidClassCourse::find($class_id)->increment('play_count');
			return $this->return_data_format(200);
		}else{
			return $this->return_data_format(500,'参数缺失无法记录');
		}
	}

	
}

