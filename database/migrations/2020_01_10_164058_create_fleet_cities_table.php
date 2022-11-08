<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFleetCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fleet_cities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fleet_id')->nullable();
            $table->integer('city_id')->nullable();
            $table->string('city_name')->nullable();
            $table->string('estate_name')->nullable();
            $table->nullableTimestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fleet_cities');
    }
}
