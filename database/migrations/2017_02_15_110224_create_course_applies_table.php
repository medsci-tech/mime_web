<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseAppliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_applies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('file', 100)->comment('上传的文件如ppt等');
            $table->integer('user_id')->unsigned()->comment('注册用户id,members主键id');
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
        Schema::drop('course_applies');
    }
}
