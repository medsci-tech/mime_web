<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ThyroidClassPhase
 * @package App\Models
 * @mixin \Eloquent
 */
class ThyroidClassPhase extends Model
{
    /**
     * @var string
     */
    protected $table = 'thyroid_class_phases';



    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function thyroidClassCourses()
    {
        return $this->hasMany(ThyroidClassCourse::class, 'phase_id')->where('is_show', 1);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function teacher() {
        return $this->belongsTo(Teacher::class, 'main_teacher_id');
    }
}
