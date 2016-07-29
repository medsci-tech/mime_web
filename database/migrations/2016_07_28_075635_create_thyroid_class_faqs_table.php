<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateThyroidClassFaqsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('thyroid_class_faqs', function (Blueprint $table) {
            $table->increments('id');

            $table->string('question')->comment('问题');
            $table->string('answer')->comment('回答');

            $table->unsignedInteger('user_count')->default(0)->comment('学生数');

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
        Schema::drop('thyroid_class_faqs');
    }
}
