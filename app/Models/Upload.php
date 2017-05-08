<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    protected $table = 'uploads';

    protected $fillable = [
        'old_name',
        'new_name',
        'path',
        'size',
    ];

}