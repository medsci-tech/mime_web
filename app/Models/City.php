<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class City
 * @package App\Models
 * @mixin \Eloquent
 */
class City extends Model
{
    /**
     * @var string
     */
    protected $table = 'cities';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'province',
        'city',
        'area',
        'latitude',
        'longitude',
        'student_count'
    ];
}
