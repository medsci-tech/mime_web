<?php

namespace App\Http\Controllers\Admin;

use App\Models\Student;
use App\Http\Controllers\Controller;
use App\Models\ThyroidClassCourse;
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
        $courseArray = [];
        foreach(ThyroidClassCourse::all() as $course) {
            $courseArray[$course->id] = $course->title;
        }
        if($request->has('search')) {
            $search = $request->input('search');
            return view('backend.tables.student', [
                'students' => Student::search($search)->paginate('10'),
                'courseArray' => $courseArray,
                'search' => $search
            ]);
        } else {
            return view('backend.tables.student', [
                'students' => Student::paginate('10'),
                'courseArray' => $courseArray
            ]);
        }
    }
}
