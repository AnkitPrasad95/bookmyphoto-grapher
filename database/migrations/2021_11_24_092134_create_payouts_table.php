<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payout', function (Blueprint $table) {
            $table->increments('id');
            $table->string('request_id');
            $table->integer('request_balance');
            $table->integer('commission');
            $table->integer('commission_amt');
            $table->integer('payable_amt');
            $table->integer('provider_id');
            $table->string('provider_name');
            $table->boolean('status')->default("2")->comment('1=paid,2=pending');
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
        Schema::dropIfExists('payout');
    }
}
