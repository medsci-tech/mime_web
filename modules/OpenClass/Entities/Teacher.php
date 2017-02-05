<?php

namespace Modules\OpenClass\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Teacher
 * @package App\Models
 * @mixin \Eloquent
 */
class Teacher extends Model
{

    /**
     * @var string
     */
    protected $table = 'teachers';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function thyroidClassPhase()
    {
        return $this->hasMany(ThyroidClassPhase::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function thyroidClassCourses()
    {
        return $this->hasMany(ThyroidClassCourse::class);
    }
}
