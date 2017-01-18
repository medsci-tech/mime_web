<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    protected $table = 'exercises';

    /**
     * @var array
     */
    protected $fillable = [
        'type',
        'video_id',
        'question',
        'option',
        'answer',
        'resolve',
        'status',
    ];

    protected function getDateFormat(){
        return time();
    }


    public function video()
    {
        return $this->belongsTo(ThyroidClassCourse::class);
    }
}
