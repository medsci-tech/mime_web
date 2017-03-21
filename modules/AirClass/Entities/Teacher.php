<?php

namespace Modules\AirClass\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\AirClass\Scopes\SiteScope;
/**
 * Class Teacher
 * @package App\Models
 * @mixin \Eloquent
 */
class Teacher extends Model
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'teachers';

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nickname',
        'photo_url',
        'name',
        'office',
        'title',
        'site_id',
        'introduction'
    ];
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
