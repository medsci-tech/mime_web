<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\ThyroidClassPhase;

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
        return redirect('/admin/statistic/map');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function areaMap()
    {
        return view('backend.charts.charts_map_area', [
            'cities' => City::all()
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function provinceMap()
    {
        return view('backend.charts.charts_map_province');
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
        return view('backend.charts.charts_bar_register');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function classPie() {
        return view('backend.charts.charts_pie_class', [
            'phases' => ThyroidClassPhase::all()
        ]);
    }
}
