<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{

    protected $table = 'mime_doctors';

    protected $fillable = [
        'name',
        'phone',
        'password',
        'hospital_id',
        'office',
        'email',
        'title',
    ];

}
