<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Banner
 * @package App\Models
 * @mixin \Eloquent
 */
class Banner extends Model
{
    /**
     * @var string
     */
    protected $table = 'banners';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'image_url',
        'href_url',
        'page',
        'status',
        'weight'
    ];
}
