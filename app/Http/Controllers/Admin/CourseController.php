<?php

namespace App\Http\Controllers\Admin;

use App\Models\Teacher;
use App\Models\ThyroidClassPhase;
use Illuminate\Http\Request;
use App\Models\ThyroidClasscourse;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class CourseController extends Controller
{
    /**
     * Data filtering.
     *
     * @return array
     */
    private function formatData(Request $request)
    {
        $data = [
            'title' => $request->input('title'),
            'comment' => $request->input('title'),
            'logo_url' => $request->input('logo_url'),
            'sequence' => $request->input('sequence'),
            'thyroid_class_phase_id' => $request->input('thyroid_class_phase_id'),
            'qcloud_file_id' => $request->input('qcloud_file_id'),
            'qcloud_app_id' => $request->input('qcloud_app_id'),
        ];


        return $data;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('backend.tables.course', [
            'courses' => ThyroidClassCourse::paginate('10'),
            'phases' => ThyroidClassPhase::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.backend.course.create', [
            'phases' => ThyroidClassPhase::all(),
            'teachers' => Teacher::all(),
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
        $data = $this->formatData($request);
        ThyroidClassCourse::create($data);
        return redirect('/admin/course');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     */
    public function edit($id)
    {

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        return response()->json([
            'success' =>ThyroidClassCourse::find($id)->delete()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {

        $data = $this->formatData($request);
        $teacher = ThyroidClasscourse::find($id);
        $teacher->update($data);

        return redirect('/admin/course');
    }
}
