<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class KZKTClass extends Model
{
    protected $table = 'kzkt_classes';
    protected $fillable = ['volunteer_id', 'doctor_id', 'type', 'login_number', 'invite_number', 'status', 'created_at', 'updated_at', 'site_id','style'];

    public function volunteer(){
        return $this->belongsTo(Volunteer::class, 'volunteer_id');
    }

    public function doctor(){
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

}