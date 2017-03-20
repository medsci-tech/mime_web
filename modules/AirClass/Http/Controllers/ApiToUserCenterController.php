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

    /**
     * 发送数据
     * @param string $url 请求的地址
     * @param string  $method 请求方式
     * @param array  $data POST的数据
     * @return string
     */
    protected static function tocurl($url, $data = [] , $method = ''){
        $headers = array(
            "Content-type: application/json;charset='utf-8'",
            "Authorization: Bearer " . env('MD_USER_API_TOKEN'),
            "Accept: application/json",
            "Cache-Control: no-cache","Pragma: no-cache",
        );
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60); //设置超时
        if(0 === strpos(strtolower($url), 'https')) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); //对认证证书来源的检查
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); //从证书中检查SSL加密算法是否存在
        }
        //设置选项，包括URL
        if(strtolower($method) == 'post') // post提交
        {
            curl_setopt($ch, CURLOPT_POST,  True);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        //执行并获取HTML文档内容
        $output = curl_exec($ch);
        //释放curl句柄
        curl_close($ch);
        $response =json_decode($output,true);
        return $response;
    }

    /**
     * 注册
     * @param array $req_data
     * @return array
     */
    public function register(array $req_data)
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
            $response = $this::tocurl($this->md_user_api . '/v2/query-user-information?phone='.$phone);
        }catch (Exception $e){
            return $this->return_data_format(500, '服务器请求异常');
        }
        // 服务器返回响应状态码,,当用户手机号不存在于用户中心
        if(array_key_exists('status', $response)){
            return $this->return_data_format(200, '手机号已注册');
        }else{
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
                $res = $this::tocurl($this->md_user_api . '/v0/register', $post_data,'post');// 同步注册
            }catch (\Exception $e) {
                return $this->return_data_format(500, '服务器请求异常');
            }
            if(array_key_exists('status', $res)){// 服务器返回响应状态码
                return $this->return_data_format(200, '成功');
            }else{
                return $this->return_data_format(500, '服务器请求异常');
            }
        }
    }

    /**
     * 修改迈豆数
     * @param $phone
     * @param $bean
     * @return array
     */
    public function modify_beans($phone, $bean){
        $data = [
            'phone' => $phone,
            'bean' => $bean,
        ];
        try{
            $result = $this::tocurl($this->md_user_api . '/v2/modify-bean', $data, 'post');
        }catch (Exception $e){
            $result = [];
        }
        if(array_key_exists('status',$result)){
            // 请求成功
            return $this->return_data_format(200);
        }else{
            return $this->return_data_format(500, '服务器请求异常');
        }
    }


}

