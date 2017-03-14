<?php
/* 空中课堂子域名路由配置 */
Route::group(['domain' => env('AIR_DOMAIN'),'middleware' => 'web', 'prefix' => '', 'namespace' => 'Modules\AirClass\Http\Controllers'], function()
{
	//首页
	Route::get('/', 'HomeController@index');
	Route::get('/public_class', 'HomeController@public_class'); // 公开课
	Route::get('/private_class', 'HomeController@private_class'); // 私教课
	Route::get('/answer_class', 'HomeController@answer_class'); // 答疑课
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
	Route::post('/login_account/post', 'UserPublicController@login_account_post'); // 账号登陆请求
	Route::post('/login_phone/post', 'UserPublicController@login_phone_post'); // 短信登陆请求
	Route::get('/logout', 'UserPublicController@logout'); // 登出
	Route::post('/pwd_recover/post', 'UserPublicController@pwd_recover_post'); // 找回密码请求

	// 医院
	Route::post('/hospital/get_lists', 'HospitalController@get_lists'); // 获取医院请求

	// 短信
	Route::post('/sms/code', 'SmsController@send_code_post'); // 发送短信请求

	//用户登录后访问
	Route::get('/user', 'UserController@study'); // 学习情况视图
	Route::get('/user/msg', 'UserController@msg'); // 消息视图
	Route::get('/user/comment', 'UserController@comment'); // 评论视图
	Route::get('/user/info_edit', 'UserController@info_edit'); // 修改资料视图
    Route::post('/user/save_info', 'UserController@saveInfo'); // 保存修改资料视图
    Route::post('/user/send', 'UserController@send'); // 个人中心发送短信
	Route::get('/user/pwd_edit', 'UserController@pwd_edit'); // 修改密码视图
    Route::post('/user/pwd_reset', 'UserController@pwdReset'); // 保存修改密码
	Route::post('/user/info_update', 'UserController@info_update');
	Route::post('/user/pwd_update', 'UserController@pwd_update');
    Route::post('/file/upload', 'FileController@upload'); // 文件上传
});