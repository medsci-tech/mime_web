<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recommend extends Model
{
    //
    protected $fillable = [ 'doctor_id','recommend_id','created_at', 'updated_at'];
}
