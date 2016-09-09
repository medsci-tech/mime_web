<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('teachers', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name')->comment('名字');
            $table->string('sex')->comment('性别');
            $table->string('photo_url')->comment('宣传照');
            $table->string('office')->nullable()->comment('科室');
            $table->string('title')->nullable()->comment('职称');
            $table->text('introduction')->nullable()->comment('介绍');

            $table->timestamps();
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
        Schema::drop('teachers');
    }
}
