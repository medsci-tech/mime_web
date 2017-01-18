<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    protected $table = 'exercises';

    /**
     * @var array
     */
    protected $fillable = [
        'type',
        'check_type',
        'question',
        'option',
        'answer',
        'resolve',
        'status',
    ];

    protected function getDateFormat(){
        return time();
    }

}
