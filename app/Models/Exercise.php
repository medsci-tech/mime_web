<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    const EXERCISE_TYPE = [
        1 => '问答题',
        2 => '问卷',
    ];
    const EXERCISE_CHECK_TYPE = [
        1 => '单选',
        2 => '多选',
    ];

    protected $table = 'exercises';

    /**
     * @var array
     */
    protected $fillable = [
        'type',
        'check_type',
        'question',
        'option',
        'answer',
        'resolve',
        'status',
    ];

    public function type($index = null){
        if($index){
            if(!array_key_exists($index,self::EXERCISE_TYPE)){
                $index = 1;
            }
            return self::EXERCISE_TYPE[$index];
        }
        return self::EXERCISE_TYPE;
    }


    public function check_type($index = null){
        if($index){
            if(!array_key_exists($index,self::EXERCISE_CHECK_TYPE)){
                $index = 1;
            }
            return self::EXERCISE_CHECK_TYPE[$index];
        }
        return self::EXERCISE_CHECK_TYPE;
    }

}
