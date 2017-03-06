<?php
/* 空中课堂子域名路由配置 */
Route::group(['domain' => env('AIR_DOMAIN'),'middleware' => 'web', 'prefix' => '', 'namespace' => 'Modules\AirClass\Http\Controllers'], function()
{
	//首页
	Route::get('/', 'HomeController@index');
	Route::get('/class_introduce', 'HomeController@class_introduce');
	Route::get('/class_lists', 'HomeController@class_lists');
	Route::get('/sjk_class_introduce', 'HomeController@sjk_class_introduce');
	Route::get('/sjk_class_sign', 'HomeController@sjk_class_sign');
	Route::get('/help', 'HomeController@help');

	// 搜索
	Route::get('/search', 'SearchController@index');

	// 视频播放
	Route::get('/video/{id}', 'VideoController@index');
	Route::post('/video/comment/{id}', 'VideoController@comment');
	Route::post('/video/answer/{id}', 'VideoController@answer');

	// 用户公开访问
	Route::get('/register', 'UserPublicController@register_view');
	Route::get('/login', 'UserPublicController@login_view');
	Route::get('/logout', 'UserPublicController@logout');
	Route::get('/pwd_recover', 'UserPublicController@pwd_recover_view');

	//用户登录后访问
	Route::get('/user', 'UserController@index');
	Route::post('/user/info_update', 'UserController@info_update');
	Route::post('/user/pwd_update', 'UserController@pwd_update');
	Route::post('/user/comment', 'UserController@comment');
});