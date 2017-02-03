<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    /**
     * @var string
     */
    protected $table = 'sites';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'link',
        'status',
    ];
}
