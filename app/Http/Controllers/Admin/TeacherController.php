<?php

namespace App\Http\Controllers\Admin;

use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

/**
 * Class TeacherController
 * @package App\Http\Controllers\Admin
 */
class TeacherController extends Controller
{
    /**
     * Data filtering.
     * @param Request $request
     * @return array
     */
    private function formatData($request)
    {
        $data = [
            'photo_url' => $request->input('photo_url'),
            'name' => $request->input('name'),
            'office' => $request->input('office'),
            'title' => $request->input('title'),
            'introduction' => $request->input('introduction')
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
        return view('backend.tables.teacher', ['teachers' => Teacher::paginate('5')]);
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
        Teacher::create($data);
        \Session::flash('alert', [
            'type' => 'success',
            'title' => '添加成功',
            'message' => '添加讲师成功',
        ]);
        return redirect('/admin/teacher');
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
        $teacher = Teacher::find($id);
        $teacher->update($data);

        \Session::flash('alert', [
            'type' => 'success',
            'title' => '修改成功',
            'message' => '修改讲师成功',
        ]);

        return redirect('/admin/teacher');
    }

    /**
     * Remove the specified resource from storage
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        if (Teacher::find($id)->delete()) {
            \Session::flash('alert', [
                'type' => 'success',
                'title' => '删除成功',
                'message' => '删除讲师成功',
            ]);
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false
            ]);
        }
    }
}
