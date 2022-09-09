<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReferralCodeFieldsToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('gold_ref_code')->after('silver_coin')->nullable()->unique();
            $table->string('silver_ref_code')->after('gold_ref_code')->nullable()->unique();
            $table->string('ref_used')->after('gold_ref_code')->nullable();

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
            $table->dropColumn('gold_ref_code');
            $table->dropColumn('silver_ref_code');
            $table->dropColumn('ref_used');
        });
    }
}
