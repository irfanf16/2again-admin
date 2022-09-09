<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFilterFieldToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('filter_have_children')->after('filter_same_languge')->default(0);
            $table->boolean('filter_have_animals')->after('filter_have_children')->default(0);
            $table->boolean('filter_is_smoker')->after('filter_have_animals')->default(0);
            $table->boolean('filter_big_spender_first')->after('filter_is_smoker')->default(0);
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
            $table->dropColumn('filter_have_children');
            $table->dropColumn('filter_have_animals');
            $table->dropColumn('filter_is_smoker');
            $table->dropColumn('filter_big_spender_first');
        });
    }
}
