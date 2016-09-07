<?php

namespace App\Http\Controllers\Admin;

use App\Models\Teacher;
use App\Models\ThyroidClass;
use App\Models\ThyroidClassPhase;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class PhaseController extends Controller
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
            'logo_url' => $request->input('logo_url')
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
}
