<?php

namespace App\Http\Controllers\Admin;

use App\Models\ThyroidClassPhase;
use Illuminate\Http\Request;
use App\Models\ThyroidClassCourse;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class CourseController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index1()
    {
        return view('backend.tables.course', [
            'courses' => ThyroidClassCourse::paginate('10'),
            'phases' => ThyroidClassPhase::all(),
        ]);
    }

    public function index()
    {
        return view('newback.course.index', [
            'lists' => ThyroidClassCourse::paginate('10'),
            'phases' => ThyroidClassPhase::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $id = $request->input('id');
        $exercise_ids = $request->input('exercise_ids');
        if($exercise_ids){
            $data['exercise_ids'] = implode(',', $exercise_ids);
        }else{
            $data['exercise_ids'] = '';
        }
        if($id){
            $res = ThyroidClassCourse::find($id)->update($data);
        }else{
            $res = ThyroidClassCourse::create($data);
        }
        if($res) {
            \Session::flash('alert', [
                'type' => 'success',
                'title' => '操作成功',
            ]);
        }else{
            \Session::flash('alert', [
                'type' => 'danger',
                'title' => '操作失败',
            ]);
        }
        return redirect('/admin/course');
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
        $result = ThyroidClassCourse::find($request->input('id'))->delete();
        if($result) {
            \Session::flash('alert', [
                'type' => 'success',
                'title' => '操作成功',
            ]);
        }else{
            \Session::flash('alert', [
                'type' => 'danger',
                'title' => '操作失败',
            ]);
        }
        return redirect('/admin/course');
    }

}
