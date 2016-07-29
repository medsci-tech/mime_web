<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateThyroidClassTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('thyroid_class_teachers', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('teacher_id')->unsigned()->comment('老师ID');
            $table->foreign('teacher_id')->references('id')->on('teachers');

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
        Schema::table('thyroid_class_teachers', function (Blueprint $table) {
            $table->dropForeign('thyroid_class_teachers_teacher_id_foreign');
        });
        Schema::drop('thyroid_class_teachers');
    }
}
