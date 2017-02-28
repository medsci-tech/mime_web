<?php
namespace Modules\AirClass\Entities;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Authenticatable
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
}
