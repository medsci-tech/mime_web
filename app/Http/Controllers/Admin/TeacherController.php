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
     *
     * @return array
     */
    private function formatData($request)
    {
        $data = [
            'photo_url' => $request->input('photo_url'),
            'name' => $request->input('name'),
            'office' => $request->input('office'),
            'title' => $request->input('title'),
            'introduction' => $request->input('introduction'),
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
        return view('backend.tables.teacher', ['teachers' => Teacher::paginate('2')]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
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
        return redirect('/admin/teacher');
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

        return redirect('/admin/teacher');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        return response()->json([
            'success' => Teacher::find($id)->delete(),
            'data' => [
                'type' => '',
                'title' => '',
                'message' => ''
            ]
        ]);
    }
}
