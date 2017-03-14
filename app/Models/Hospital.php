<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    protected $table = 'hospitals';
    protected $fillable = ['province_id', 'province', 'city_id' , 'city' , 'country_id' , 'country' , 'hospital_level', 'hospital'];
}