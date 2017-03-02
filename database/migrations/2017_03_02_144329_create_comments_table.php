<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('class_id')->comment('课程id');
            $table->string('parent_id')->default(0)->comment('父级评论id');
            $table->string('from_id')->comment('评论人');
            $table->string('from_name')->comment('评论人');
            $table->string('to_id')->comment('被评论人');
            $table->string('to_name')->comment('被评论人');
            $table->string('content')->comment('内容');
            $table->tinyInteger('site_id')->default(1)->comment('站点id');
            $table->tinyInteger('status')->default(0)->comment('状态');
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
        Schema::drop('comments');
    }
}
