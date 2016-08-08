<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.student.index');
    }

    public function excel(Request $request)
    {

        $excel = $request->file('excel');
        \Excel::load($excel, function ($reader) use ($excel) {
            $excelData = \Excel::load($excel)->get()->toArray();
            //dd($excelData);
            foreach ($excelData as $data) {
                $update = [
                    'name' => $data['name'],
                    'default_spec' => $data['default_spec'],
                    'price' => $data['price'],
                    'beans' => $data['price'] * 10,
                    'is_show' => 1,
                ];
                Product::where('puan_id', intval($data['puan_id']))->update($update);
            }
        });
    }
}
