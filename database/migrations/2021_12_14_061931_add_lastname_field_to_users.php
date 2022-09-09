<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLastnameFieldToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('users', function (Blueprint $table) {
            $table->string('lastname')->after('name')->nullable();
            $table->integer('status_id')->after('bio')->nullable();
            $table->boolean('have_children')->nullable()->after('status_id');
            $table->boolean('have_animals')->nullable()->after('have_children');
            $table->boolean('is_smoker')->nullable()->after('have_children');
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
            $table->dropColumn('lastname');
            $table->dropColumn('have_children');
            $table->dropColumn('have_animals');
            $table->dropColumn('is_smoker');
            $table->dropColumn('status_id');
        });
    }
}
