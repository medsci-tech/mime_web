<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ThyroidClassPhase
 * @package App\Models
 * @mixin \Eloquent
 */
class ThyroidClassPhase extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    /**
     * @var string
     */
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
        'is_show'
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
}
