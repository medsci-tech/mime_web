<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCourseClassIdToPhaseCourse extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('thyroid_class_courses', function(Blueprint $table) {
            $table->integer('course_class_id')->default(1)->comment('所属站点');
        });
        Schema::table('thyroid_class_phases', function(Blueprint $table) {
            $table->integer('course_class_id')->default(1)->comment('所属站点');
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
