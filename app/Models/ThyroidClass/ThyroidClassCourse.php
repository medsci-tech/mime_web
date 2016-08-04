<?php

namespace App\Models\ThyroidClass;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ThyroidClassCourse
 * @package App\Models\ThyroidClass
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
    public function phase()
    {
        return $this->belongsTo('App\Models\ThyroidClass\ThyroidClassPhase', 'phase_id');
    }

}
