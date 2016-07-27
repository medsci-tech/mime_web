<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateThyroidClassCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('thyroid_class_courses', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('number')->comment('课程编号');

            $table->string('title')->comment('学期title');
            $table->string('comment')->comment('学期简介');
            $table->string('logo_url')->comment('logo');
            $table->string('video_url')->comment('video');

            $table->unsignedInteger('user_count')->default(0)->comment('学生数');
            $table->unsignedInteger('play_count')->default(0)->comment('播放次数合计');
            $table->unsignedInteger('question_count')->default(0)->comment('提问数合计');

            $table->integer('teacher_id')->unsigned()->comment('教师ID');
            $table->foreign('teacher_id')->references('id')->on('teachers');

            $table->integer('phase_id')->unsigned()->comment('学期ID');
            $table->foreign('phase_id')->references('id')->on('thyroid_class_phases');

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
        Schema::table('thyroid_class_courses', function (Blueprint $table) {
            $table->dropUnique('number');
            $table->dropForeign('thyroid_class_courses_teacher_id_foreign');
            $table->dropForeign('thyroid_class_courses_phase_id_foreign');
        });
        Schema::drop('thyroid_class_courses');
    }
}
