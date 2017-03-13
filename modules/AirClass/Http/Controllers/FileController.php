<?php namespace Modules\AirClass\Http\Controllers;
use Illuminate\Http\Request;
use Storage;
use App\Http\Requests;
class FileController  extends Controller
{
    /**
     * 文件上传方法
     * @author      lxhui<772932587@qq.com>
     * @since 1.0
     * @return array
     */
    public function upload(Request $request)
    {
        if ($request->isMethod('post')) {
            if(!$request->hasFile('file')){
                exit('上传文件为空!');
            }
            $file = $request->file('file');
            // 文件是否上传成功
            if ($file->isValid()) {
                // 获取文件相关信息
                $originalName = $file->getClientOriginalName(); //源文件名
                $ext = $file->getClientOriginalExtension();    //文件拓展名
                $type = $file->getClientMimeType(); //文件类型
                $realPath = $file->getRealPath();   //临时文件的绝对路径
                $fileName = date('Y-m-d-H-i-s').'-'.uniqid().'.'.$ext;  //新文件名
                // 使用新建的uploads本地存储空间（目录）
                $bool = Storage::disk('uploads')->put($fileName, file_get_contents($realPath));

            }
        }

    }
	
}

