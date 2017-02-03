<?php namespace Modules\Openclass\Http\Controllers;

use Pingpong\Modules\Routing\Controller;

class OpenClassController extends Controller {
	
	public function index()
	{
		return view('openclass::index');
	}
	
}