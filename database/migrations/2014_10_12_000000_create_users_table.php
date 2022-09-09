<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('facebook_id')->nullable()->unique();
            $table->string('google_id')->nullable()->unique();
            $table->string('apple_id')->nullable()->unique();
            $table->string('password')->nullable();
            $table->boolean('verified')->default(0);
            $table->integer('gender_id')->nullable();
            $table->integer('religion_id')->nullable();
            $table->integer('country_id')->nullable();
            $table->integer('language_id')->default(21);
            $table->integer('otp')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('university')->nullable();
            $table->string('passion')->nullable();
            $table->string('dob')->nullable();
            $table->string('bio')->nullable();
            $table->string('profile_pic')->nullable();
            $table->integer('interested_in')->nullable();
            $table->integer('gold_coin')->default(0);
            $table->integer('silver_coin')->default(0);
            $table->integer('filter_radius')->default(20);
            $table->integer('filter_gender')->default(1);
            $table->string('filter_date_range')->default('18-70');
            $table->string('filter_purpose')->default('Dating');
            $table->integer('filter_religion')->nullable();
            $table->boolean('filter_my_country')->nullable();
            $table->boolean('filter_same_languge')->default(0);
            $table->boolean('privacy_read_receipt')->default(0);
            $table->boolean('privacy_last_active_status')->default(1);
            $table->boolean('setting_sound')->default(1);
            $table->boolean('setting_vibration')->default(1);
            $table->boolean('setting_light_mode')->default(0);
            $table->boolean('setting_is_paused')->default(0);
            $table->boolean('setting_is_deleted')->default(0);
            $table->boolean('setting_sound_on_notification')->default(1);
            $table->boolean('discovery_be_invisible')->default(0);
            $table->boolean('discovery_my_language')->default(0);
            $table->string('ip');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
