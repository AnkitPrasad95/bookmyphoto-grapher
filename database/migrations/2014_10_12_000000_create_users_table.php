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
            $table->increments('id');
            $table->string('name');
            $table->string('email');
            $table->string('mobile');
            $table->string('image');
            $table->string('password');
            $table->string('login_type');
            $table->string('google_id')->nullable();
            $table->string('facebook_id')->nullable();
            $table->boolean('type')->comment('1=Admin,2=Provider,3=Handyman,4=User/Customer');
            $table->longText('token')->nullable();
            $table->string('referral_code')->nullable();
            $table->string('wallet')->nullable();
            $table->string('otp')->nullable();
            $table->boolean('is_verified')->comment('1=Yes,2=No');
            $table->boolean('is_available')->comment('1=Yes,2=No');
            $table->rememberToken();
            $table->timestamps();
            // ->default('1')
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
