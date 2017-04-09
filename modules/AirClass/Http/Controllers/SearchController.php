<?php namespace Modules\AirClass\Http\Controllers;
use Illuminate\Http\Request;
use Modules\AirClass\Entities\ThyroidClassCourse;
use DB;
use Modules\AirClass\Entities\Keyword;
class SearchController extends Controller
{

    /**
     * 文本关键词搜索
     * @author      lxhui<772932587@qq.com>
     * @since 1.0
     * @return array
     */
	public function index(Request $request)
	{
        $keyword = $request->keyword;
        $units = DB::table('thyroid_class_courses')
            ->leftJoin('thyroid_class_phases', function ($join) use ($keyword) {
                $join->on('thyroid_class_courses.thyroid_class_phase_id', '=', 'thyroid_class_phases.id')
                ->where('thyroid_class_phases.site_id', '=', $this->site_id);
            })
            ->select('thyroid_class_courses.id', 'thyroid_class_courses.play_count','thyroid_class_courses.title','thyroid_class_courses.logo_url','thyroid_class_courses.comment','thyroid_class_courses.course_type')
            ->where(['thyroid_class_courses.site_id'=>$this->site_id])
            ->where(['thyroid_class_courses.is_show'=> 1])
            ->where('thyroid_class_courses.title','like','%'.$keyword.'%')
            ->orWhere('thyroid_class_phases.title','like','%'.$keyword.'%')
            ->paginate(20);
        return view('airclass::home.search', compact('units','keyword'));
	}

    /**
     * 关键词搜索
     * @author      lxhui<772932587@qq.com>
     * @since 1.0
     * @return array
     */
    public function keywords(Request $request)
    {
        $id = $request->id;
        $keyword =  Keyword::find($id)->name;
        $units = DB::table('thyroid_class_courses')->where(['site_id'=>$this->site_id,'is_show'=> 1])->whereRaw('FIND_IN_SET(?,keyword_id)', [$id])->paginate(20);
        return view('airclass::home.search', compact('units','keyword'));
    }

}

