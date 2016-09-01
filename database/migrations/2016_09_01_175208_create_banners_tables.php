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
            $table->increments('id')->comment('����.');
            $table->string('image_url')->comment('bannerͼƬ��ַ.');
            $table->string('href_url')->comment('���ӵ�ַ.');
            $table->tinyInteger('status')->default(0)->comment('�Ƿ���ʾ 0 Ϊ����ʾ 1Ϊ��ʾ.');
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
