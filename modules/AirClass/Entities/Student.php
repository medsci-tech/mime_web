<?php

namespace Modules\AirClass\Entities;

use Illuminate\Database\Eloquent\Model;
/**
 * App\Models\Student
 * @mixin \Eloquent
 */
class Student extends Model
{
    /**
     * @var string
     */
    protected $table = 'students';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'phone',
        'nickname',
        'sex',
        'email',
        'birthday',
        'office',
        'title',
        'province',
        'city',
        'area',
        'hospital_level',
        'hospital_name',
        'entered_at',
        'site_id',
        'password'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function playLogs()
    {
        return $this->hasMany(PlayLog::class);
    }

    /**
     * @param $query
     * @param $seed
     * @return mixed
     */
    public function scopeSearch($query, $seed)
    {
        return $query->where('name', 'like', '%' . $seed . '%')
            ->orWhere('phone', 'like', '%' . $seed . '%')
            ->orWhere('email', 'like', '%' . $seed . '%')
            ->orWhere('province', 'like', '%' . $seed . '%')
            ->orWhere('city', 'like', '%' . $seed . '%')
            ->orWhere('area', 'like', '%' . $seed . '%')
            ->orWhere('hospital_name', 'like', '%' . $seed . '%')
            ->orWhere('title', 'like', '%' . $seed . '%')
            ->orWhere('office', 'like', '%' . $seed . '%');
    }
}
