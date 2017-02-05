<?php namespace Modules\Airclass\Http\Controllers;

use Pingpong\Modules\Routing\Controller;
class AirClassController extends Controller {
	
	public function index()
	{
	    //test  redis
        $key = 'user:name:6';
        $name = 'loose';
        //将用户名存储到Redis中
        \Redis::set($key,$name);
        //判断指定键是否存在
        if(\Redis::exists($key)){
            //根据键名获取键值
            //dd(\Redis::get($key));
        }

		return view('airclass::index');
	}
	
}

