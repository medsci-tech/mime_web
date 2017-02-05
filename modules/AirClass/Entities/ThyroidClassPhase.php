<?php

namespace Modules\AirClass\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ThyroidClassPhase
 * @package App\Models
 * @mixin \Eloquent
 */
class ThyroidClassPhase extends Model
{

    protected $table = 'thyroid_class_phases';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'comment',
        'main_teacher_id',
        'logo_url',
        'sequence',
        'is_show',
        'site_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function thyroidClassCourses()
    {
        return $this->hasMany(ThyroidClassCourse::class)->where('is_show', 1)->orderBy('sequence', 'asc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function teacher() {
        return $this->belongsTo(Teacher::class, 'main_teacher_id');
    }

    /**
     * @return int|mixed
     */
    public function getPlayCountAttribute()
    {
        $courses = ThyroidClassCourse::where('thyroid_class_phase_id', $this->attributes['id'])->get();
        $count = 0;
        foreach($courses as $course) {
            $count += \Redis::command('HGET', ['course_play_count', $course->id]);
        }
        return $count;
    }
}
