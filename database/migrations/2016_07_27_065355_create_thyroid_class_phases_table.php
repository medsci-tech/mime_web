<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateThyroidClassPhasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('thyroid_class_phases', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('number')->comment('学期编号');

            $table->string('title')->comment('学期title');
            $table->string('comment')->comment('学期简介');
            $table->string('logo_url')->comment('logo');

            $table->unsignedInteger('student_count')->default(0)->comment('学生数');
            $table->unsignedInteger('play_count')->default(0)->comment('播放次数合计');
            $table->unsignedInteger('question_count')->default(0)->comment('提问数合计');

            $table->integer('main_teacher_id')->unsigned()->comment('主讲教师ID');
            $table->foreign('main_teacher_id')->references('id')->on('teachers');

            $table->unique('number');

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
        //
        Schema::table('thyroid_class_phases', function (Blueprint $table) {
            $table->dropForeign('thyroid_class_phases_main_teacher_id_foreign');
        });
        Schema::drop('thyroid_class_phases');
    }
}
