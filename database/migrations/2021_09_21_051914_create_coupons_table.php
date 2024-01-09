<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('service_id');
            $table->string('code');
            $table->boolean('discount_type')->comment('1 For Fixed,2 For Percentage');
            $table->integer('discount');
            $table->date('start_date');
            $table->date('expire_date');
            $table->string('description');
            $table->boolean('is_available')->comment('1 For yes,2 For No');
            $table->boolean('is_deleted')->comment('1 For Yes,2 For No');
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
        Schema::dropIfExists('coupons');
    }
}
