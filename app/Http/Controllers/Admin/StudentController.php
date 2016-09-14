<?php

namespace App\Http\Controllers\Admin;

use App\Models\Student;
use App\Models\Teacher;
use App\Http\Controllers\Controller;
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
        foreach(Teacher::all() as $teacher) {
            $teacherArray[$teacher->id] = $teacher->name;
        }
        return view('backend.tables.student', [
            'students' => Student::paginate('10'),
            'courseArray' => $courseArray
        ]);
    }

    public function search(Request $request) {
        $courseArray = [];
        foreach(Teacher::all() as $teacher) {
            $teacherArray[$teacher->id] = $teacher->name;
        }
        return view('backend.tables.student', [
            'students' => Student::search($request->input('key'))->paginate('10'),
            'courseArray' => $courseArray
        ]);
    }
}
