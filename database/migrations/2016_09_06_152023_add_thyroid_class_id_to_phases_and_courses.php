<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddThyroidClassIdToPhasesAndCourses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
//        Schema::table('thyroid_class_phases', function (Blueprint $table) {
//            $table->integer('thyroid_class_id')->nullable()->default(null)->unsigned()->comment('公开课ID');
//            $table->foreign('thyroid_class_id')->references('id')->on('thyroid_classes');
//        });
//
//        Schema::table('thyroid_class_courses', function (Blueprint $table) {
//            $table->integer('thyroid_class_id')->nullable()->default(null)->unsigned()->comment('公开课ID');
//            $table->foreign('thyroid_class_id')->references('id')->on('thyroid_classes');
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
//        Schema::table('thyroid_class_phases', function (Blueprint $table) {
//            $table->dropForeign('thyroid_class_phases_thyroid_class_id_foreign');
//        });
//
//        Schema::table('thyroid_class_courses', function (Blueprint $table) {
//            $table->dropForeign('thyroid_class_courses_thyroid_class_id_foreign');
//        });
    }
}
