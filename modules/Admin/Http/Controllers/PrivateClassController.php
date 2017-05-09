<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\PrivateClass as Model;
use Illuminate\Http\Request;

class PrivateClassController extends Controller
{
    public function index(Request $request){
        $site_id = $request->input('site_id');
        if($site_id){
            $lists = Model::where('site_id',$site_id)->paginate(10);
            return view('admin::backend.private-class.index', [
                'lists' => $lists,
            ]);
        }else{
            return redirect('/site');
        }
    }

    public function save(Request $request){
        $site_id = $request->input('site_id');
        $id = $request->input('id');
        $request_all = $request->all();
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
        return redirect(url('/private-class?site_id='.$site_id));
    }

}
