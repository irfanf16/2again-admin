<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAvailableAndCountFieldsToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('available_photo_count')->after('video_gallery_likes')->default(0);
            $table->integer('available_video_count')->after('available_photo_count')->default(0);
            $table->string('available_call_min')->bigInteger('available_video_count')->default(0);
            $table->integer('available_super_likes')->after('available_call_min')->default(0);
            $table->integer('available_favorite')->after('available_super_likes')->default(0);
            $table->integer('available_likes')->after('available_favorite')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('available_photo_count');
            $table->dropColumn('available_video_count');
            $table->dropColumn('available_call_min');
            $table->dropColumn('available_super_likes');
            $table->dropColumn('available_favorite');
        });
    }
}
