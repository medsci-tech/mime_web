<?php

namespace App\Models;

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
        'password'
    ];

    public function playLogs()
    {
        return $this->hasMany(PlayLog::class);
    }
}
