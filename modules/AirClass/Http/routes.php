<?php
/* 空中课堂子域名路由配置 */
Route::group(['domain' => env('AIR_DOMAIN'),'middleware' => 'web', 'prefix' => '', 'namespace' => 'Modules\AirClass\Http\Controllers'], function()
{
	Route::get('/', 'AirClassController@index');
});