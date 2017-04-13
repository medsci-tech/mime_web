<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Volunteer
 * @package App\Model
 * @mixin \Eloquent
 */
class Volunteer extends Model
{
    protected $table = 'volunteers';
    
    public function represent(){
        return $this->belongsTo(RepresentInfo::class, 'number', 'initial');
    }

}
