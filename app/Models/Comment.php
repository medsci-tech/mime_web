<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Banner
 * @package App\Models
 * @mixin \Eloquent
 */
class Comment extends Model
{
    /**
     * @var string
     */
    protected $table = 'comments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'class_id',
        'comment_id',
        'parent_comment_id',
        'from_id',
        'from_name',
        'to_id',
        'to_name',
        'content',
        'status',
        'site_id',
    ];
}
