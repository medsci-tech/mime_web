<?php namespace Modules\AirClass\Http\Controllers;

use App\Models\KZKTClass;
use App\Models\PrivateClass;
use Illuminate\Http\Request;
use Modules\Admin\Entities\Teacher;
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
		$sign_check = $this->private_sign_check();
		if($sign_check['status']){
			$teachers = Teacher::where([
				'site_id' => $this->site_id,
				'is_pt' => 1,
				'belong_area' => $sign_check['data']['belong_area'],
			])->get();
			return view('airclass::private_class.index', [
				'teachers' => $teachers,
			]);
		}else{
			abort(404);
		}
	}

	public function sign(Request $request){
		$req_data = $request->all();
		$file = $request->file('file');
		if(!$file){
			return $this->return_data_format(422, '请添加病例文件');
		}
		if(!$req_data['teacher_id']){
			return $this->return_data_format(422, '请选择讲师');
		}
		if(!$req_data['bespoke_at']){
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

	/**
	 * @return array
	 */
	public function private_sign_check(){
		$status = false;
		$return_msg = '';
		$belong_area = '';
		if($this->user){
			if($this->user['rank'] < 3){
				$return_msg = '晋升到等级三即可报名';
			}else{
				$kzkt_classes = KZKTClass::where([
					'site_id' => $this->site_id,
					'status' => 1,
					'doctor_id' => $this->user['id'],
				])->orderBy('id','desc')->first();
				if($kzkt_classes){
					$belong_area = $kzkt_classes->volunteer->represent->belong_area;
				}
				if($belong_area){
					$my_sign = PrivateClass::where([
						['status', '>=', 0],
						'term' => config('params')['private_class_term'],
						'doctor_id' => $this->user['id'],
						'site_id' => $this->site_id,
					])->first();
					if($my_sign){
						$return_msg = '已报名';
					}else{
						$status = true;
					}
				}else{
					$return_msg = '找不到对应代表';
				}
			}
		}else{
			$return_msg = '登陆后才可报名';
		}

		// 上线后删除
		if($status == true && $this->user['phone'] != '13871000454'){
			$status = false;
			$return_msg = '私教课尚未开放';
		}

		return ['status' => $status, 'msg' => $return_msg, 'data' => ['belong_area' => $belong_area]];
	}


	
}

