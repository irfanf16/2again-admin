<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSeenMeNotificationPreferencesToUserNotificationSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_notification_settings', function (Blueprint $table) {
            $table->boolean('SeenMeEmail')->after('NewsUpdateEmail')->default(1);
            $table->boolean('SeenMePush')->after('NewsUpdatePush')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_notification_settings', function (Blueprint $table) {
            $table->dropColumn('SeenMeEmail');
            $table->dropColumn('SeenMePush');
        });
    }
}
