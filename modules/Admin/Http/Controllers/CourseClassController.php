<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\CourseClass as Model;
use Illuminate\Http\Request;
use App\Http\Requests;

class CourseClassController extends Controller
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
            return view('admin::backend.course-class.index', [
                'lists' => Model::where('site_id',$site_id)->paginate(10),
            ]);
        }else{
            return redirect('/site');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */

    public function save(Request $request){
        $site_id = $request->input('site_id');
        $id = $request->input('id');
        $request_all = $request->all();
//        dd($request_all);
        if($id){
            $result = Model::find($id)->update($request_all);
        }else{
            $result = Model::create($request_all);
        }
        if($result) {
            $this->flash_success();
        }else{
            $this->flash_error();
        }
        return redirect('/course-class?site_id='.$site_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Request $request)
    {
        $site_id = $request->input('site_id');
        $result = Model::find($request->input('id'))->delete();
        if($result) {
            $this->flash_success();
        }else{
            $this->flash_error();
        }
        return redirect('/course-class?site_id='.$site_id);
    }

    public function getList(){
        return 'he';
    }
}
