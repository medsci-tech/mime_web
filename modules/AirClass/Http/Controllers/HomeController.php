<?php namespace Modules\Airclass\Http\Controllers;

use App\Models\Banner;
use App\Models\ThyroidClass;
use Modules\Admin\Entities\Teacher;
use Modules\Admin\Entities\ThyroidClassCourse;
use Modules\Admin\Entities\ThyroidClassPhase;

class HomeController extends Controller
{
    protected $public_class_id = 1; // 空课项目公开课id
    protected $answer_class_id = 2; // 空课项目答疑课id
    protected $private_class_id = 3; // 空课项目私教课id

    /**
     * 首页
     * @return mixed
     */
	public function index()
	{
        // 轮播图
        $banners = Banner::where(['site_id' => $this->site_id, 'status' => 1, 'page' => 'index'])->get();
        // 课程介绍
        $classes = ThyroidClass::where(['site_id' => $this->site_id])->get();
        // 课程推荐
        $recommend_classes = ThyroidClassCourse::where(['site_id' => $this->site_id])->orderBy('recomment_time')->limit(5)->get();

        // 公开课
        $public_class_units = ThyroidClassPhase::where(['site_id' => $this->site_id, 'is_show' => 1])->get(); // 单元列表
        $public_class_courses = [];
        if($public_class_units){
            foreach ($public_class_units as $public_class_unit){
                $courses = ThyroidClassCourse::where([
                    'site_id' => $this->site_id,
                    'is_show' => 1,
                    'course_class_id' => $this->public_class_id,
                    'thyroid_class_phase_id' => $public_class_unit->id,
                ])->get();
                if($courses->count()){
                    $public_class_courses[] = $courses;
                }
            }
        }
        //答疑课
        $answer_class_teachers = Teacher::where(['site_id' => $this->site_id])->get(); // 讲师列表
        $answer_class_courses = [];
        if($answer_class_teachers){
            foreach ($answer_class_teachers as $answer_class_teacher){
                $courses = ThyroidClassCourse::where([
                    'site_id' => $this->site_id,
                    'is_show' => 1,
                    'course_class_id' => $this->answer_class_id,
                    'teacher_id' => $answer_class_teacher->id,
                ])->get();
                if($courses->count()){
                    $answer_class_courses[] = $courses;
                }
            }
        }
        // 私教课
//dd($recommend_classes);
		return view('airclass::home.index',[
            'banners' => $banners,
            'classes' => $classes,
            'recommend_classes' => $recommend_classes, // 课程推荐
            'public_class_courses' => $public_class_courses, // 公开课
            'answer_class_courses' => $answer_class_courses, // 答疑课
        ]);
	}

    /**
     * 公开课
     */
    public function public_class()
    {
        return view('airclass::home.public_class');
    }

    /**
     * 答疑课
     */
    public function answer_class()
    {
        return view('airclass::home.answer_class');
    }

    /**
     * 私教课
     */
    public function private_class()
    {
        return view('airclass::home.private_class');
    }

    
    /**
     * 帮助
     */
    public function help()
    {
        return view('airclass::home.help');
    }
	
}

