<?php namespace Modules\AirClass\Http\Controllers;

use App\Models\Hospital;
use Illuminate\Http\Request;

class HospitalController extends Controller
{
    public function addHospital($request)
    {
        $hospital = $request['hospital'];
        $province = $request['province'];
        $city = $request['city'];
        $country = $request['country'];

        $province_id = $request['province_id'];
        $city_id = $request['city_id'];
        $country_id = $request['country_id'];

        $hospital_level = $request['hospital_level'];
        $res = Hospital::create([
            'province' => $province,
            'city' => $city,
            'country' => $country,
            'province_id' => $province_id,
            'city_id' => $city_id,
            'country_id' => $country_id,
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

    // 获取医院
    function get_lists(Request $request)
    {
        $province = $request->input('province');
        $city = $request->input('city');
        $area = $request->input('area');
        $name = $request->input('name');
        $where = [];
        if($province){
            $where['province'] = $province;
            if($city){
                $where['city'] = $city;
                if($area){
                    $where['country'] = $area;
                }
            }
            if($name){
                $list = Hospital::where($where)->where('hospital', 'like', '%' . $name . '%')->get();
            }else{
                $list = Hospital::where($where)->get();
            }
        }else{
            $list = null;
        }
        if($list){
            return $this->return_data_format(200, 'success', $list);
        }else{
            return $this->return_data_format(201, 'success');
        }
    }

}

