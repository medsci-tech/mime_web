<?php

namespace App\Http\Controllers\Admin;

use App\Models\Teacher;
use App\Models\ThyroidClass;
use App\Models\ThyroidClassPhase;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

/**
 * Class PhaseController
 * @package App\Http\Controllers\Admin
 */
class PhaseController extends Controller
{

    /**
     * Data filtering.
     *
     * @param $request
     * @return array
     */
    private function formatData($request)
    {
        $data = [
            'title' => $request->input('title'),
            'comment' => $request->input('comment'),
            'main_teacher_id' => $request->input('main_teacher_id'),
            'logo_url' => $request->input('logo_url'),
            'sequence' => $request->input('sequence'),
            'is_show' => $request->input('is_show')
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
        return view('backend.tables.phase', [
            'phases' => ThyroidClassPhase::paginate('20'),
            'teachers' => Teacher::all()
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
        ThyroidClassPhase::create($data);

        \Session::flash('alert', [
            'type' => 'success',
            'title' => '添加成功',
            'message' => '添加单元成功',
        ]);

        return redirect('/admin/phase');
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
        if (ThyroidClassPhase::find($id)->delete()) {
            \Session::flash('alert', [
                'type' => 'success',
                'title' => '删除成功',
                'message' => '删除单元成功'
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
        $teacher = ThyroidClassPhase::find($id);
        $teacher->update($data);

        \Session::flash('alert', [
            'type' => 'success',
            'title' => '修改成功',
            'message' => '修改单元成功',
        ]);

        return redirect('/admin/phase');
    }
}
