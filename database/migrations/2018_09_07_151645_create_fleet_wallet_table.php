<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFleetWalletTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fleet_wallet', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fleet_id');
            $table->integer('transaction_id');
            $table->string('transaction_alias')->nullable();
            $table->string('transaction_desc')->nullable();            
            $table->enum('type', [
                    'C',
                    'D',
                ]);
            $table->double('amount', 15, 8)->default(0);
            $table->double('open_balance', 15, 8)->default(0);
            $table->double('close_balance', 15, 8)->default(0);
            $table->enum('payment_mode', [
                    'BRAINTREE',
                    'CARD',
                    'PAYPAL',
                    'PAYUMONEY',
                    'PAYTM'
                ]);

            $table->integer('form_of_payment')->nullable();
            $table->integer('category_id')->nullable();

            $table->boolean('is_real')->default(false);
            $table->double('commission', 15, 8)->default(0);
            
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
        Schema::dropIfExists('fleet_wallet');
    }
}
