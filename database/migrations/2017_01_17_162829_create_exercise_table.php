<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExerciseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exercises', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type')->default(1)->comment('单选1，多选2');
            $table->integer('video_id')->comment('项目站点id');
            $table->string('question')->comment('问题');
            $table->string('option',800)->comment('选项');
            $table->string('answer')->comment('答案');
            $table->string('resolve')->comment('解析');
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('exercises');
    }
}
