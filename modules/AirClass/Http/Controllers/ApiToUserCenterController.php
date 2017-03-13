<?php namespace Modules\AirClass\Http\Controllers;


use Mockery\CountValidator\Exception;

class ApiToUserCenterController extends Controller
{
    protected $user_role = 'doctor';
    protected $user_remark = '空中课堂';
    protected $md_user_api;

    public function __construct()
    {
        $this->md_user_api = env('MD_USER_API_URL');
    }

    public function register($req_data)
    {
        $phone = $req_data['phone'];
        $password = $req_data['password'];
        $title = $req_data['title'];
        $office = $req_data['office'];
        $province = $req_data['province'];
        $city = $req_data['city'];
        $hospital_name = $req_data['hospital_name'];
        // 查询用户信息
        try{
            $response = \Helper::tocurl($this->md_user_api . '/v2/query-user-information?phone='.$phone, null,0);
        }catch (Exception $e){
            $response = [];
        }
        // 服务器返回响应状态码,,当用户手机号不存在于用户中心
        if($response['httpCode']==200){
            return $this->return_data_format(200, '手机号已注册');
        //电话不存在则同步注册
        }else if($response['httpCode']==422){
            $post_data = [
                "phone" => $phone,
                'role'=>$this->user_role,
                'remark'=>$this->user_remark,
                'password'=>$password,
                'title'=>$title, //职称
                'office'=>$office,//科室
                'province'=>$province,//省
                'city'=>$city,//城市
                'hospital_name'=>$hospital_name, //医院名称
            ];
            try{
                $res = \Helper::tocurl($this->md_user_api . '/v0/register', $post_data,1);// 同步注册
            }catch (\Exception $e) {
                return $this->return_data_format(404, '服务器异常');
            }
            if($res['httpCode']==200 && $res['status'] == 'ok'){// 服务器返回响应状态码
                return $this->return_data_format(200, '手机号已注册');
            }else{
                return $this->return_data_format(404, '服务器异常');
            }
        }else{
            return $this->return_data_format(500, '服务器请求异常');
        }
    }




}

