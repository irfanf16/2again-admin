<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRatingFieldsToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->bigInteger('photo_gallery_likes')->after('silver_coin')->default(0);
            $table->bigInteger('video_gallery_likes')->after('photo_gallery_likes')->default(0);
            $table->bigInteger('photo_gallery_dislikes')->after('video_gallery_likes')->default(0);
            $table->bigInteger('video_gallery_dislikes')->after('photo_gallery_dislikes')->default(0);

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
            $table->dropColumn('photo_gallery_likes');
            $table->dropColumn('video_gallery_likes');
        });
    }
}
