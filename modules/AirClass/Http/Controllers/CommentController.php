<?php namespace Modules\AirClass\Http\Controllers;

use App\Models\Comment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Session;
use App\Http\Requests\Interfaces\DoctorBean;
class CommentController extends Controller
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

    // 评论
    public function videoComment(Request $request, $id){
        if($id){
            // 用户信息
            $user = $this->user;
            if(!$user){
                return $this->return_data_format(401, '未登陆');
            }
            $parent_id = $request->input('parent_id', 0);
            $content = $request->input('content');
            $form_id = $user['id']; // 回复者id
            $form_name = mb_substr($user['phone'], 0, 3).'***'.mb_substr($user['phone'], 7); // 回复者昵称
            $to_id = $request->input('to_id'); // 被回复id
            $to_name = $request->input('to_name'); // 被回复昵称
            if(!$content){
                return $this->return_data_format(401, '评论内容不能为空');
            }
            if(mb_strlen($content) > 1000){
                return $this->return_data_format(401, '评论内容过长');
            }
            $save_data = [
                'class_id' => $id,
                'parent_id' => $parent_id,
                'from_id' => $form_id,
                'from_name' => $form_name,
                'to_id' => $to_id,
                'to_name' => $to_name,
                'content' => $content,
                'site_id' => $this->site_id,
                'status' => 1,
            ];

            $this->setQuestionBean(['id'=>$this->user['id'],'course_id'=>$id,'phone'=>$this->user['phone']]);// 评论送积分
            $result = Comment::create($save_data);
            if($result){
                return $this->return_data_format(200, '操作成功', $result);
            }else{
                return $this->return_data_format(500, '操作失败');
            }
        }else{
            abort(404);
            return false;
        }
    }

    public function get_more_video_comments(Request $request){
        $prev_id = $request->input('prev_id');
        $class_id = $request->input('class_id');
        $parent_id = $request->input('parent_id');
        $comments = [];
        if($parent_id > 0){
            // 只有二级评论
            $comment_lists = Comment::where([
                'status' => 1,
                'class_id' => $class_id,
                'parent_id' => $parent_id,
                ['id', '>', $prev_id],
            ])->orderBy('id', 'asc')->paginate($this->get_comment_every_time);
            if($comment_lists){
                foreach ($comment_lists as $key => $comment_list){
                    $comments[$key] = [
                        'id' => $comment_list->id,
                        'class_id' => $comment_list->class_id,
                        'parent_id' => $comment_list->parent_id,
                        'from_id' => $comment_list->from_id,
                        'from_name' => $comment_list->from_name,
                        'to_id' => $comment_list->to_id,
                        'to_name' => $comment_list->to_name,
                        'content' => $comment_list->content,
                        'created_at' => Carbon::parse($comment_list->created_at)->toDateTimeString(),
                    ];
                }
            }
        }else{
            // 一级评论
            $one_comments = Comment::where([
                'status' => 1,
                'class_id' => $class_id,
                'parent_id' => $parent_id,
                ['id', '>', $prev_id],
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
                        'created_at' => Carbon::parse($one_comment->created_at)->toDateTimeString(),
                        'child' => [],
                    ];
                    // 二级评论
                    $two_comments = Comment::where([
                        'status' => 1,
                        'class_id' => $class_id,
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
                                'created_at' => Carbon::parse($two_comment->created_at)->toDateTimeString(),
                            ];
                        }
                    }
                }
            }
        }
        if($comments){
            return $this->return_data_format(200,null,$comments);
        }else{
            return $this->return_data_format(201);
        }
    }

    public function get_more_user_comments(Request $request){
        $user = $this->user;
        if(!$user){
            return $this->return_data_format(401, '未登陆');
        }
        $prev_id = $request->input('prev_id');
        $from_id = $user['id'];
        $parent_id = $request->input('parent_id');
        $comments = [];
        if($parent_id > 0){
            // 只有二级评论
            $comment_lists = Comment::where([
                'status' => 1,
                'parent_id' => $parent_id,
                ['id', '>', $prev_id],
            ])->orderBy('id', 'asc')->paginate($this->get_comment_every_time);
            if($comment_lists){
                foreach ($comment_lists as $key => $comment_list){
                    $comments[$key] = [
                        'id' => $comment_list->id,
                        'class_id' => $comment_list->class_id,
                        'parent_id' => $comment_list->parent_id,
                        'from_id' => $comment_list->from_id,
                        'from_name' => $comment_list->from_name,
                        'to_id' => $comment_list->to_id,
                        'to_name' => $comment_list->to_name,
                        'content' => $comment_list->content,
                        'created_at' => Carbon::parse($comment_list->created_at)->toDateTimeString(),
                    ];
                }
            }
        }else{
            // 一级评论
            $one_comments = Comment::where([
                'status' => 1,
                'from_id' => $from_id,
                'parent_id' => $parent_id,
                ['id', '>', $prev_id],
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
                        'created_at' => Carbon::parse($one_comment->created_at)->toDateTimeString(),
                        'child' => [],
                    ];
                    // 二级评论
                    $two_comments = Comment::where([
                        'status' => 1,
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
                                'created_at' => Carbon::parse($two_comment->created_at)->toDateTimeString(),
                            ];
                        }
                    }
                }
            }
        }
        if($comments){
            return $this->return_data_format(200,null,$comments);
        }else{
            return $this->return_data_format(201);
        }
    }


}

