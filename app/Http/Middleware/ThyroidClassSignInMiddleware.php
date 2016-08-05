<?php

namespace App\Http\Middleware;

use App\Models\Student;
use Closure;

class ThyroidClassSignInMiddleware
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
        if ($student->thyroidClassStudent) {
            return $next($request);
        } else {
            return redirect('/');
        }

    }
}
