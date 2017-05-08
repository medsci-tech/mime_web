<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrivateClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('private_classes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('doctor_id')->nullable();
            $table->integer('teacher_id')->nullable();
            $table->integer('term')->nullable();
            $table->integer('upload_id')->nullable();
            $table->tinyInteger('site_id')->nullable();
            $table->tinyInteger('status')->nullable()->default(0)->comment('状态，0已报名，1已审核，2已完成，-1未通过');
            $table->date('bespoke_at')->comment('预约时间');
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
        Schema::drop('private_classes');
    }
}
