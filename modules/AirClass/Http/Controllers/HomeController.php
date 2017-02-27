<?php namespace Modules\Airclass\Http\Controllers;

use App\Models\Banner;
use App\Models\ThyroidClass;
use Modules\Admin\Entities\ThyroidClassCourse;
use Pingpong\Modules\Routing\Controller;
class HomeController extends Controller
{

    protected $site_id = 1; // airClass site_id

	public function index()
	{
        // 轮播图
        $banners = Banner::where(['site_id' => $this->site_id, 'status' => 1])->get();
        // 课程介绍
        $classes = ThyroidClass::where(['site_id' => $this->site_id])->get();
        // 课程推荐
        $recommend_classes = ThyroidClassCourse::where(['site_id' => $this->site_id])->orderBy('recomment_time')->limit(5)->get();

		dd($recommend_classes);
		return view('airclass::home.index',[
            'banners' => $banners,
            'classes' => $classes,
            'recommend_classes' => $recommend_classes,
        ]);
	}


    /**
     * @param Request $request
     */
    public function questions(Request $request)
    {

    }

    /**
     * @param Request $request
     */
    public function phases(Request $request)
    {

    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function enter()
    {
        $student = Student::find(\Session::get('studentId'));
        if ($student->entered_at) {
            return response()->json(['success' => false, 'error_message' => '已报名']);
        } else {
            $student->entered_at = Carbon::now();
            $student->save();
            \Redis::command('INCR', ['enter_count']);
            return response()->json(['success' => true]);
        }
    }
	
}

