<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('provider_name')->nullable();
            $table->string('image')->nullable();
            $table->string('marker')->nullable();
            $table->integer('capacity')->default(0);
            $table->double('fixed', 10, 2);
            $table->double('price', 10, 2);
            $table->double('minute', 10, 2);
            $table->double('min_price', 10, 2);
            $table->integer('hour')->nullable();
            $table->integer('distance');
            $table->integer('service_type_vehicle')->default(2);
            $table->enum('calculator', ['MIN', 'HOUR', 'DISTANCE', 'DISTANCEMIN', 'DISTANCEHOUR']);
            $table->string('description')->nullable();
            $table->integer('waiting_free_mins')->default(0);
            $table->float('waiting_min_charge', 10, 2)->default(0);
            $table->integer('status')->default(0);
            $table->integer('fleet_id')->default(0);
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
        Schema::dropIfExists('service_types');
    }
}