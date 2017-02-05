<?php

namespace Modules\Admin\Http\Controllers;

use Modules\Admin\Entities\Student;
use Modules\Admin\Entities\ThyroidClassCourse;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $site_id = $request->input('site_id');
        if($site_id){
            $courseArray = [];
            foreach (ThyroidClassCourse::all() as $course) {
                $courseArray[$course->id] = $course->title;
            }
            if ($request->has('search')) {
                $search = $request->input('search');
                $students = Student::search($search)->where('site_id',$site_id)->paginate(10);
            } else {
                $search = null;
                $students = Student::where('site_id',$site_id)->paginate(10);
            }
            return view('admin::backend.tables.student', [
                'students' => $students,
                'courseArray' => $courseArray,
                'search' => $search
            ]);
        }else{
            return redirect('/site');
        }

    }

    /**
     *
     */
    public function Logs2Excel()
    {
        $keys = \Redis::command('keys ', ["student_course_id*"]);
        $logs = \Redis::command('HGETALL ', $keys);
        dd($logs);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function resetPwd(Request $request)
    {
        $phone = $request->input('phone');
        $password = \Hash::make(substr($phone, -6));
        $student = Student::where('phone', $phone)->first();
        $student->password = $password;

        return response()->json([
            'success' => $student->save()
        ]);
    }
}
