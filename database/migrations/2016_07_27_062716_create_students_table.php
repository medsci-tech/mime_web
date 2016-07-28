<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('students', function (Blueprint $table) {
            $table->increments('id');

            $table->string('openid')->nullable()->comment('wechat open id');
            $table->string('unionid')->nullable()->comment('wechat union id');
            $table->string('nickname')->nullable()->comment('wechat nick name');
            $table->string('headimgurl')->nullable()->comment('wechat headimgurl');

            $table->string('phone', 11)->comment('手机号码');
            $table->string('auth_code', 6)->comment('sms auth code');
            $table->string('password')->comment('密码');

            $table->string('name')->nullable()->comment('名字');
            $table->string('office')->nullable()->comment('科室');
            $table->string('title')->nullable()->comment('职称');

            $table->string('province')->nullable()->comment('省');
            $table->string('city')->nullable()->comment('市');
            $table->string('hospital_level')->nullable()->comment('医院等级');
            $table->string('hospital_name')->nullable()->comment('医院名称');

            $table->unique('phone');
            $table->index('phone');

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
        Schema::table('students', function (Blueprint $table) {
            //
            $table->dropUnique('phone');
            $table->dropIndex('phone');
        });
    }
}
