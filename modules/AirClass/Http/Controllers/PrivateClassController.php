<?php namespace Modules\AirClass\Http\Controllers;

use App\Models\PrivateClass;
use Illuminate\Http\Request;
use Modules\Admin\Http\Controllers\UploadController;

class PrivateClassController extends Controller
{
	protected $term; // 期数

	public function __construct()
	{
		$this->middleware('login');
		parent::__construct();
		$this->term = config('params')['private_class_term'];
	}

	public function index(){
		return view('airclass::private-class.index');
	}


	public function sign(Request $request){
		$req_data = $request->all();
		$file = $request->file('file');
		if(!$file){
			return $this->return_data_format(422, '请添加病例文件');
		}
		if($req_data['teacher_id']){
			return $this->return_data_format(422, '请选择讲师');
		}
		if($req_data['bespoke_at']){
			return $this->return_data_format(422, '请选择预约时间');
		}
		$upload = new UploadController();
		$file_save_name =  $this->term . '-' . $this->user['phone'];
		$upload_res = $upload->create($file, $file_save_name);
		if($upload_res['code'] == 200){
			$private = PrivateClass::create([
				'doctor_id' => $this->user['id'],
				'teacher_id' => $req_data['teacher_id'],
				'term' => $this->term,
				'upload_id' => $upload_res['id'],
				'site_id' => $this->site_id,
				'status' => 0,
				'bespoke_at' => $req_data['bespoke_at'],
			]);
			if($private){
				return $this->return_data_format(200, '私教课报名成功');
			}else{
				return $this->return_data_format(500, '私教课报名失败');
			}
		}else{
			return $this->return_data_format(500, '病例上传失败');
		}
	}


	
}

