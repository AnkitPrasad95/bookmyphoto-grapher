<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHandymenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('handymen', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('provider_id');
            $table->string('fname');
            $table->string('lname');
            $table->string('contact');
            $table->string('address');
            $table->integer('city_id');
            $table->string('email');
            $table->string('password');
            $table->string('image');
            $table->boolean('is_available');
            $table->boolean('is_deleted');
            $table->timestamp('email_verified_at')->nullable();
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
        Schema::dropIfExists('handymen');
    }
}
