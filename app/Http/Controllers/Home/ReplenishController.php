<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Student;

class ReplenishController extends Controller
{
    //
    public function __construct()
    {
        parent::__construct();
    }

    public function create(Request $request)
    {
        if (!$this->studentId)
        {
            return redirect('home/replenish/error');
        } /*if>*/

        $student = Student::where('id', '=', $this->studentId)->first();
        if (!$student) 
        {
            return redirect('home/replenish/error');
        } /*if>*/
        
        return view('home.replenish.create', ['student' => $student]);
    }

    public function store(Request $request)
    {
        if (!$this->studentId)
        {
            return redirect('home/replenish/error');
        } /*if>*/

        $student = Student::where('id', '=', $this->studentId)->first();
        if (!$student)
        {
            return redirect('home/replenish/error');
        } /*if>*/

        $validator = \Validator::make($request->all(), [
            'name'      => 'required',
            'sex'       => 'required',
            'office'    => 'required',
            'title'     => 'required',
            'province'  => 'required',
            'city'      => 'required',
            'area'      => 'required',
            'hospital_level' => 'required',
            'hospital_name'  => 'required',
        ]);
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        } /*if>*/

        $student->update([
            'name'      => $request->input('name'),
            'sex'       => $request->input('sex'),
            'office'    => $request->input('office'),
            'title'     => $request->input('title'),
            'province'  => $request->input('province'),
            'city'      => $request->input('city'),
            'area'      => $request->input('area'),
            'hospital_level' => $request->input('hospital_level'),
            'hospital_name'  => $request->input('hospital_name'),
        ]);

        return redirect('home/replenish/success');
    }
    
    public function success() 
    {
        return view('home.replenish.success');
    }
    
    public function error() 
    {
        return view('home.replenish.error');
    }

}
