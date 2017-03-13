<?php

namespace Modules\AirClass\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\AirClass\Scopes\SiteScope;

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
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'image_url',
        'href_url',
        'page',
        'status',
        'weight',
        'site_id',
    ];
}
