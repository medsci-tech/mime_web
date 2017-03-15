<?php namespace Modules\AirClass\Http\Controllers;

use Illuminate\Http\Request;
use PhpParser\Comment\Doc;
use \App\Models\Doctor;
use \App\Models\Hospital;
use Modules\AirClass\Entities\Office;
use \App\Model\Address;
use Hash;
use Cache;
use DB;
class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('login');
        parent::__construct();
    }
	public function study()
	{
        return view('airclass::user.study', [
            'current_active' => 'study',
        ]);
	}

	public function msg()
	{
        return view('airclass::user.msg', [
            'current_active' => 'msg',
        ]);
	}

	public function comment()
	{
		$comments = [];
        return view('airclass::user.comment', [
            'current_active' => 'comment',
        ]);
	}
	public function info_edit()
	{
        $offices = Office::all();
        $doctor = Doctor::find($this->user['id']);
        return view('airclass::user.info_edit', [
            'offices' =>$offices ,
            'doctor' =>$doctor ,
            'current_active' => 'info_edit',
        ]);
	}
	public function pwd_edit()
	{
        return view('airclass::user.pwd_edit', [
            'current_active' => 'pwd_edit',
        ]);
	}


	public function info_update(Request $request)
	{
		dd('资料修改');
	}

	public function pwd_update()
	{
		dd('密码修改');
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

        $user = $this->user;
        if (!$validator->fails()) {
            $model = Doctor::find($user['id']);
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
           // 'sex' => 'required|in:男,女',
            'hospital_name' => 'required',
            'province' => 'required',
            'city' => 'required',
            'office' => 'required',
            'hospital_level' => 'required',
            'office' => 'required',
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
            $sex = $request->sex;//性别
            $office = $request->office; //科室
            $title = $request->title; //职称
            $hospital_level = $request->hospital_level; //等级
            $email = $request->email;

            DB::beginTransaction();
            try{
                /* 同步更新用户中心 */
                $response = \Helper::tocurl(env('MD_USER_API_URL'). '/v2/query-user-information?phone='.$phone, null,0);
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
                            'hospital_level' => $request->hospital_level,
                        ];
                        $hospital = Hospital::firstOrCreate($hospital_where);
                        $hospital_id = $hospital->id;

                        try{
                            $post_data = array(
                                "phone" => $phone,
                                'role'=>'医生',
                                'remark'=>'空中课堂',
                                'province' => $request->province,
                                'city' => $request->city,
                                'hospital_name'=>$hospital, //医院名称
                                'sex'=>$sex, //性别
                                'office'=>$office, //科室
                                'hospital_level'=>$hospital_level, //等级
                                'title'=>$title, //职称
                            );
                            /* 同步更新 */
                            if($doctor)
                            {
                                $updata = array(
                                    'name'=>$name,//姓名
                                    'sex'=>$sex, //性别
                                    'office'=>$office, //科室
                                    'hospital_id'=> $hospital_id, //医院id
                                    'title'=>$title, //职称
                                    'email'=>$email,
                                );
                                Doctor::where('id', $this->user['id'])->update($updata);
                            }

                        }catch (\Exception $e) {
                            return ['status_code' => 0,'message' =>'服务器异常,修改失败!'.$e->getMessage()];
                        }
                    }
                }
                else
                    return ['code' => 0,'message' =>'服务器异常哦,修改失败!'];

                DB::commit();
            } catch (\Exception $e){
                DB::rollback();//事务回滚
                return ['code' => 0,'message' =>'修改失败!'.$e->getMessage()];
            }

        }
        return ['code' => 200, 'message'=>'保存成功!'];

    }

	public function logout(Request $request)
	{
		Session::forget($this->user_login_session_key);
		redirect('/login');
	}
	
}

