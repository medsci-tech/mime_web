<?php namespace Modules\AirClass\Http\Controllers;

use App\Models\Doctor;
use App\Models\Hospital;
use App\Models\Office;
use App\Models\PrivateStudent;
use App\Models\Recommend;
use App\Models\Volunteer;
use App\Models\KZKTClass;
use Hash;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Redis;
use Session;

class UserPublicController extends Controller
{

    /**
     * @return mixed
     */
    public function register_view($uid=null)
    {
        $offices = Office::all();
        if($uid){
            $user = Doctor::findOrFail(base64_decode($uid));
            $uid = $user->id;
        }
        return view('airclass::user_public.register', [
            'offices' => $offices,
            'uid'=>$uid
        ]);
    }

    public function apply(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            $sms = new SmsController();
            $verify = $sms->verify_code($data['phone'],$data['code']);
            if($verify['code']==422){
                return response()->json(['code'=>422,'msg'=>'验证码错误']);
            }
            $private = new PrivateStudent();
            $private->name = $data['name'];
            $private->phone = $data['phone'];
            /*$private->province = $data['save-province'];
            $private->city = $data['save-city'];
            $private->area = $data['save-area'];
            $private->province_code = $data['province'];
            $private->city_code = $data['city'];
            $private->area_code = $request->input('area',0);*/
            $private->hospital = $data['hospital_name'];
            $private->office = $data['office'];
            $private->title = $data['title'];
            $private->email = $data['email'];
            $res = $private->save();
            if($res){
                return response()->json(['code'=>200,'msg'=>'报名成功']);
            }else{
                return response()->json(['code'=>422,'msg'=>'报名失败，请稍后再试']);
            }
        }
        $offices = Office::all();
        return view('airclass::user_public.apply',['offices' => $offices]);
    }

    public function apply_success(Request $request){
        $sms = new SmsController();
        $sms->send_apply_link($request->phone);
        return view('airclass::user_public.applySuccess');
    }

    /**
     * 注册
     * @param Request $request
     * @return array
     */
    public function register_post(Request $request)
    {
        // 验证参数合法性
        $validator_params = $this->validator_params($request->all());
        if($validator_params['code'] != 200){
            return $this->return_data_format(444, $validator_params['msg']);
        }
        $req_phone = $request->input('phone'); //手机号
        $req_code = $request->input('code'); //手机验证码
        $req_pwd = $request->input('password'); //密码
        $req_province = $request->input('save-province'); //省
        $req_city = $request->input('save-city'); //市
        $req_area = $request->input('save-area'); //区

        $req_province_code = $request->input('province'); //省code
        $req_city_code = $request->input('city'); //市code
        $req_area_code = $request->input('area'); //区code

        $req_hospital_level = $request->input('hospital_level'); //医院等级
        $req_hospital_name = $request->input('hospital_name'); //医院名称
        $req_office = $request->input('office'); //科室
        $req_title = $request->input('title'); //职称
        $name = $request->input('name'); //姓名
        $learnMode = $request->input('learn_mode'); //学习模式
        $email = $request->input('email'); //邮箱
        $qq = $request->input('qq'); //qq

        // 检测手机验证码有效性
        $sms = new SmsController();
        $check_code = $sms->verify_code($req_phone, $req_code);
        if($check_code['code'] != 200){
            return $this->return_data_format(422, ['code' => $check_code['msg']]);
        }

        // 不允许代表用户注册
        if(Volunteer::where('phone', $req_phone)->first()){
            return $this->return_data_format(500, '代表用户无法完成注册!');
        }

        // 检验手机号是否注册
        $doctor = Doctor::where('phone', $req_phone)->first();
        if($doctor){
            return $this->return_data_format(422, ['phone' =>'手机号已注册']);
        }

        //推荐人必须存在
        $rec_id = 0;
        if($request->recom){
            $rec_id = $request->recom;
            if(!Doctor::whereId($rec_id)->first())
                return $this->return_data_format(422, '推荐人不存在');
        }
        // 检查医院信息，如果不存在则添加医院信息
        $hospital_where = [
            'hospital' => $req_hospital_name,
            'province' => $req_province,
            'city' => $req_city,
            'country' => $req_area,
        ];
        $hospital = Hospital::where($hospital_where)->first();
        if($hospital){
            $hospital_id = $hospital->id;
            if (empty($hospital->hospital_level)){
                $hospital->hospital_level = $req_hospital_level;
                $hospital->save();
            }
           // Hospital::whereNull('hospital_level')->where('id',$hospital_id) ->update(['hospital_level' => $req_hospital_level]);
        }else{
            $add_hospital_data = [
                'hospital' => $req_hospital_name,
                'province' => $req_province,
                'city' => $req_city,
                'country' => $req_area,
                'province_id' => $req_province_code,
                'city_id' => $req_city_code,
                'country_id' => $req_area_code,
                'hospital_level' => $req_hospital_level,
            ];
            $add_hospital = new HospitalController();
            $hospital = $add_hospital->addHospital($add_hospital_data);
            if($hospital['code'] == 200){
                $hospital_id = $hospital['data']['id'];
            }else{
                return $this->return_data_format(422, ['hospital' => $hospital['msg']]);
            }
        }
        DB::beginTransaction();
        /* 保存医生信息 */
        $add_doctor_data = [
            'phone' => $req_phone,
            'name' => $name,
            'email' => $email,
            'qq' => $qq,
            'password' => Hash::make($req_pwd),
            'hospital_id' => $hospital_id,
            'office' => $req_office,
            'title' => $req_title,
            'rank'=>1

        ];
        $add_doctor = Doctor::create($add_doctor_data);
        if($add_doctor){
            /* 同步注册用户中心 */
//            $api_to_uc_data = [
//                'phone' => $req_phone,
//                'password' => $req_pwd,
//                'office' => $req_office,
//                'title' => $req_title,
//                'province' => $req_province,
//                'role'=>'doctor',
//                'city' => $req_city,
//                'hospital_name' => $req_hospital_name,
//            ];
//            $api_to_uc = new ApiToUserCenterController();
//            $api_to_uc_res = $api_to_uc->register($api_to_uc_data);
            //注册成功即报名
            $doctor_id = $add_doctor->id;
            KZKTClass::create([
                'volunteer_id'=>0,
                'doctor_id'=>$doctor_id,
                'site_id'=>2,
                'status'=>1,
                'style'=> $learnMode
            ]);
            //有推荐人写入推荐人信息并赠送积分
            if($request->recom){
                Recommend::create([
                    'doctor_id'=>$doctor_id,
                    'recommend_id'=>$rec_id
                ]);
                $rec_doctor = Doctor::find($rec_id);
                $rec_doctor->credit += config('params')['bean_rules']['recommend_credit'];
                $rec_doctor->save();
            }

            DB::commit();
            $this->save_session($add_doctor);
            $tempCookie = \Cookie::forever($this->user_login_code, $req_phone);
            return \Response::make(['code' => 200, 'msg' => '注册成功'])->withCookie($tempCookie);

//            if($api_to_uc_res['code'] == 200){
//                DB::commit();
//                $this->save_session($add_doctor);
//                $tempCookie = \Cookie::forever($this->user_login_code, $req_phone);
//                return \Response::make(['code' => 200, 'msg' => '注册成功'])->withCookie($tempCookie);
////                return $this->return_data_format(200,'注册成功!');
//            }else{
//                DB::rollback();//事务回滚
//                return $this->return_data_format(500, $api_to_uc_res['msg']);
//            }
        }else{
            DB::rollback();//事务回滚
            return $this->return_data_format(404, '注册失败');
        }
    }

    /**
     * 账号密码登陆
     * @param Request $request
     * @return array
     */
    public function login_account_post(Request $request)
    {
//        header('Access-Control-allow-origin');
        // 验证参数合法性
        $validator_params = $this->validator_params($request->all());
        if($validator_params['code'] != 200){
            return $this->return_data_format($validator_params['code'], $validator_params['msg']);
        }
        $phone = $request->input('phone');
        $remember = $request->input('remember');
        $password = $request->input('login_pwd');
        $user = Doctor::where('phone', $phone)->first();
        if($user){
            if (Hash::check($password, $user['password'])) {
                $save_data = $this->save_session($user);
                //echo 'wenjuan_'.$user['id'];die;
                /*if(\Redis::get('wenjuan_'.$user['id'])){
                    $status = 1;
                }else{
                    $status = 0;
                }*/
                if($remember){
                    $tempCookie = \Cookie::forever($this->user_login_code, $phone);
                    return \Response::make(['code' => 200, 'msg' => '登陆成功','data' => $save_data])->withCookie($tempCookie);
                }else{
                    return \Response::make(['code' => 200, 'msg' => '登陆成功','data' => $save_data]);
                }
            } else {
                return $this->return_data_format(422, '用户名或密码错误');
            }
        }else{
            return $this->return_data_format(501, '手机号未注册');
        }
    }

    /**
     * 手机验证码登陆
     * @param Request $request
     * @return array
     */
    public function login_phone_post(Request $request){
        // 验证参数合法性
        $validator_params = $this->validator_params($request->all());
        if($validator_params['code'] != 200){
            return $this->return_data_format($validator_params['code'], $validator_params['msg']);
        }
        $phone = $request->input('phone');
        $remember = $request->input('remember');
        $code = $request->input('code');
        $sms = new SmsController();
        $check_code = $sms->verify_code($phone, $code);
        if($check_code['code'] != 200){
            return $this->return_data_format($check_code['code'], $check_code['msg']);
        }
        $user = Doctor::where('phone', $phone)->first();
//        dd($user->hospital);
        if ($user) {
            $save_data = $this->save_session($user);
            if($remember){
                $tempCookie = \Cookie::forever($this->user_login_code, $phone);
                return \Response::make(['code' => 200, 'msg' => '登陆成功','data' => $save_data])->withCookie($tempCookie);
            }else{
                return $this->return_data_format(200,'登陆成功', $save_data);
            }
        } else {
            return $this->return_data_format(501, '手机号未注册');
        }
    }

    // 微信登陆 todo



    /**
     * 找回密码--post
     * @param Request $request
     * @return array
     */
    public function pwd_recover_post(Request $request)
    {
        // 验证参数合法性
        $validator_params = $this->validator_params($request->all());
        if($validator_params['code'] != 200){
            return $this->return_data_format($validator_params['code'], $validator_params['msg']);
        }
        $phone = $request->input('phone'); // 手机号
        $verify_code = $request->input('code'); // 短信验证码
        $password = $request->input('password'); // 密码
        $re_password = $request->input('re_password'); // 重复密码
        // 校验短信验证码
        $sms = new SmsController();
        $check_code = $sms->verify_code($phone, $verify_code);
        if($check_code['code'] != 200) {
            return $this->return_data_format($check_code['code'], $check_code['msg']);
        }
        // 验证两次密码输入是否一致
        if($password == $re_password){
            $user = Doctor::where('phone', $phone)->update(['password'=> Hash::make($password)]);
//            dd($user);
            if($user){
                return $this->return_data_format(200, '操作成功');
            }else{
                return $this->return_data_format(500, '操作失败');
            }
        }else{
            return $this->return_data_format(422, '两次密码输入不一致');
        }

    }

    // 退出
    public function logout(){
        Session::forget($this->user_login_session_key);
        \Cookie::queue($this->user_login_code,null);
        return redirect('/');
    }

   public function test(){

//       $phone = '13554498149';
//       $bean = config('params')['bean_rules']['watch_video'];
//       $api = new ApiToUserCenterController();
//       $res = $api->modify_beans($phone,$bean);
//       dd($res);
   }
   public function incrTimes(){
       $key = 'user:'.$this->user['id'].':activity';
       Redis::incr($key);
       echo 1;exit;
   }

}

