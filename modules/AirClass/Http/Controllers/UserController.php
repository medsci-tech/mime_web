<?php namespace Modules\Airclass\Http\Controllers;

use Illuminate\Http\Request;
use Modules\AirClass\Entities\Student;
use PhpParser\Comment\Doc;
use Session;
use \App\Model\Doctor;
use \App\Model\Hospital;
use \App\Model\Address;
use Hash;
class UserController extends Controller
{
	protected $user = null;
	public function __construct()
	{
		$user = Session::get($this->user_login_session_key);
		if($user){
			$this->user = $user;
		}else{
			redirect(url('/login'));
		}
	}
	public function study()
	{
		dd('video');
	}

	public function msg()
	{
//		$messages =
		dd('video');
	}

	public function comment()
	{
		$comments = [];
		dd('comment');
	}
	public function edit_info()
	{
		dd('video');
	}
	public function edit_pwd()
	{
		dd('video');
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
     * 个人密码修改
     * @author      lxhui<772932587@qq.com>
     * @since 1.0
     * @return array
     */
    public function postReset(Request $request)
    {
        $phone = $request->input('phone');
        $password = $request->input('password');
        $data = $request->all();
        $rules = [
            'phone' => 'required|digits:11',
            'code' => 'required|digits:6',
            'password'=>'required|between:6,20|confirmed',
        ];
        $messages = [
            'phone.required' => '电话号码不能为空',
            'code.required' => '验证码必须是6位',
            'password.required' => '密码不能为空',
            'password.between' => '密码必须是6~20位之间',
            'confirmed' => '新密码和确认密码不匹配'
        ];
        $validator = Validator::make($data, $rules, $messages);

        $user = Auth::user();
        if (!$validator->fails()) {
            $user->password = Hash::make($password);
            $user->save();
        }
        else
            return ['status_code' => 0,'message' =>'修改失败!请完善资料!'];

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
            'sex' => 'required|in:男,女',
            'hospital' => 'required',
            'office' => 'required|in:男,女',
            'title' => 'required',
        ]);

        if (!$validator->fails()) {
            $phone ='15927086090';//session获取

            $name = $request->name; //姓名
            $req_request = $request->hospital; //医院
            $req_country = $request->country;
            $sex = $request->sex;//性别
            $office = $request->office; //科室
            $title = $request->title; //职称
            $hospital_level = $request->hospital_level; //等级
            $qq = $request->qq; //qq
            DB::beginTransaction();
            try{
                /* 同步更新用户中心 */
                $response = \Helper::tocurl(env('API_URL2'). '/query-user-information?phone='.$request->phone, null,0);
                if($response['httpCode']==200)// 服务器返回响应状态码,当电话存在时
                {
                    if(isset($response['status'])) //电话存在则同步更新
                    {
                        $doctor = Doctor::where('phone', $phone)->first();
                        // 医院
                        $hospital_where = [
                            'hospital' => $req_request,
                            'country' => $req_country,
                        ];
                        $hospital = Hospital::where($hospital_where)->first();
                        if($hospital)
                        {
                            $hospital_id = $hospital->id;
                            $province = $hospital->province;
                            $city = $hospital->city;
                            $hospital_name = $hospital->hospital;
                        }
                        else{
                            $add_request = [
                                'country' => $req_country,
                                'hospital' => $req_request,
                            ];
                            $hospital = $this->addHospital($add_request);
                            if($hospital['status_code'] == 200)
                            {
                                $hospital_id = $hospital['data']['id'];
                                $province = $hospital['data']['province'];
                                $city = $hospital['data']['city'];
                                $hospital_name = $hospital['data']['hospital'];
                            }
                            else
                                return $this->return_data_format(0, $hospital['message']);
                        }
                        try{
                            $post_data = array(
                                "phone" => $phone,
                                'role'=>'医生',
                                'remark'=>'空中课堂',
                                'province'=>$province,//省
                                'city'=>$city,//城市
                                'hospital_name'=>$hospital_name, //医院名称
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
                                    'hospital_level'=>$hospital_level, //等级
                                    'hospital_id'=> $hospital_id, //医院id
                                    'title'=>$title, //职称
                                    'qq'=>$qq, //职称
                                );
                                Doctor::where('phone', $phone)->update($updata);
                            }

                        }catch (\Exception $e) {
                            return ['status_code' => 0,'message' =>'服务器异常,修改失败!'.$e->getMessage()];
                        }
                    }
                }
                else
                    return ['status_code' => 0,'message' =>'服务器异常哦,修改失败!'];

                DB::commit();
            } catch (\Exception $e){
                DB::rollback();//事务回滚
                return ['status_code' => 0,'message' =>'修改失败!'.$e->getMessage()];
            }

        }
        return ['status_code' => 200, 'message'=>'保存成功!'];

    }

	public function logout(Request $request)
	{
		Session::forget($this->user_login_session_key);
		redirect('/login');
	}
	
}

