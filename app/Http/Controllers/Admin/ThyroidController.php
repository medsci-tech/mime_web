<?php

namespace App\Http\Controllers\Admin;

use App\Models\ThyroidClass;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

/**
 * Class ThyroidController
 * @package App\Http\Controllers\Admin
 */
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
            'comment' => $request->input('comment'),
            'logo_url' => $request->input('logo_url'),
            'banner_autopaly' => $request->input('banner_autopaly'),
            'latest_update_at' => $request->input('latest_update_at'),
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
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $data = $this->formatData($request);
        ThyroidClass::create($data);

        \Session::flash('alert', [
            'type' => 'success',
            'title' => '添加成功',
            'message' => '添加公开课成功'
        ]);
        return redirect('/admin/thyroid');
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

        \Session::flash('alert', [
            'type' => 'success',
            'title' => '修改成功',
            'message' => '添加公开课成功'
        ]);

        return redirect('/admin/thyroid');
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

        if (ThyroidClass::find($id)->delete()) {
            \Session::flash('alert', [
                'type' => 'success',
                'title' => '删除成功',
                'message' => '删除公开课成功'
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
