<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSequenceToPhasesAndCourses extends Migration
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
            $table->string('sequence');
        });
        Schema::create('thyroid_class_courses', function (Blueprint $table) {
            $table->string('sequence');
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
        Schema::create('thyroid_class_phases', function (Blueprint $table) {
            $table->dropColumn('sequence');
        });
        Schema::create('thyroid_class_courses', function (Blueprint $table) {
            $table->dropColumn('sequence');
        });
    }
}
