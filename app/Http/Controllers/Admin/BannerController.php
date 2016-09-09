<?php

namespace App\Http\Controllers\Admin;

use App\Models\Banner;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

/**
 * Class BannerController
 * @package App\Http\Controllers\Admin
 */
class BannerController extends Controller
{
    /**
     * Data filtering.
     *
     * @return array
     */
    private function formatData($request)
    {
        $data = [
            'image_url' => $request->input('image_url'),
            'href_url' => $request->input('href_url'),
            'status' => $request->input('status'),
            'page' => $request->input('page'),
            'weight' => $request->input('weight')
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
        return view('backend.tables.banner', ['banners' => Banner::paginate('5')]);
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
        Banner::create($data);

        \Session::flash('alert', [
            'type' => 'success',
            'title' => '添加成功',
            'message' => '添加Banner成功',
        ]);

        return redirect('/admin/banner');
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
        $banner = Banner::find($id);
        $banner->update($data);

        \Session::flash('alert', [
            'type' => 'success',
            'title' => '修改成功',
            'message' => '修改Banner成功',
        ]);
        return redirect('/admin/banner');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        return response()->json([
            'success' => banner::find($id)->delete(),
            'data' => [
                'type' => 'success',
                'title' => '删除成功',
                'message' => '删除Banner成功'
            ]
        ]);
    }
}
