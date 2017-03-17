<?php

namespace Modules\Admin\Http\Controllers;

use Modules\Admin\Entities\Exercise as Model;
use Illuminate\Http\Request;

use App\Http\Requests;

class ExerciseController extends Controller
{
    public function index(Request $request){

        $site_id = $request->input('site_id');
        if($site_id){
            return view('admin::backend.exercise.index', [
                'lists' => Model::where('site_id',$site_id)->paginate(10),
            ]);
        }else{
            return redirect('/site');
        }
    }
    public function index_table(Request $request){

        $site_id = $request->input('site_id');
        if($site_id){
            return view('admin::backend.exercise.index_table', [
                'lists' => Model::where(['site_id' => $site_id, 'status' => 1])->get(),
            ]);
        }else{
            return redirect('/site');
        }
    }

    public function save(Request $request){
        $site_id = $request->input('site_id');
        $id = $request->input('id');
        $option = $request->input('option');
        $answer = $request->input('answer');
        $type = $request->input('type');
        $request_all = $request->all();
        $request_all['option'] = serialize($option);
        if($type == 1 && $answer){
            $request_all['answer'] = implode(',', $answer);
        }else{
            $request_all['answer'] = '';
        }
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
        return redirect(url('/exercise?site_id='.$site_id));
    }

    public function destroy(Request $request){
        $site_id = $request->input('site_id');
        $result = Model::find($request->input('id'))->delete();
        if($result) {
            $this->flash_success();
        }else{
            $this->flash_error();
        }
        return redirect(url('/exercise?site_id='.$site_id));
    }

    public function getList(Request $request){
        $ids = $request->input('ids');
        $data = [];
        if($ids){
            $ids = explode(',', $ids);
            $lists = Model::whereIn('id',$ids)->get();
            if($lists){
                foreach ($lists as $i => $list){
                    $data[$i]['id'] = $list->id;
                    $data[$i]['type'] = $list->type($list->type);
                    $data[$i]['question'] = $list->question;
                    $data[$i]['option'] = count(unserialize($list->option));
                    $data[$i]['answer'] = $list->answer;
                }
            }
        }
        return ['code' => 200, 'data' => $data];
    }
}
