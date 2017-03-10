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
	Route::post('/video/comment/{id}', 'VideoController@comment'); // 评论请求
	Route::post('/video/answer/{id}', 'VideoController@answer'); // 答题请求

	// 用户公开访问
	Route::get('/register', 'UserPublicController@register_view'); //注册视图
	Route::post('/register/post', 'UserPublicController@register_post'); // 注册请求
	Route::get('/login', 'UserPublicController@login_view'); // 登陆视图
	Route::post('/login_account/post', 'UserPublicController@login_account_post'); // 账号登陆请求
	Route::post('/login_phone/post', 'UserPublicController@login_phone_post'); // 短信登陆请求
	Route::get('/logout', 'UserPublicController@logout'); // 登出
	Route::get('/pwd_recover', 'UserPublicController@pwd_recover_view'); // 找回密码试图
	Route::post('/pwd_recover/post', 'UserPublicController@pwd_recover_post'); // 找回密码试图
	Route::post('/sms/send', 'UserPublicController@send_code_post'); // 发送短信请求

	//用户登录后访问
	Route::get('/user', 'UserController@index');
	Route::post('/user/info_update', 'UserController@info_update');
	Route::post('/user/pwd_update', 'UserController@pwd_update');
	Route::post('/user/comment', 'UserController@comment');
});