<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Entities\Teacher;

class PrivateClass extends Model
{
    protected $table = 'private_classes';

    protected $fillable = [
        'doctor_id',
        'teacher_id',
        'term',
        'upload_id',
        'site_id',
        'status',
        'bespoke_at',
    ];

    public function doctor(){
        return $this->belongsTo(Doctor::class);
    }

    public function teacher(){
        return $this->belongsTo(Teacher::class);
    }

    public function upload(){
        return $this->belongsTo(Upload::class);
    }
}