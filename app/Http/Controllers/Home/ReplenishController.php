<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Student;

/**
 * Class ReplenishController
 * @package App\Http\Controllers\Home
 */
class ReplenishController extends Controller
{

    /**
     *
     */
    public function __construct()
    {
        $this->middleware('login');
        parent::__construct();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function create()
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

    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        if (!$this->studentId)
        {
            return redirect('home/replenish/error');
        } /*if>*/

        $student = Student::find($this->studentId);
        if (!$student)
        {
            return redirect('home/replenish/error');
        } /*if>*/

        $validator = \Validator::make($request->all(), [
            'name'      => 'required',
            'sex'       => 'required',
            'email'     => 'required',
            'birthday'  => 'required',
            'office'    => 'required',
            'title'     => 'required',
            'province'  => 'required',
            'city'      => 'required',
            'area'      => 'required',
            'hospital_name'  => 'required',
        ]);
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        } /*if>*/
        $student->update([
            'name'      => $request->input('name'),
            'sex'       => $request->input('sex'),
            'email'     => $request->input('email'),
            'birthday'  => $request->input('birthday'),
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

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function success()
    {
        return view('home.replenish.success');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function error()
    {
        return view('home.replenish.error');
    }

}
