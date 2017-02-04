<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ThyroidClassCourse
 * @package App\Models
 * @mixin \Eloquent
 */
class ThyroidClassCourse extends Model
{
    use SoftDeletes;

    /**
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * @var array
     */
    protected $appends = ['play_count'];

    /**
     * @var string
     */
    protected $table = 'thyroid_class_courses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'comment',
        'logo_url',
        'teacher_id',
        'thyroid_class_phase_id',
        'qcloud_file_id',
        'qcloud_app_id',
        'is_show',
        'sequence',
        'exercise_ids',
        'site_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function thyroidClassPhase()
    {
        return $this->belongsTo(ThyroidClassPhase::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function playLogs()
    {
        return $this->hasMany(PlayLog::class);
    }

    /**
     * @return int|mixed
     */
    public function getPlayCountAttribute()
    {
        if(\Redis::command('HEXISTS', ['course_play_count', $this->attributes['id']])) {
            return \Redis::command('HGET', ['course_play_count', $this->attributes['id']]);
        } else {
            return 0;
        }
    }
}
