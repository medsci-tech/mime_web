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
            'comment' => $request->input('title'),
            'main_teacher_id' => $request->input('main_teacher_id')
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.backend.phase.create', [
            'thyroids' => ThyroidClass::all(),
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
        ThyroidClassPhase::create($data);
        return redirect('/admin/phase');
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
            'success' =>ThyroidClassPhase::find($id)->delete()
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
        $teacher = ThyroidClassPhase::find($id);
        $teacher->update($data);

        return redirect('/admin/phase');
    }
}
