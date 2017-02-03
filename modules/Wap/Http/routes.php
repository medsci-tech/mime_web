<?php

Route::group(['middleware' => 'web', 'prefix' => 'wap', 'namespace' => 'Modules\Wap\Http\Controllers'], function()
{
	Route::get('/', 'WapController@index');
});