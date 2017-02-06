<?php

namespace Modules\Admin\Http\Controllers;

use Modules\Admin\Entities\Site as Model;
use Illuminate\Http\Request;

use App\Http\Requests;

class SiteController extends Controller
{
    public function index(){
        $lists = Model::paginate(20);
        return view('admin::backend.site.index',['lists' => $lists]);
    }

    public function save(Request $request){
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
        return redirect(url('/site'));
    }

}
