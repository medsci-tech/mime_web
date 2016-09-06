<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ThyroidClass
 * @package App\Models
 * @mixin \Eloquent
 */
class ThyroidClass extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'thyroid_classes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'comment'
    ];

}
