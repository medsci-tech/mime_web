<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentStatistics extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_statistics', function (Blueprint $table) {
            $table->increments('id');
            $table->string('statistic_term', 255)->nullable()->comment('统计项目名');
            $table->string('meta_key', 255)->nullable()->comment('元信息关键字');
            $table->string('meta_value', 255)->nullable()->comment('元信息的详细值');
            $table->timestamps();
        });

        Schema::create('cities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('province');
            $table->string('city')->index();
            $table->string('area');
            $table->decimal('latitude', 11, 8)->default(0)->comment('城市经度.');
            $table->decimal('longitude', 11, 8)->default(0)->comment('城市纬度.');
            $table->integer('student_count')->nullable()->default(0)->comment('学员总数');
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
        Schema::drop('student_statistics');
        Schema::drop('cities');
    }
}
