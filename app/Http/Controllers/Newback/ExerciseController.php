<?php

namespace App\Http\Controllers\Newback;

use App\Models\Exercise as Model;
use App\Models\ThyroidClassCourse;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ExerciseController extends Controller
{
    public function index(){
        $lists = Model::paginate('10');
        return view('newback.exercise.index',[
            'lists' => $lists,
        ]);
    }

    public function save(Request $request){
        $id = $request->input('id');
        $option = $request->input('option');
        $answer = $request->input('answer');
        $request_all = $request->all();
        $request_all['option'] = serialize($option);
        if($answer){
            $request_all['answer'] = implode(',', $answer);
        }
        if($id){
            $result = Model::find($id)->update($request_all);
        }else{
            $result = Model::create($request_all);
        }
        if($result) {
            \Session::flash('alert', [
                'type' => 'success',
                'title' => '操作成功',
            ]);
        }else{
            \Session::flash('alert', [
                'type' => 'danger',
                'title' => '操作失败',
            ]);
        }
        return redirect(url('newback/exercise'));
    }

    public function destroy(Request $request){
        $result = Model::find($request->input('id'))->delete();
        if($result) {
            \Session::flash('alert', [
                'type' => 'success',
                'title' => '操作成功',
            ]);
        }else{
            \Session::flash('alert', [
                'type' => 'danger',
                'title' => '操作失败',
            ]);
        }
        return redirect(url('newback/exercise'));
    }
}
