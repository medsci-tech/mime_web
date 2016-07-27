<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateThyroidClassStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('thyroid_class_students', function (Blueprint $table) {
            $table->increments('id');

            $table->bigInteger('study_duration')->comment('学习时长');

            $table->integer('student_id')->unsigned()->comment('学生ID');
            $table->foreign('student_id')->references('id')->on('students');

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
        Schema::table('thyroid_class_students', function (Blueprint $table) {
            $table->dropUnique('number');
            $table->dropForeign('thyroid_class_students_student_id_foreign');
        });
        Schema::drop('thyroid_class_students');
    }
}
