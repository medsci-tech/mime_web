<?php namespace Modules\AirClass\Http\Controllers;
use Illuminate\Http\Request;
use Modules\AirClass\Entities\ThyroidClassCourse;
use DB;
class SearchController extends Controller
{

    protected $matchers = [
        'TomLingham\Searchy\Matchers\ExactMatcher'                 => 50,
        'TomLingham\Searchy\Matchers\StartOfStringMatcher'         => 50,
        'TomLingham\Searchy\Matchers\AcronymMatcher'               => 42,
        'TomLingham\Searchy\Matchers\ConsecutiveCharactersMatcher' => 40,
        'TomLingham\Searchy\Matchers\StartOfWordsMatcher'          => 35,
        'TomLingham\Searchy\Matchers\StudlyCaseMatcher'            => 32,
        'TomLingham\Searchy\Matchers\InStringMatcher'              => 30,
        'TomLingham\Searchy\Matchers\TimesInStringMatcher'         => 8,
    ];
    /**
     * @return mixed
     */
	public function index(Request $request)
	{

        return view('airclass::home.search',[
            'units' => 11,
        ]);

	}

    /**
     * 关键词搜索
     * @author      lxhui<772932587@qq.com>
     * @since 1.0
     * @return array
     */
    public function keywords($id)
    {
        $units = DB::table('thyroid_class_courses')->whereRaw('FIND_IN_SET(?,keyword_id)', [$id])->get();
        return view('airclass::home.search',[
            'units' => $units,
        ]);
    }

}

