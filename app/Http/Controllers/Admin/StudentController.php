<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\ThyroidClassCourse;
use App\Models\ThyroidClassPhase;
use App\Http\Controllers\Controller;

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
        foreach(ThyroidClassPhase::all() as $phase) {
            $phraseArray[$phase->id] = $phase->title;
        }
        foreach(ThyroidClassCourse::all() as $course) {
            $courseArray[$course->id] = $course->title;
        }
        return view('backend.tables.student', [
            'students' => Student::paginate('10'),
            'courseArray' => $courseArray
        ]);
    }
}
