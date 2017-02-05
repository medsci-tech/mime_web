<?php

namespace Modules\OpenClass\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ThyroidClassCourse
 * @package App\Models
 * @mixin \Eloquent
 */
class ThyroidClassCourse extends Model
{

    /**
     * @var string
     */
    protected $table = 'thyroid_class_courses';

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
