<?php namespace Modules\AirClass\Http\Controllers;

use App\Models\Address;
use App\Models\Hospital;

class HospitalController extends Controller
{
    public function addHospital($request)
    {
        $hospital = $request['hospital'];
        $province = $request['province'];
        $city = $request['city'];
        $country = $request['country'];
        $hospital_level = $request['hospital_level'];
        $res = Hospital::create([
            'province' => $province,
            'city' => $city,
            'country' => $country,
            'hospital' => $hospital,
            'hospital_level' => $hospital_level,
        ]);
        if($res){
            $return_data = [
                'id' => $res->id,
            ];
            return ['code' => 200, 'msg'=>'success', 'data'=>$return_data];
        }else{
            return ['code' => 500, 'msg'=>'添加医院失败'];
        }
    }




}

