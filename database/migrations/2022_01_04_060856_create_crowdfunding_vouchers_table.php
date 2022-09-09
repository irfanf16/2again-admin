<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrowdfundingVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crowdfunding_vouchers', function (Blueprint $table) {
            $table->id();
            $table->integer('company_id');
            $table->string('voucher_code');
            $table->string('subscription_type');
            $table->string('subscription_month');
            $table->string('associate_product_credit')->default(0);
            $table->string('is_used')->default(0);
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
        Schema::dropIfExists('crowdfunding_vouchers');
    }
}
