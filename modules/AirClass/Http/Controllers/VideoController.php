<?php namespace Modules\AirClass\Http\Controllers;

use App\Models\Doctor;
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
					if($class->course_type == 2 && $user['rank'] < 2){
						$video_status_mag = '达到等级二才能观看选修课';
					}
				}else{
					$answer_status_mag = '报名后才能答题';
					$video_status_mag = '报名后继续观看';
				}
			}else{
				$answer_status_mag = '登陆后才能答题';
				$video_status_mag = '登陆后继续观看';
			}
//			dd($chapter_classes);
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

	public function questions(){
        $exec = Exercise::where('site_id',$this->site_id)->inRandomOrder()->limit(config('params')['question_num'])->get();//dd($exec);
        foreach ($exec as &$val){
            $val['option'] = unserialize($val['option']);
        }
        return response()->json($exec);
    }

	// 答题
	public function answer(Request $request, $id=null){
		if($id!==null){
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
            if($id){
                $check_answer = AnswerLog::where([
                    'class_id' => $id,
                    'user_id' => $user['id'],
                ])->first();
                if( $check_answer){//id不为0
                    return $this->return_data_format(555, '已答过题');
                }
			}
			$result = [];
			$right_ans =  0;//答对问题的总数
			foreach ($request_data as $key => $val){
				$save_data = [];
				$temp_arr = explode('_', $key);
				$save_data['exercise_id'] = $temp_arr[1];// 试题id
				$save_data['answer'] = $val;// 答题卡，单选
				$save_data['class_id'] = $id; // 课程id
				$save_data['site_id'] = $this->site_id; // 站点id
				$save_data['user_id'] = $user['id']; // 用户id
				$result[] = AnswerLog::create($save_data);
				$res = Exercise::where(['id'=>$temp_arr[1],'answer'=>$val])->count();
                $right_ans += $res;
			}

			if($result){
				//调用用户中心接口
				//$api = new ApiToUserCenterController();
				//$api_result = $api->modify_beans($user['phone'], config('params')['bean_rules']['answer_question']);
                if(!$id){
                    $user_rank = $user['rank'];
                    if(($right_ans>=config('params')['question_num']*0.6) && ($user_rank<3)){
                        //正确率60%以上通过
                        //限时活动 ：
                        //1.学员晋升后，获得1000迈豆（已升级的不管，每晋升一次给1000）
                        //2.学员晋升后，相应的代表获得迈豆（已升级的不管，晋升合格500，晋升优秀300)
                        $vol_credit = $user_rank==2?300:500;//推荐人获取的奖励积分
                        $doc_credit = config('params')['bean_rules']['rank_level'];
                        if(Carbon::createFromDate(2017,11,30)->gte(Carbon::now())){
                            $doc_credit = 1000;
                            //代表获取迈豆
                            $volunteer = KZKTClass::where('doctor_id',$user['id'])->first()->volunteer;
                            if($volunteer){
                                Volunteer::where('id',$volunteer->id)->increment('credit',$vol_credit);
                            }
                        }
                        $doctor = Doctor::find($user['id']);
                        $doctor->rank +=1;//晋升
                        $doctor->setupbyanswer +=1;//答题晋升次数
                        $doctor->credit +=$doc_credit;//晋升奖励迈豆
                        $doctor->save();
                        session(['user_login_session_key.rank'=> ($user_rank+1)]);
                        return $this->return_data_format(200, '恭喜您，学员等级升级成功',['rank'=>($user_rank+1)]);
                    }else{
                        //未达标
                        return $this->return_data_format(200, '晋升失败！请再次尝试');
                    }
                }
                $res = Doctor::find($user['id'])->increment('credit', config('params')['bean_rules']['answer_question']);
				if($res){

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
			$save_data['study_duration'] = $req_data['times'] * config('params')['video_heartbeat_times'];//观看视频总时长
			$save_data['progress'] = $req_data['progress'];//视频进度
			// 查询是否有过观看记录
			$video_logs = StudyLog::where($where)->first();
			$course = ThyroidClassCourse::find($class_id);
			$save_data['video_duration'] = $course->video_duration;
			if($video_logs){
				StudyLog::where($where)->orderBy('id','desc')->first()->update($save_data);
			}else{
				StudyLog::create($save_data);
				$course->increment('play_count');
			}
		}

		if(ThyroidClassCourse::find($class_id)->course_class_id==$this->answer_class_id)
            $this->setBean(['id'=>$this->user['id'],'phone'=>$this->user['phone']]); //统计答疑课积分

        $this->setVideoBean(['id'=>$this->user['id'],'course_id'=>$class_id,'phone'=>$this->user['phone']]);// 观看点击视频积分

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
				$course = ThyroidClassCourse::find($class_id);
				$save_data['video_duration'] = $course->video_duration;
				$save_data['doctor_id'] = $user['id'];
				StudyLog::create($save_data);
			}
			$course->increment('play_count');//视频播放量+1
			return $this->return_data_format(200);
		}else{
			return $this->return_data_format(500,'参数缺失无法记录');
		}
	}

	
}

