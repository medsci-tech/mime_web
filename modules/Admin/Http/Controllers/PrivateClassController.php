<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\PrivateClass as Model;
use Illuminate\Http\Request;

use zgldh\QiniuStorage\QiniuStorage;

class PrivateClassController extends Controller
{
    public function index(Request $request){
        $site_id = $request->input('site_id');
        if($site_id){
            $lists = Model::where('site_id',$site_id)->paginate(10);
            return view('admin::backend.private-class.index', [
                'lists' => $lists,
            ]);

//            $disk = QiniuStorage::disk('qiniu');
//            $token = $disk->uploadToken();
//            $a = $disk->exists('file.txt');                      //文件是否存在
//            $a = $disk->get('file.txt');                         //获取文件内容
//            $a = $disk->put('file.txt','haha');               //上传文件

//            dd($token);
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
