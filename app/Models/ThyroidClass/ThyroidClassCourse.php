<?php

namespace App\Models\ThyroidClass;

use Illuminate\Database\Eloquent\Model;

class ThyroidClassCourse extends Model
{
    //
    protected $table = 'thyroid_class_courses';

    public function phase()
    {
        return $this->belongsTo('App\Models\ThyroidClass\ThyroidClassPhase', 'phase_id');
    }

}
