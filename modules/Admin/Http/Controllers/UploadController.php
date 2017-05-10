<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\Upload as Model;

use zgldh\QiniuStorage\QiniuStorage;

class UploadController extends Controller
{
    public function create($file,$file_name = null){
        $disk = QiniuStorage::disk('qiniu');
        if($file_name){
            $save_file_name = $file_name.'.' . $file->getClientOriginalExtension();
        }else{
            $save_file_name = $file->getClientOriginalName();
        }
        // 当文件大于10M 使用分片上传 1024 * 1024 * 10
        if($file->getSize() > 1024 * 1024 * 10){
            $upload_res = $disk->put($save_file_name, fopen(file_get_contents($file->getRealPath()), 'r+'));
        }else{
            $upload_res = $disk->put($save_file_name, file_get_contents($file->getRealPath()));
        }
        if($upload_res){
            $disk->downloadUrl($save_file_name);
            $model = Model::create([
                'old_name' => $file->getClientOriginalName(),
                'new_name' => $save_file_name,
                'path' => $disk->downloadUrl($save_file_name),
                'size' => $file->getSize(),
            ]);
            if($model){
                return ['code' => 200, 'id' => $model->id];
            }else{
                return ['code' => 500];
            }
        }else{
            return ['code' => 501];
        }
    }


}
