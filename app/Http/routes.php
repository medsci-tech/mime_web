<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'ThyroidClass\ThyroidClassController@index');


Route::group(['prefix' => 'home', 'namespace' => 'Home'], function () {

    Route::group(['prefix' => 'register'], function () {
        Route::get('/create', 'RegisterController@create');
        Route::post('/store', 'RegisterController@store');
        Route::any('/sms', 'RegisterController@sms');
        Route::get('/success', 'RegisterController@success');
        Route::get('/error', 'RegisterController@error');
    });

    Route::group(['prefix' => 'replenish'], function () {
        Route::get('/create', 'ReplenishController@create');
        Route::post('/store', 'ReplenishController@store');
        Route::post('/success', 'ReplenishController@success');
        Route::post('/error', 'ReplenishController@error');
    });

    Route::get('/login', 'LoginController@showLoginForm');
    Route::any('/logout', 'LoginController@logout');
    Route::post('/login', 'LoginController@login');

});


Route::group(['prefix' => 'thyroid-class', 'namespace' => 'ThyroidClass'], function () {

    Route::get('/index', 'ThyroidClassController@index');
    Route::get('/phases', 'ThyroidClassController@phases');
    Route::get('/teachers', 'ThyroidClassController@teachers');
    Route::get('/questions', 'ThyroidClassController@questions');
    Route::any('/enter', 'ThyroidClassController@enter');
    Route::any('/update-statistics', 'ThyroidClassController@updateStatistics');

    Route::group(['prefix' => 'sign-up'], function () {
        Route::get('/create', 'SignUpController@create');
        Route::post('/store', 'SignUpController@store');
    });

    Route::group(['prefix' => 'course'], function () {
        Route::get('/view', 'CourseController@view');
        Route::any('/timer', 'CourseController@timer');
    });

});

Route::auth();
Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => 'auth'], function () {
    Route::any('/student-logs', 'AdminController@studentLogs');
    Route::group(['prefix' => 'excel'], function () {
        Route::get('/', 'ExcelController@excelForm');
        Route::post('/student', 'ExcelController@student');
        Route::post('/play-log', 'ExcelController@playLog');
        Route::post('/play-log-detail', 'ExcelController@playLogDetail');
        Route::any('/test', 'ExcelController@test');
        Route::any('/test_log_detail', 'ExcelController@getLogDetail');
        Route::any('/logs2excel', 'ExcelController@Logs2Excel');
    });

    Route::get('/', 'TeacherController@index');
    Route::resource('teacher', 'TeacherController');
    Route::resource('thyroid', 'ThyroidController');
    Route::resource('phase', 'PhaseController');
    Route::resource('course', 'CourseController');
    Route::resource('banner', 'BannerController');
    Route::resource('student', 'StudentController');
});
//
//Route::group(['prefix' => 'charts'], function(){
//    Route::get('/bar', function() {
//        return view('backend.charts.charts_bar');
//    });
//    Route::get('/map', function() {
//        return view('backend.charts.charts_map');
//    });
//    Route::get('/map2', function() {
//        return view('backend.charts.charts_map2');
//    });
//    Route::get('/pie', function() {
//        return view('backend.charts.charts_pie');
//    });
//    Route::get('/polar', function() {
//        return view('backend.charts.charts_polar');
//    });
//});

Route::get('/city', function() {
});

