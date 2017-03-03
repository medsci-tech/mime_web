<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnswerLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answer_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('exercise_id')->comment('试题id');
            $table->string('answer')->comment('答题卡');
            $table->string('user_id')->comment('答题人');
            $table->string('user_nickname')->comment('答题人');
            $table->tinyInteger('site_id')->default(1)->comment('站点id');
            $table->tinyInteger('status')->default(0)->comment('状态');
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
        Schema::drop('answer_logs');
    }
}
