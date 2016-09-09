<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateThyroidClassPhasesTable extends Migration
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
            $table->increments('id');

            $table->string('sequence');
            $table->string('title')->comment('学期title');
            $table->text('comment')->comment('学期简介');
            $table->string('logo_url')->comment('logo');

            $table->integer('main_teacher_id')->unsigned()->comment('主讲教师ID');
            $table->foreign('main_teacher_id')->references('id')->on('teachers');
            $table->tinyInteger('is_show')->default(0)->comment('是否显示');

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
        //
        Schema::table('thyroid_class_phases', function (Blueprint $table) {
            $table->dropForeign('thyroid_class_phases_main_teacher_id_foreign');
        });
        Schema::drop('thyroid_class_phases');
    }
}
