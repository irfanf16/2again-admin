<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserNotificationSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_notification_settings', function (Blueprint $table) {
            $table->id();
            $table->uuid('user_id');
            $table->boolean('NewMatchEmail')->default(1);
            $table->boolean('NewMessageEmail')->default(1);
            $table->boolean('SuperLikeEmail')->default(1);
            $table->boolean('PromotionsEmail')->default(1);
            $table->boolean('NewsUpdateEmail')->default(1);
            $table->boolean('NewMatchPush')->default(1);
            $table->boolean('NewMessagePush')->default(1);
            $table->boolean('SuperLikePush')->default(1);
            $table->boolean('PromotionsPush')->default(1);
            $table->boolean('NewsUpdatePush')->default(1);
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
        Schema::dropIfExists('user_notification_settings');
    }
}
