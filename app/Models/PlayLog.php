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
    public function course()
    {
        return $this->belongsToMany(ThyroidClassCourse::class);
    }
}
