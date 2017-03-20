<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'content',
        'phone',
        'msg_type',
        'site_id',
    ];

}
