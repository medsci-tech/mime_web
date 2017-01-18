<?php

namespace App\Http\Controllers\System;

use App\Models\Site as Model;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Symfony\Component\Debug\Tests\MockExceptionHandler;

class SiteController extends Controller
{
    public function index(){
        $lists = Model::paginate(10);
        return view('system.site.index',['lists' => $lists]);
    }

    public function store(Request $request){
        $res = Model::create($request->all());
        if($res){
            \Session::flash('alert', [
                'type' => 'success',
                'title' => '添加成功',
                'message' => '添加成功',
            ]);
        }
        return redirect(route('system.site.index'));
    }

    public function update(Request $request, $id)
    {
        $res = Model::find($id)->update($request->all());
        if($res) {
            \Session::flash('alert', [
                'type' => 'success',
                'title' => '修改成功',
                'message' => '修改成功',
            ]);
        }
        return redirect(route('system.site.index'));
    }

    public function destroy($id)
    {
        if (Model::find($id)->delete()) {
            \Session::flash('alert', [
                'type' => 'success',
                'title' => '删除成功',
                'message' => '删除成功',
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
