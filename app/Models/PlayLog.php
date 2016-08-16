<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PlayLog
 * @package App\Models
 * @mixin \Eloquent
 */
class PlayLog extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'student_id',
        'teacher_id',
        'thyroid_class_phase_id',
        'thyroid_class_course_id',
        'play_times',
        'play_duration',
        'student_course_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function playCourse()
    {
        return $this->belongsTo(PlayCourse::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function students()
    {
        return $this->belongsToMany(Student::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function teachers()
    {
        return $this->belongsToMany(Teacher::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function course()
    {
        return $this->belongsToMany(ThyroidClassCourse::class);
    }
}
