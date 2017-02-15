<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCommentRecommendToCourseAppliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('thyroid_class_courses', function ($table) {
            $table->timestamp('recomment_time');
            $table->mediumText('content');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('thyroid_class_courses', function (Blueprint $table) {
            $table ->dropColumn(['recomment_time','content']);
        });
    }
}
