<?php
namespace Modules\AirClass\Entities;

use Illuminate\Database\Eloquent\Model;

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
}
