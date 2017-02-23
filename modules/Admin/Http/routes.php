<?php
/* 后台系统域名配置env('ADMIN_DOMAIN') */
Route::group(['middleware' => ['web'], 'namespace' => 'Modules\Admin\Http\Controllers'], function () {
    Route::auth();
});

Route::group(['domain' =>env('ADMIN_DOMAIN'),'middleware' => ['web','auth'], 'prefix' => '', 'namespace' => 'Modules\Admin\Http\Controllers'], function(){
    Route::any('/student-logs', 'AdminController@studentLogs');
    Route::any('/reset-pwd', 'StudentController@resetPwd');
    Route::group(['prefix' => 'excel'], function () {
        Route::get('/', 'ExcelController@excelForm');
        Route::post('/student', 'ExcelController@student');
        Route::post('/play-log', 'ExcelController@playLog');
        Route::post('/play-log-detail', 'ExcelController@playLogDetail');
        Route::any('/test', 'ExcelController@test');
        Route::any('/test_log_detail', 'ExcelController@getLogDetail');
        Route::any('/logs2excel', 'ExcelController@logs2Excel');
        Route::any('/export-phone', 'ExcelController@exportPhone');
    });

    Route::get('/', 'SiteController@index');
    Route::resource('teacher', 'TeacherController');
    Route::resource('thyroid', 'ThyroidController');
    Route::resource('phase', 'PhaseController');
    Route::get('course', 'CourseController@index');
    Route::post('course', 'CourseController@store');
    Route::delete('course', 'CourseController@destroy');
    Route::post('course/status', 'CourseController@status');
    Route::get('course-class', 'CourseClassController@index');
    Route::post('course-class', 'CourseClassController@save');
    Route::delete('course-class', 'CourseClassController@destroy');
    Route::resource('banner', 'BannerController');
    Route::resource('student', 'StudentController');
    Route::group(['prefix' => 'statistic'], function () {
        Route::get('/area-map', 'StatisticController@areaMap');
        Route::get('/province-map', 'StatisticController@provinceMap');
        Route::get('/register-bar', 'StatisticController@registerBar');
        Route::get('/class-pie', 'StatisticController@classPie');
        Route::get('/update', 'StatisticController@update');
    });
    /* 试题相关 */
    Route::get('/site', 'SiteController@index');
    Route::post('/site', 'SiteController@save');

    Route::get('/exercise', 'ExerciseController@index');
    Route::get('/exercise/table', 'ExerciseController@index_table');
    Route::post('/exercise', 'ExerciseController@save');
    Route::delete('/exercise', 'ExerciseController@destroy');
    Route::post('/exercise/get_list', 'ExerciseController@getList');

    /* 消息 */
    Route::get('/msg/all', 'MsgController@all');
    Route::get('/msg/site', 'MsgController@site');
    Route::get('/msg/user', 'MsgController@user');
    Route::post('/msg/set_all', 'MsgController@setAllMsg');
    Route::post('/msg/set_site', 'MsgController@setSiteMsg');
    Route::post('/msg/set_user', 'MsgController@setUserMsg');
    Route::get('/msg/delete', 'MsgController@delete');

});