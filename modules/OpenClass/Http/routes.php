<?php
/* 甲状腺公开课子域名路由配置 */
//Route::group(['domain' => 'open.mime.org.dev','middleware' => 'web', 'prefix' => '', 'namespace' => 'Modules\OpenClass\Http\Controllers'], function()
//{
//    Route::get('/', 'ThyroidClass\ThyroidClassController@index');
//});
Route::group(['domain' =>env('OPEN_DOMAIN'),'middleware' => 'web', 'prefix' => '', 'namespace' => 'Modules\OpenClass\Http\Controllers'], function()
{
	#Route::get('/', 'OpenClassController@index');
    Route::get('/', 'HomeController@index');
});