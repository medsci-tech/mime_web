<?php

namespace Modules\AirClass\Entities;
use Illuminate\Database\Eloquent\Model;
use Modules\AirClass\Scopes\SiteScope;
class KZKTClass extends Model
{
    protected $table = 'kzkt_classes';
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