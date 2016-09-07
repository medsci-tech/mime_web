<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSoftDeletesToThyroidPhaseAndCourse extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('thyroid_class', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('thyroid_class_phases', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('thyroid_class_courses', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('teachers', function (Blueprint $table) {
            $table->softDeletes();
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
