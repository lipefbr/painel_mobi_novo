<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFleetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fleets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            
            $table->string('logo')->nullable();
            $table->double('commission', 5,2)->default(0);
            $table->double('commission_fix', 5,2)->default(0);
            $table->double('wallet_balance', 10,2)->default(0);
            $table->string('stripe_cust_id')->nullable();
            $table->string('language',10)->nullable();
            $table->integer('city_id')->nullable();
            $table->integer('admin_id')->default(0);
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('fleets');
    }
}
