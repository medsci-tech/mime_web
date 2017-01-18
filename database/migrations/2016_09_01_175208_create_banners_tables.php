<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBannersTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('banners', function (Blueprint $table) {
            $table->increments('id')->comment('主键.');
            $table->string('image_url')->nullable()->comment('banner图片地址.');
            $table->string('href_url')->nullable()->comment('链接地址.');
            $table->string('page')->nullable()->comment('所属页面.');
            $table->tinyInteger('status')->nullable()->default(0)->comment('是否显示 0 为不显示 1为显示.');
            $table->integer('weight')->nullable()->default(0)->comment('权重.');
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
        Schema::drop('banners');
    }
}
