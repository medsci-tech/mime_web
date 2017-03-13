<?php

namespace Modules\AirClass\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\AirClass\Scopes\SiteScope;
class CourseClass extends Model
{
    protected $table = 'course_classes';
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new SiteScope);
    }

}
