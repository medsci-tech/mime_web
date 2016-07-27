<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateThyroidClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('thyroid_classes', function (Blueprint $table) {
            $table->increments('id');

            $table->string('title')->comment('甲状腺公开课');
            $table->string('comment')->comment('简介');
            $table->string('schedule')->comment('日程');
            $table->string('logo_url')->comment('logo');

            $table->unsignedInteger('phase_count')->default(0)->comment('学期数');
            $table->unsignedInteger('course_count')->default(0)->comment('课程数');
            $table->unsignedInteger('student_count')->default(0)->comment('学生数');
            $table->unsignedInteger('play_count')->default(0)->comment('播放次数合计');
            $table->unsignedInteger('question_count')->default(0)->comment('提问数合计');

            $table->date('begin_at')->nullable()->comment('项目开始时间');
            $table->date('end_at')->nullable()->comment('l项目结束时间');

            $table->unsignedInteger('latest_unit_num')->default(0)->comment('当前学期');
            $table->unsignedInteger('latest_course_num')->default(0)->comment('当前课程');
            $table->date('latest_update_at')->default(0)->comment('最近更新时间');

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
        Schema::drop('thyroid_classes');
    }
}
