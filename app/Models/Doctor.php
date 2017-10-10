<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{

    protected $table = 'doctors';

    protected $fillable = [
        'name',
        'phone',
        'password',
        'province',
        'city',
        'country',
        'hospital_id',
        'office',
        'email',
        'qq',
        'title',
        'rank',
        'credit',
    ];

    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }

    public function playLogs()
    {
        return $this->hasMany(StudyLog::class);
    }
}
