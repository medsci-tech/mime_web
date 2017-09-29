<?php namespace Modules\AirClass\Http\Controllers;

use App\Models\Comment;
use App\Models\PrivateClass;
use App\Models\StudyLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Modules\Admin\Http\Controllers\UploadController;
use PhpParser\Comment\Doc;
use \App\Models\{Doctor,Hospital,Volunteer};
use Modules\AirClass\Entities\{Office,ThyroidClassCourse,KZKTClass};
use \App\Models\{Address, Message};
use Hash;
use Cache;
use DB;
use App\Http\Requests\Interfaces\DoctorBean;

class UserController extends Controller
{
    use DoctorBean;
    protected $get_comment_every_time = 10; // 每次加载评论条数
    protected $bean = 0; // 积分数
    public function __construct()
    {
        $this->middleware('login');
        parent::__construct();
        $bean_key = "user:".$this->user['id'].':bean';
        if(!\Redis::exists($bean_key)){
            $this->bean = $this->getBean(['id'=>$this->user['id'],'phone'=>$this->user['phone']])->bean; // 用户积分
            \Redis::setex($bean_key,3,$this->bean);
        }
        else
            $this->bean =  \Redis::get($bean_key);
    }
    /**
     * unstudy
     * @author      lxhui<772932587@qq.com>
     * @since 1.0
     * @return array
     */
    public function studyRank($id)
    {
        if (!in_array($id, [2,3]))
            return redirect('/user');

        $model = new StudyLog();
        $data = $model::getStudyLog(['site_id'=>2,'rank'=>$id,'id'=>$this->user['id']]);
        $list = ThyroidClassCourse::select(['id','title','logo_url','logo_url','comment'])->whereIn('id',$data)->get();
        foreach($list as &$val)
        {
            $units = DB::table('study_logs')
                ->select(DB::raw('sum(study_duration) as duration_count,max(created_at) as study_date, course_id,progress,video_duration,created_at,truncate(max(progress)/max(video_duration),3) as percent'))
                ->where(['doctor_id'=>$this->user['id'],'course_id'=>$val->id])
                ->orderBy('created_at', 'desc')
                ->orderBy('percent', 'desc')->first();

            $val->date_time=$units->study_date ? date('Y/m/d',strtotime($units->study_date)) : null;
            $val->percent = $units->percent>1 ? 1: $units->percent ;
            $val->duration_count = $units->duration_count ? $units->duration_count: 0 ;
            $val->study_date = $units->study_date  ? $units->study_date: null ;
        }

        return view('airclass::user.study_log', [
            'current_active' => 'study',
            'units' => $list,
        ]);
    }

    /**
     * 我的消学习情况
     * @author      lxhui<772932587@qq.com>
     * @since 1.0
     * @return array
     */
	public function study()
	{
        $units = DB::table('study_logs')
            ->select(DB::raw('sum(study_duration) as duration_count,max(created_at) as study_date, course_id,progress,video_duration,created_at,truncate(max(progress)/max(video_duration),3) as percent'))
            ->where(['site_id'=>$this->site_id,'doctor_id'=>$this->user['id']])
            ->groupBy('course_id')
            //->orderBy('percent', 'desc')
            ->orderBy('created_at', 'desc')
            ->orderBy('percent', 'desc')
            ->paginate(15);
        foreach($units as &$val)
        {
            $model = ThyroidClassCourse::find($val->course_id);
            $val->title=$model->title;
            $val->logo_url=$model->logo_url;
            $val->comment=$model->comment;
            $val->id=$model->id;
            $val->date_time=date('Y/m/d',strtotime($val->study_date));
            $val->title=$model->title;
            $val->percent = $val->percent>1 ? 1: $val->percent ;
        }
        return view('airclass::user.study', [
            'current_active' => 'study',
            'units' => $units,
        ]);
	}
    /**
     * 我的消息列表
     * @author      lxhui<772932587@qq.com>
     * @since 1.0
     * @return array
     */
	public function msg()
	{
        Message::where(['phone'=>$this->user['phone']])->update(['read_status' => 1]); // 标记已读状态
        $lists =  Message::orderBy('id','desc')->where(['phone'=>$this->user['phone']])->paginate(15);
        return view('airclass::user.msg', [
            'lists' => $lists,
            'current_active' => 'msg',
        ]);
	}

    public function comment()
    {
        $user = $this->user;
        if($user){
            //## 评论
            $comments = [];
            // 一级评论
            $one_comments = Comment::where([
                'status' => 1,
                'from_id' => $user['id'],
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
                        'from_id' => $user['id'],
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
//            dd($comments);
            return view('airclass::user.comment', [
                'current_active' => 'comment',
                'comments' => $comments, // 评论列表
                'get_comment_num' => $this->get_comment_every_time, // 评论列表
            ]);
        }else{
            abort(404);
            return false;
        }
    }
    /**
     * 修改资料视图
     * @author      lxhui<772932587@qq.com>
     * @since 1.0
     * @return array
     */
	public function info_edit()
	{
        $offices = Office::all();
        return view('airclass::user.info_edit', [
            'offices' =>$offices ,
            'doctor' =>$this->user ,
            'current_active' => 'info_edit',
        ]);
	}
	public function pwd_edit()
	{
        return view('airclass::user.pwd_edit', [
            'current_active' => 'pwd_edit',
        ]);
	}

    public function getReset()
    {
        return view('auth.reset');
    }
    /**
     * 短信发送
     * @author      lxhui<772932587@qq.com>
     * @since 1.0
     * @return array
     */
    public function send(Request $request)
    {
        $method=$request->method();
        if($request->isMethod('post')){
            $validator = \Validator::make($request->all(), [
                'phone'   => 'required|digits:11|regex:/^1[35789]\d{9}$/'
            ]);
            if ($validator->fails()) {
                return ['status_code' => 200, 'message' => $validator->errors()->first('phone')];
            }
            $phone  = $request->phone;
            $code   = \MessageSender::generateMessageVerify();
            \MessageSender::sendMessageVerify($phone, $code);
            try {
                Cache::put($phone, $code,1);
            } catch (\Exception $e) {
                return ['status_code' => 0, 'message' => $e->getMessage()];
            }
            return ['status_code' => 200, 'message' => '发送成功!','code'=> $code];
        }
        else{
            return ['status_code' => 0, 'message' => '发送失败!','code'=> null];
        }
    }

    /**
     * 个人密码修改
     * @author      lxhui<772932587@qq.com>
     * @since 1.0
     * @return array
     */
    public function pwdReset(Request $request)
    {
        $phone = $request->input('phone');
        $password = $request->input('password');
        $data = $request->all();
        $rules = [
            'phone' => 'required|digits:11',
            'code' => 'required|digits:6',
            'password'=>'required|between:6,20|confirmed|regex:/^[\w\.-]{6,22}$/',
        ];
        $messages = [
            'phone.required' => '电话号码不能为空',
            'code.required' => '验证码不能为空',
            'password.required' => '密码不能为空',
            'password.between' => '密码必须是6~20位之间',
            'confirmed' => '新密码和确认密码不匹配'
        ];
        $validator = \Validator::make($data, $rules, $messages);
        $validator_error_first = $validator->errors()->first();
        if($validator_error_first){
            return $this->return_data_format(422, $validator_error_first);
        }
        /* 验证码验证 */
        $auth_code = \Cache::get($request->phone);
        if ($request->code != $auth_code) {
            return ['code' => 0,'msg' =>'验证码不匹配'];
        }

        if (!$validator->fails()) {
            $model = Doctor::find($this->user['id']);
            $model->password = \Hash::make($password);
            $model->save();
            return $this->return_data_format(200, '修改成功!');
        }
        else
            return ['code' => 0,'msg' =>'修改失败!请完善资料!'];

        //Auth::logout();  //更改完这次密码后，退出这个用户
        //return redirect('/login');
    }

    /**
     * 个人资料修改
     * @author      lxhui<772932587@qq.com>
     * @since 1.0
     * @return array
     */
    public function saveInfo(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required|max:25',
            'hospital_name' => 'required',
            'province' => 'required',
            'city' => 'required',
            'office' => 'required',
            'hospital_level' => 'required',
            'title' => 'required',
            'email' => 'required',
        ]);
        $validator_error_first = $validator->errors()->first();
        if($validator_error_first){
            return $this->return_data_format(422, $validator_error_first);
        }

        if (!$validator->fails()) {
            $phone = $this->user['phone'];//session获取
            $name = $request->name; //姓名
            $hospital = $request->hospital_name; //医院
            $office = $request->office; //科室
            $title = $request->title; //职称
            $hospital_level = $request->hospital_level; //等级
            $email = $request->email;

            DB::beginTransaction();
            try{
                /* 同步更新用户中心 */
                //$response = \Helper::tocurl(env('MD_USER_API_URL'). '/v2/query-user-information?phone='.$phone, null,0);
                $response=['httpCode'=>200,'status'=>true];
                if($response['httpCode']==200)// 服务器返回响应状态码,当电话存在时
                {
                    if(isset($response['status'])) //电话存在则同步更新
                    {
                        $doctor = Doctor::where('phone', $phone)->first();
                        // 检查医院信息，如果不存在则添加医院信息
                        $hospital_where = [
                            'hospital' => $hospital,
                            'province' => $request->province,
                            'city' => $request->city,
                            'country' => $request->area,
                            'province_id' => $request->province_id,
                            'city_id' => $request->city_id,
                            'country_id' => $request->country_id,
                            'hospital_level' => $request->hospital_level,
                        ];
                        $hospital = Hospital::firstOrCreate($hospital_where);
                        $hospital_id = $hospital->id;

                        try{
                            if($class = KZKTClass::where(['doctor_id'=>$this->user['id']])->first())
                            {
                                $volunteer_id = $class->volunteer_id;
                                $upper_user_phone = Volunteer::find($volunteer_id)->phone;
                            }
                            $post_data = array(
                                "phone" => $phone,
                                'role'=>'医生',
                                'remark'=>'空中课堂',
                                'province' => $request->province,
                                'city' => $request->city,
                                'hospital_name'=>$request->hospital_name, //医院名称
                                'upper_user_phone'=>isset($upper_user_phone) ? $upper_user_phone : '', //用户的上级用户电话
                                'office'=>$office, //科室
                                'hospital_level'=>$hospital_level, //等级
                                'title'=>$title, //职称
                            );
                            //$res = \Helper::tocurl(env('MD_USER_API_URL'). '/v2/modify-user-information', $post_data,1);
                            $res=['httpCode'=>200,'status'=>true];
                            if($res['httpCode']==200)// 服务器返回响应状态码,当电话存在时
                            {
                                /* 同步更新 */
                                if($doctor)
                                {
                                    $updata = array(
                                        'name'=>$name,//姓名
                                        'office'=>$office, //科室
                                        'hospital_id'=> $hospital_id, //医院id
                                        'title'=>$title, //职称
                                        'email'=>$email,
                                    );
                                    Doctor::where('id', $this->user['id'])->update($updata);

                                    /* 更新会话 */
                                    $this->user['name'] =$name;
                                    $this->user['title'] =$title;
                                    $this->user['office'] =$request->office;
                                    $this->user['province'] =$request->province;
                                    $this->user['city'] =$request->city;
                                    $this->user['area'] =$request->area;
                                    $this->user['email'] =$request->email;
                                    $this->user['hospital_name'] =$request->hospital_name;
                                    $this->user['hospital_level'] =$hospital_level;
                                    \Session::set($this->user_login_session_key, $this->user);
                                }
                            }
                        }catch (\Exception $e) {
                            return ['code' => 0,'message' =>'服务器异常,修改失败!'.$e->getMessage()];
                        }
                    }
                }
                else{
                    return ['code' => 0,'message' =>'服务器异常哦,修改失败!'];
                }

                DB::commit();
            } catch (\Exception $e){
                DB::rollback();//事务回滚
                return ['code' => 0,'message' =>'修改失败!'.$e->getMessage()];
            }

        }

        return ['code' => 200, 'message'=>'保存成功!'];
    }

    /**
     * 个人二维码
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function qrcode(){
        //dd($this->user);
        $phone = $this->user['phone'];//用户手机号
        if(!file_exists(public_path('airclass/qrcodes/'.$phone.'.png'))){
            if(!file_exists(public_path('airclass/qrcodes'))) mkdir(public_path('airclass/qrcodes'));
            \QrCode::format('png')->size(500)->generate(url('/register',['phone'=>$phone]), public_path('airclass/qrcodes/'.$phone.'.png'));
        }
        $img = 'airclass/qrcodes/'.$phone.'.png';

        //dd($img);
//        dd($lists);
        return view('airclass::user.qrcode', [
            'img' => $img,
            'current_active' => 'qrcode',
        ]);
    }

    public function private_class(){
        $lists = PrivateClass::where(['doctor_id' => $this->user['id']])->get();
//        dd($lists);
        return view('airclass::user.private_class', [
            'lists' => $lists,
            'current_active' => 'private_class',
        ]);
    }

    public function private_class_save(Request $request){
        $id = $request->input('id');
        $file = $request->file('file');
        if(!$file){
            return $this->return_data_format(422, '请添加病例文件');
        }
        $upload = new UploadController();
        $file_save_name =  config('params')['private_class_term'] . '-' . $this->user['phone'];
        $upload_res = $upload->create($file, $file_save_name);
        if($upload_res['code'] == 200){
            $private = PrivateClass::find($id)->update(['upload_id' => $upload_res['id']]);
            if($private){
                return $this->return_data_format(200, '病例修改成功');
            }else{
                return $this->return_data_format(500, '病例修改失败');
            }
        }else{
            return $this->return_data_format(500, '病例上传失败');
        }
    }

	public function logout(Request $request)
	{
		Session::forget($this->user_login_session_key);
		redirect('/login');
	}
	
}

