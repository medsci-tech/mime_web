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
    public function index()
    {
        $courseArray = [];
        foreach(ThyroidClassCourse::all() as $course) {
            $courseArray[$course->id] = $course->title;
        }
        return view('backend.tables.student', [
            'students' => Student::paginate('10'),
            'courseArray' => $courseArray
        ]);
    }

    public function search(Request $request) {
        $courseArray = [];
        foreach(ThyroidClassCourse::all() as $course) {
            $courseArray[$course->id] = $course->title;
        }
        $search = $request->input('key');
        return view('backend.tables.student', [
            'students' => Student::search($search)->paginate('10'),
            'courseArray' => $courseArray,
            'search' => $search
        ]);
    }
}
