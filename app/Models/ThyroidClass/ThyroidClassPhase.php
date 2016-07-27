<?php

namespace App\Models\ThyroidClass;

use Illuminate\Database\Eloquent\Model;

class ThyroidClassPhase extends Model
{
    //
    protected $table = 'thyroid_class_phases';

    public function courses()
    {
        return $this->hasMany('App\Models\ThyroidClass\ThyroidClassCourse', 'phase_id');
    }
}
