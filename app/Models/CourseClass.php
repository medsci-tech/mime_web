<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseClass extends Model
{
    protected $table = 'course_classes';

    protected $fillable = [
        'name',
        'status',
        'site_id',
    ];

}
