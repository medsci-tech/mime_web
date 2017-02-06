<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use Modules\Admin\Entities\Site;
use Modules\Admin\Entities\Student;
use Modules\Admin\Entities\ThyroidClassPhase;

/**
 * Class StatisticController
 * @package App\Http\Controllers\Admin
 */
class StatisticController extends Controller
{

    function update()
    {
        $cities = City::all();

        foreach ($cities as $city) {
            $city->student_count = Student::where('area', $city->area)->count();
            $city->save();
        }
        return redirect('/statistic/map');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function areaMap()
    {
        return view('admin::backend.charts.charts_map_area', [
            'cities' => City::all()
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function provinceMap()
    {
        return view('admin::backend.charts.charts_map_province');
    }

    /**
     *
     */
    function pie()
    {

    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function registerBar(Request $request)
    {
        $site_id = $request->input('site_id');
        $format = 'Y-m';
        $return_data = [
            'date' => [],
            'register' => [],
            'sign' => [],
        ];
        if($site_id){
            $first_time = Student::where('site_id',$site_id)->orderBy('id','asc')->first()['created_at'];
            $last_time = Student::where('site_id',$site_id)->orderBy('id','desc')->first()['created_at'];
            if($first_time && $last_time){
                $first_data = date($format,strtotime($first_time));
                $last_data = date($format,strtotime($last_time));
                while ($first_data <= $last_data){
                    $first_data_next = date($format,strtotime('+1 month',strtotime($first_data)));
                    $register_counts = Student::where('site_id',$site_id)
                        ->where('created_at', '>=', $first_data)
                        ->where('created_at', '<', $first_data_next)
                        ->count();
                    $sign_counts = Student::where('site_id',$site_id)
                        ->where('entered_at', '>=', $first_data)
                        ->where('entered_at', '<', $first_data_next)
                        ->count();
                    $return_data['date'][] = $first_data;
                    $return_data['register'][] = $register_counts;
                    $return_data['sign'][] = $sign_counts;
                    $first_data = $first_data_next;
                }
            }
//            dd($return_data);
            return view('admin::backend.charts.charts_bar_register',['data'=>$return_data]);
        }else{
            return redirect('/site');
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function classPie(Request $request) {
        $site_id = $request->input('site_id');
        return view('admin::backend.charts.charts_pie_class', [
            'phases' => ThyroidClassPhase::where('site_id',$site_id)->get(),
            'title' => Site::find($site_id),
        ]);
    }
}
