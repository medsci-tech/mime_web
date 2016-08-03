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
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'sex',
        'email',
        'birthday',
        'office',
        'title',
        'province',
        'city',
        'area',
        'hospital_level',
        'hospital_name'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function thyroidClassStudent() {
        return $this->hasOne(ThyroidClassStudent::class);
    }

    /**
     * @return $this
     */
    public function enter() {
        $this->thyroidClassStudent()->save(thyroidClassStudent::create());
        return $this;
    }
}
