<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\ThyroidClassCourse;
use App\Models\ThyroidClassPhase;

class StudentController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teacherArray = [];
        $phraseArray = [];
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
        return view('admin.table.student', [
            'students' => Student::paginate('10'),
            'teacherArray' => $teacherArray,
            'phraseArray' => $phraseArray,
            'courseArray' => $courseArray
        ]);
    }
}
