<?php

namespace App\Http\Controllers\Admin;

use App\Models\Banner as Model;
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function index(Request $request)
    {
        $site_id = $request->input('site_id');
        if($site_id){
            return view('backend.tables.banner', ['banners' => Model::where('site_id',$site_id)->paginate(5)]);
        }else{
            return redirect('newback/site');
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $site_id = $request->input('site_id');
        $result = Model::create($request->all());
        if($result) {
            $this->flash_success();
        }else{
            $this->flash_error();
        }
        return redirect('/admin/banner?site_id='.$site_id);
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
        $site_id = $request->input('site_id');
        $result = Model::find($id)->update($request->all());
        if($result) {
            $this->flash_success();
        }else{
            $this->flash_error();
        }
        return redirect('/admin/banner?site_id='.$site_id);
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
        $result = Model::find($id)->delete();
        if($result) {
            $this->flash_success();
            return response()->json([
                'success' => true
            ]);
        }else{
            $this->flash_error();
            return response()->json([
                'success' => false
            ]);
        }
    }
}
