<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
 * App\Models\Student
 * @mixin \Eloquent
 */
class Student extends Model
{
    /**
     * @var string
     */
    protected $table = 'students';

    /**
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function thyroidClassStudent() {
        return $this->has(ThyroidClassStudent::class);
    }
}
