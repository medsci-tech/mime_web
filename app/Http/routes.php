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
    Route::get('/enter', 'ThyroidClassController@enter');

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
Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::get('/', 'AdminController@index');
    Route::group(['prefix' => 'excel'], function () {
        Route::get('/', 'ExcelController@excelForm');
        Route::post('/student', 'ExcelController@student');
        Route::post('/play-log', 'ExcelController@plaLog');
        Route::post('/play-log-detail', 'ExcelController@plaLogDetail');
    });
});
