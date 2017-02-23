<?php namespace Modules\OpenClass\Http\Controllers;

use Pingpong\Modules\Routing\Controller;

class OpenClassController extends Controller {
	
	public function index()
	{
		return view('openclass::index');
	}
	
}