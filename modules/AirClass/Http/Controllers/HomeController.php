<?php namespace Modules\Airclass\Http\Controllers;

use Pingpong\Modules\Routing\Controller;
class HomeController extends Controller {
	
	public function index()
	{
		
		return view('airclass::index');
	}


    /**
     * @param Request $request
     */
    public function questions(Request $request)
    {

    }

    /**
     * @param Request $request
     */
    public function phases(Request $request)
    {

    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function enter()
    {
        $student = Student::find(\Session::get('studentId'));
        if ($student->entered_at) {
            return response()->json(['success' => false, 'error_message' => '已报名']);
        } else {
            $student->entered_at = Carbon::now();
            $student->save();
            \Redis::command('INCR', ['enter_count']);
            return response()->json(['success' => true]);
        }
    }
	
}

