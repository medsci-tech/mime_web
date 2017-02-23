<?php namespace Modules\OpenClass\Http\Controllers;

use App\Http\Controllers\WebController;
use Modules\Openclass\Entities\Student;
use App\Models\Banner;
use Modules\Openclass\Entities\PlayLog;
use Modules\Openclass\Entities\Teacher;
use App\Models\ThyroidClass;
use Modules\Openclass\Entities\ThyroidClassCourse;
use Modules\Openclass\Entities\ThyroidClassPhase;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;
use Pingpong\Modules\Routing\Controller;

class HomeClassController extends WebController {
	
	public function index()
	{
        return view('openclass::home.index', [
            'teachers' => Teacher::all(),
            'thyroidClass' => ThyroidClass::all()->first(),
            'thyroidClassPhases' => ThyroidClassPhase::where('is_show', 1)->get(),
            'studentCount' => \Redis::command('GET', ['enter_count']),
            'playCount' => \Redis::command('GET', ['play_count']),
            'banners' => Banner::where('page', 'index')->where('status', 1)->orderBy('weight', 'desc')->get()
        ]);
	}
	
}