<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Banner
 * @package App\Models
 * @mixin \Eloquent
 */
class StudyLog extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'course_id',
        'doctor_id',
        'created_at',
        'updated_at',
        'site_id',
        'study_duration',
        'video_duration',
        'progress',
    ];
}
