<?php

Route::group(['middleware' => 'web', 'prefix' => 'weixin', 'namespace' => 'Modules\WeiXin\Http\Controllers'], function()
{
	Route::get('/', 'WeiXinController@index');
});