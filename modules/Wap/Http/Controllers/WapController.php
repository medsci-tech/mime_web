<?php namespace Modules\Wap\Http\Controllers;

use Pingpong\Modules\Routing\Controller;

class WapController extends Controller {
	
	public function index()
	{
		return view('wap::index');
	}
	
}