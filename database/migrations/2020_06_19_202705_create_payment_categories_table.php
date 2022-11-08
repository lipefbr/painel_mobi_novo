<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_categories', function (Blueprint $table) {
            
            $table->increments('id');
            
            $table->string('name');
            $table->string('color', 8)->default('#546e7a')->nullable(); // label color
            $table->integer('type')->default(0); // 0 outros, 1 despesas, 2 receitas
            $table->integer('status')->default(1);
            $table->integer('parent_id')->default(0);

            $table->boolean('blocked')->default(true);

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
        Schema::dropIfExists('payment_categories');
    }
}
