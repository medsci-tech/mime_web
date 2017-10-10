<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Support\Facades\DB;
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
            $dataObj = DB::table('doctors as d')->leftJoin('hospitals as h','d.hospital_id','=','h.id')->select('d.id','d.phone','d.name','d.email','d.office','d.title','d.created_at','h.province','h.city','h.country','h.hospital');
            $search = $request->input('search')?:'';
            if ($request->has('search')) {
                $search = $request->input('search');
                $dataObj = $dataObj->where('d.phone', 'like', '%' . $search . '%')
                    ->orWhere('d.name', 'like', '%' . $search . '%')
                    ->orWhere('d.email', 'like', '%' . $search . '%')
                    ->orWhere('d.office', 'like', '%' . $search . '%')
                    ->orWhere('d.title', 'like', '%' . $search . '%')
                    ->orWhere('h.province', 'like', '%' . $search . '%')
                    ->orWhere('h.city', 'like', '%' . $search . '%')
                    ->orWhere('h.hospital', 'like', '%' . $search . '%');
            }
            $students = $dataObj->paginate(10);

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
     *  学习日志
     */
    public function playLog(Request $request){
        $datas = Doctor::find($request->id)->playLogs()->groupBy('course_id')->select(DB::raw('count(id) as num,sum(study_duration) as duration,course_id'))->get();
        $res = array();
        foreach ($datas as $data){
            $tmp =array();
            $tmp[] = $data->course()->first()->title;
            $tmp[] = $data->num;
            $tmp[] = (sprintf('%02u',$data->duration/3600)).':'.(sprintf('%02u',$data->duration%3600/60)).':'.(sprintf('%02u',$data->duration%3600%60));
            $res[]= $tmp;
        }
        return response()->json($res);
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
