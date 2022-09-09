<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOtherAppCompanyIdToOtherApps extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('other_apps', function (Blueprint $table) {
            $table->integer('other_app_company_id')->after('id')->default(1);
            $table->string('downloads')->after('bundle_id_ios')->default(0);
            $table->string('clicks')->after('bundle_id_ios')->default(0);
            $table->string('all_over_world')->after('bundle_id_ios')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('other_apps', function (Blueprint $table) {
        });
    }
}
