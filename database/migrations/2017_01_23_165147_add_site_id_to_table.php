<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSiteIdToThyoidPhaseCourseBanner extends Migration
{
    /**
     * Run the migrations.
     *
    'thyroid_classes',
    'thyroid_class_phases',
    'thyroid_class_courses',
    'banners',
     * @return void
     */
    public function up()
    {
        Schema::table('thyroid_classes', function(Blueprint $table) {
            $table->integer('site_id')->default(1)->comment('所属站点');
        });
        Schema::table('thyroid_class_phases', function(Blueprint $table) {
            $table->integer('site_id')->default(1)->comment('所属站点');
        });
        Schema::table('thyroid_class_courses', function(Blueprint $table) {
            $table->integer('site_id')->default(1)->comment('所属站点');
        });
        Schema::table('banners', function(Blueprint $table) {
            $table->integer('site_id')->default(1)->comment('所属站点');
        });
        Schema::table('exercises', function(Blueprint $table) {
            $table->integer('site_id')->default(1)->comment('所属站点');
        });
        Schema::table('teachers', function(Blueprint $table) {
            $table->integer('site_id')->default(1)->comment('所属站点');
        });
        Schema::table('students', function(Blueprint $table) {
            $table->integer('site_id')->default(1)->comment('所属站点');
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
    }
}
