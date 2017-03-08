<?php namespace Modules\Airclass\Http\Controllers;

use Pingpong\Modules\Routing\Controller as BaseController;
use \App\Model\Hospital;
use \App\Model\Address;
class Controller extends BaseController
{
    protected $student_login_session_key = 'student_login_session_key'; // 用户登录session key
    protected $site_id = 1; // airClass site_id

    public function return_data_format($code = 200, $msg = null, $data = null)
    {
        return ['code' => $code, 'msg' => $msg, 'data' => $data];
    }

    protected function verify_code_post($phone, $code)
    {
        return $this->return_data_format(200);
    }

    /**
     * 添加医院信息
     * @author      lxhui<772932587@qq.com>
     * @since 1.0
     * @return array
     */

    protected function addHospital($request)
    {
        $country = $request['country'];
        $name = $request['hospital'];
        $address = Address::where('country', $country)->first();
        if($address) {
            $data = new Hospital();
            $data->province = $address->province;
            $data->province_id = $address->province_id;
            $data->city = $address->city;
            $data->city_id = $address->city_id;
            $data->country = $address->country;
            $data->country_id = $address->country_id;
            $data->hospital = $name;
            //$data->hospital_level = $request['hospital_level'];
            $res = $data->save();
            if($res){
                return [
                    'status_code' => 200,
                    'message'=>'success',
                    'data'=>
                        [
                            'id' => $data->id,
                            'province'=>$address->province,
                            'city'=>$address->city,
                            'hospital'=> $name
                        ]
                ];
            }else{
                return ['status_code' => 0, 'message'=>'添加医院失败'];
            }

        }else {
            return ['status_code' => 0, 'message'=>'匹配不到地区'];
        }

    }
	
}

