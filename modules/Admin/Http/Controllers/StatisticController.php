<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\City;
use App\Http\Requests;
use Pingpong\Modules\Routing\Controller;
use Modules\Admin\Entities\Student;
use Modules\Admin\Entities\ThyroidClassPhase;

/**
 * Class StatisticController
 * @package App\Http\Controllers\Admin
 */
class StatisticController extends Controller
{
    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
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
    function registerBar()
    {
        return view('admin::backend.charts.charts_bar_register');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function classPie() {
        return view('admin::backend.charts.charts_pie_class', [
            'phases' => ThyroidClassPhase::all()
        ]);
    }
}
