<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRepresentativesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('representatives', function (Blueprint $table) {
            $table->increments('id');

            $table->string('openid')->nullable()->comment('wechat open id');
            $table->string('unionid')->nullable()->comment('wechat union id');
            $table->string('nickname')->nullable()->comment('wechat nick name');
            $table->string('headimgurl')->nullable()->comment('wechat headimgurl');

            $table->string('name')->comment('名字');
            $table->string('phone', 11)->comment('电话');
            $table->string('password')->comment('密码');

            $table->integer('company_id')->unsigned()->comment('单位ID');
            $table->foreign('company_id')->references('id')->on('companies');

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
        Schema::table('representatives', function(Blueprint $table) {
            $table->dropForeign('representatives_company_id_foreign');
        });
        Schema::drop('representatives');
    }
}
