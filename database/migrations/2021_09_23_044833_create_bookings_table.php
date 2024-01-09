<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('booking_id');
            $table->integer('user_id');
            $table->integer('service_id');
            $table->string('service_image');
            $table->string('service_name');
            $table->integer('provider_id');
            $table->string('provider_name');
            $table->integer('handyman_id')->nullable();
            $table->string('price');
            $table->string('price_type');
            $table->integer('qty')->default('1');
            $table->string('duration')->nullable();
            $table->date('date');
            $table->time('time');
            $table->string('address');
            $table->string('coupon_code')->nullable();
            $table->string('discount')->nullable();
            $table->string('note')->nullable();
            $table->boolean('payment_type')->comment('1 For Razorpay,2 For Stripe,3 For COD');
            $table->string('transaction_id')->nullable();
            $table->boolean('status')->default('3')->comment('1 For accepted,2 For Pending,3 For completed,4 For Canceled');
            $table->boolean('canceled_by')->nullable()->comment('1 For Provider,2 For User/Customer');
            $table->timestamps();
            // $table->increments('id');
            // $table->integer('service_id');
            // $table->integer('provider_id');
            // $table->integer('handyman_id');
            // $table->integer('user_id');
            // $table->boolean('payment_status');
            // $table->dateTime('date');
            // $table->boolean('is_completed');
            // $table->boolean('is_deleted')->default('2');
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
