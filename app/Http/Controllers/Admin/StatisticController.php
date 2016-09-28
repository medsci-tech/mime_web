<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Student;

/**
 * Class StatisticController
 * @package App\Http\Controllers\Admin
 */
class StatisticController extends Controller
{
    function update() {
        $cities = City::all();

        foreach($cities as $city) {
            $city->student_count = Student::where('area', $city->area)->count();
            $city->save();
        }
        return redirect('/admin/statistic/map');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function map() {
        return view('backend.charts.charts_map', [
            'cities' => City::all()
        ]);
    }
}
