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
            $table->string('statistic_term', 255)->nullable()->comment('ͳ����Ŀ��');
            $table->string('meta_key', 255)->nullable()->comment('Ԫ��Ϣ�ؼ���');
            $table->string('meta_value', 255)->nullable()->comment('Ԫ��Ϣ����ϸֵ');
            $table->timestamps();
        });

        Schema::create('cities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('province');
            $table->string('city')->index();
            $table->decimal('latitude', 11, 8)->default(0)->comment('���о���.');
            $table->decimal('longitude', 11, 8)->default(0)->comment('����γ��.');

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
