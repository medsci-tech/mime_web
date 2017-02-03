<?php

namespace Modules\Admin\Http\Controllers;
use Modules\Admin\Entities\Teacher as Model;
use Illuminate\Http\Request;
use App\Http\Requests;
use Pingpong\Modules\Routing\Controller;

/**
 * Class TeacherController
 * @package App\Http\Controllers\Admin
 */
class TeacherController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin::backend.tables.teacher', ['teachers' => Model::paginate('5')]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $result = Model::create($request->all());
        if($result) {
            $this->flash_success();
        }else{
            $this->flash_error();
        }
        return redirect('/teacher');
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
        $result = Model::find($id)->update($request->all());
        if($result) {
            $this->flash_success();
        }else{
            $this->flash_error();
        }

        return redirect('/teacher');
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
