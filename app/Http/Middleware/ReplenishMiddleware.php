<?php

namespace App\Http\Middleware;

use App\Models\Student;
use Closure;

class ReplenishMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $student = Student::find(\Session::get('studentId'));

        if($student->name && $student->sex && $student->office && $student->title && $student->province && $student->city && $student->area && $student->hospital_level && $student->hospital_name) {
            return $next($request);
        } else {
            return redirect('/home/replenish/create');
        }
    }
}
