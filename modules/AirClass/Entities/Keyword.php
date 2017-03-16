<?php
/**
 * Created by PhpStorm.
 * User: Chelsea
 * Date: 2016/4/14
 * Time: 17:48
 */

namespace Modules\AirClass\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\AirClass\Scopes\SiteScope;
class Keyword extends Model
{
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