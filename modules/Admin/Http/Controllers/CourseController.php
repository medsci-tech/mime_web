<?php

namespace Modules\Admin\Http\Controllers;

use Modules\Admin\Entities\ThyroidClassPhase;
use Illuminate\Http\Request;
use Modules\Admin\Entities\ThyroidClassCourse as Model;
use App\Http\Requests;

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
            return view('admin::backend.course.index', [
                'lists' => Model::where('site_id',$site_id)->paginate(10),
                'phases' => ThyroidClassPhase::all(),
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
        if($exercise_ids){
            $data['exercise_ids'] = implode(',', $exercise_ids);
        }else{
            $data['exercise_ids'] = '';
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

}
