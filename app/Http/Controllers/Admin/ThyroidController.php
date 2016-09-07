<?php

namespace App\Http\Controllers\Admin;

use App\Models\ThyroidClass;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ThyroidController extends Controller
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
        return view('backend.tables.thyroid', ['thyroids' => ThyroidClass::paginate('10')]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.backend.thyroid.create');
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
        ThyroidClass::create($data);
        return redirect('/admin/thyroid');
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
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $data = $this->formatData($request);
        $thyroid = ThyroidClass::find($id);
        $thyroid->update($data);

        return redirect('/admin/thyroid');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        return response()->json([
            'success' => ThyroidClass::find($id)->delete(),
            'data' => [
                'type' => '',
                'title' => '',
                'message' => ''
            ]
        ]);
    }
}
