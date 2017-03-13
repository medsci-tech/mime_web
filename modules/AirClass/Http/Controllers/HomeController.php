<?php namespace Modules\AirClass\Http\Controllers;
use Illuminate\Http\Request;
use Modules\AirClass\Entities\Banner;
use Modules\AirClass\Entities\Teacher;
use Modules\AirClass\Entities\ThyroidClass;
use Modules\AirClass\Entities\CourseClass;

use Modules\AirClass\Entities\CourseApplies;
use Modules\AirClass\Entities\ThyroidClassCourse;
use Modules\AirClass\Entities\ThyroidClassPhase;

class HomeController extends Controller
{

    /**
     * 首页
     * @return mixed
     */
	public function index()
	{
        // 轮播图
        $banners = Banner::where([ 'status' => 1, 'page' => 'index'])->get();
        // 课程介绍
        $classes = ThyroidClass::first()->toArray();
        // 课程推荐
        $recommend_classes = ThyroidClassCourse::orderBy('recomment_time')->limit(5)->get();

        // 公开课
        $public_class_units = ThyroidClassPhase::limit(8)->where(['is_show' => 1])->get(); // 单元列表
        foreach($public_class_units as &$val)
        {
            $course_list = ThyroidClassPhase::limit(8)->find($val['id'])->thyroidClassCourses()->where(array('course_class_id'=>$this->public_class_id))->get();
            $val['course_list'] = $course_list;
        }

        $answer_class_courses = ThyroidClassCourse::where(array('course_class_id'=>$this->answer_class_id))->orderBy('id','desc')->limit(8)->get();//答疑课

        $class_info  = CourseClass::whereIn('id', array(2, 3, 4))->orderBy('id', 'asc')->groupBy('id')->get();

		return view('airclass::home.index',[
            'banners' => $banners,
            'classes' => $classes,
            'class_info' => $class_info,
            'recommend_classes' => $recommend_classes, // 课程推荐
            'public_class_courses' => $public_class_units, // 公开课
            'answer_class_courses' => $answer_class_courses, // 答疑课
        ]);
	}

    /**
     * 公开课列表
     * @author      lxhui<772932587@qq.com>
     * @since 1.0
     * @return array
     */
    public function public_class(Request $request)
    {
        $units = ThyroidClassPhase::where('is_show', 1)->paginate(10);
        foreach($units as &$val)
        {
            $course_list = ThyroidClassPhase::limit(10)->find($val['id'])->thyroidClassCourses()->where('course_class_id', $this->public_class_id)->get();
            $val['course_list'] = $course_list;
        }
        return view('airclass::home.public_class',[
            'units' => $units,
        ]);
    }

    /**
     * 答疑课列表
     * @author      lxhui<772932587@qq.com>
     * @since 1.0
     * @return array
     */
    public function answer_class(Request $request)
    {
        $units = ThyroidClassCourse::where(array('course_class_id'=>$this->answer_class_id)) //答疑课id
            ->orderBy('created_at','desc')
            ->groupBy('teacher_id')
            ->paginate(10);
        foreach($units as &$val)
        {
            $teach_info = Teacher::limit(10)->find($val['teacher_id'])->first();
            $val['teach_info'] = $teach_info;
            $course_list = ThyroidClassCourse::limit(10)->where(array('teacher_id'=>$val['teacher_id']))->orderBy('created_at','desc')->get();
            $val['course_list'] = $course_list;
        }
        return view('airclass::home.answer_class',[
            'units' => $units,
        ]);
    }

    /**
     * 私教课
     */
    public function private_class()
    {
        $doctor_id = 1;
        $count = CourseApplies::where('doctor_id',$doctor_id)->count();
        return view('airclass::home.private_class',[
            'count' => $count,
        ]);

    }

    
    /**
     * 帮助
     */
    public function help()
    {
        return view('airclass::home.help');
    }
	
}

