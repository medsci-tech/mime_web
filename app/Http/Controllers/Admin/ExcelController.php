<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class ExcelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function excelForm()
    {
        return view('admin.excel');
    }

    public function student(Request $request)
    {
        $excel = $request->file('excel');
        \Excel::load($excel, function ($reader) use ($excel) {
            $excelData = \Excel::load($excel)->get()->toArray();
            foreach ($excelData as $data) {
                Student::create($data);
            }
        });
        return redirect();
    }

    public function playLog(Request $request)
    {
        $excel = $request->file('excel');
        \Excel::load($excel, function ($reader) use ($excel) {
            $excelData = \Excel::load($excel)->get()->toArray();
            foreach ($excelData as $data) {
                Student::create($data);
            }
        });
        return redirect();
    }

    public function playLogDetail(Request $request)
    {
        $excel = $request->file('excel');
        \Excel::load($excel, function ($reader) use ($excel) {
            $excelData = \Excel::load($excel)->get()->toArray();
            foreach ($excelData as $data) {
                Student::create($data);
            }
        });
        return redirect();
    }
}
