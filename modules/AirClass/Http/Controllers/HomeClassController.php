<?php namespace Modules\Airclass\Http\Controllers;

use Pingpong\Modules\Routing\Controller;
class HomeClassController extends Controller {
	
	public function index()
	{
		return view('airclass::index');
	}
	
}

