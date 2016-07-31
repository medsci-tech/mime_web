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

Route::get('/', function () {
    return view('welcome');
});


//test
$pages = [
  'layouts.test'=>'/test',
  'open-course.index'=>'/open-course/index',
  'open-course.video-playing'=>'/open-course/video-playing'
];

foreach ($pages as $page=>$href) {
  Route::get($href,function() use($page) {
    return view($page);
  });
}
//test