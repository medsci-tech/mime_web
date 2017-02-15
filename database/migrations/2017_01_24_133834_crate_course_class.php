<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrateCourseClass extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_classes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable()->comment('名称');
            $table->tinyInteger('site_id')->default(1)->comment('站点id');
            $table->tinyInteger('status')->default(0)->comment('状态');
            $table->tinyInteger('has_teacher')->default(0)->comment('是否有专家 0：无 1：有');
            $table->tinyInteger('has_children')->default(0)->comment('是否有单元目录结构 1：是 0：否');
            $table->timestamps();
            $table->index('site_id');
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
    }
}
