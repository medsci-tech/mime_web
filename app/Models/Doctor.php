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
        'area',
        'hospital_id',
        'office',
        'email',
        'title',
        'rank',
    ];

    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }

}
