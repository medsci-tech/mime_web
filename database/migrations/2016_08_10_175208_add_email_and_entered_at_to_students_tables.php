<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEmailAndEnteredAtToStudentsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('students', function (Blueprint $table) {
            $table->string('email');
            $table->timestamp('entered_at');
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
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn('email');
            $table->dropColumn('entered_at');
        });
    }
}