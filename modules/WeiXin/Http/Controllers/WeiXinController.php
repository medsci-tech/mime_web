<?php namespace Modules\Weixin\Http\Controllers;

use Pingpong\Modules\Routing\Controller;

class WeiXinController extends Controller {
	
	public function index()
	{
		return view('weixin::index');
	}
	
}