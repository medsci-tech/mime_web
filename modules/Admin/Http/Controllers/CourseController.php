<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\CourseClass;
use App\Models\StudyLog;
use Modules\Admin\Entities\Teacher;
use Modules\Admin\Entities\ThyroidClassCourse;
use Modules\Admin\Entities\ThyroidClassPhase;
use Illuminate\Http\Request;
use Modules\Admin\Entities\ThyroidClassCourse as Model;
use App\Http\Requests;
use Modules\AirClass\Entities\Keyword;

class CourseController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $site_id = $request->input('site_id');
        if($site_id){
            $keywords = Keyword::where(['site_id' => $site_id])->get();
//            dd($keywords);
            return view('admin::backend.course.index', [
                'lists' => Model::where('site_id',$site_id)->paginate(10),
                'phases' => ThyroidClassPhase::where(['site_id' => $site_id])->get(),
                'course_classes' => CourseClass::where(['status' => 1, 'site_id' => $site_id])->get(),
                'teachers' => Teacher::where(['site_id' => $site_id])->get(),
                'keywords' => $keywords,
            ]);
        }else{
            return redirect('/site');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $site_id = $request->input('site_id');
        $data = $request->all();
        $id = $request->input('id');
        $exercise_ids = $request->input('exercise_ids');
        $keyword_id = $request->input('keyword_id');
        $course_classes = CourseClass::find($data['course_class_id']);
        if(!$course_classes['has_teacher']){
            // 如果类别没有讲师，则teacher_id为空
            $data['teacher_id'] = 0;
        }
        if(!$course_classes['has_children']){
            // 如果类别没有所属单元，则thyroid_class_phase_id为空
            $data['thyroid_class_phase_id'] = 0;
        }
        if($exercise_ids){
            $data['exercise_ids'] = implode(',', $exercise_ids);
        }else{
            $data['exercise_ids'] = '';
        }
        if($keyword_id){
            $data['keyword_id'] = implode(',', $keyword_id);
        }else{
            $data['keyword_id'] = '';
        }
        if($id){
            $result = Model::find($id)->update($data);
        }else{
            $result = Model::create($data);
        }
        if($result) {
            $this->flash_success();
        }else{
            $this->flash_error();
        }
        return redirect('/course?site_id='.$site_id);
    }

    public function status(Request $request)
    {
        $id = $request->input('id');
        $result = null;
        if($id){
            $key = $request->input('key');
            $value = $request->input('value');
            $update = [];
            if($key == 'recommend'){
                if($value == 1){
                    $update['recomment_time'] = time();
                }else{
                    $update['recomment_time'] = 0;
                }
            }
            if($update){
                $result = Model::find($id)->update($update);
            }
        }
        if($result) {
            return ['code' => 200];
        }else{
            return ['code' => 500];
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Request $request)
    {
        $site_id = $request->input('site_id');
        $result = Model::find($request->input('id'))->delete();
        if($result) {
            $this->flash_success();
        }else{
            $this->flash_error();
        }
        return redirect('/course?site_id='.$site_id);
    }


    public function refresh_video_duration(){
        $courses = ThyroidClassCourse::where([
            'site_id' => 2,
        ])->get();
        foreach ($courses as $course){
            StudyLog::where('course_id',$course->id)->update(['video_duration' => $course->video_duration]);
        }
        dd('ok');
    }

}
