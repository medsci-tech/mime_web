<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Banner
 * @package App\Models
 * @mixin \Eloquent
 */
class AnswerLog extends Model
{
    /**
     * @var string
     */
    protected $table = 'answer_logs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'exercise_id',
        'answer',
        'user_id',
        'site_id',
        'class_id',
    ];
}
