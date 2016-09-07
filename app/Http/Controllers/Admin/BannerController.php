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
            'weight' => $request->input('weight'),
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
        return view('backend.tables.banner', ['banners' => Banner::paginate('2')]);
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
        Banner::create($data);
        return redirect('/admin/banner');
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
        $banner = Banner::find($id);
        $banner->update($data);

        return redirect('/admin/banner');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        return response()->json([
            'success' => banner::find($id)->delete()
        ]);
    }
}
