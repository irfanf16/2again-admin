<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLegalFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('terms_of_user')->default(0)->after('device_id');
            $table->integer('privacy_policy')->default(0)->after('terms_of_user');
            $table->integer('consent')->default(0)->after('privacy_policy');
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
            $table->dropColumn('terms_of_user');
            $table->dropColumn('privacy_policy');
            $table->dropColumn('consent');
        });
    }
}
