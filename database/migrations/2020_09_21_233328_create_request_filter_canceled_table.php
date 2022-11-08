<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestFilterCanceledTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_filter_canceled', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('request_id');
            $table->integer('provider_id');
            
            $table->double('estimated_fare')->default(0);

            $table->double('s_latitude', 15, 8);
            $table->double('s_longitude', 15, 8);
            $table->double('p_latitude', 15, 8);
            $table->double('p_longitude', 15, 8);

            $table->double('p_distance', 15, 8);
            $table->enum('unit', [
                    'Kms',
                    'Miles'                    
                ])->default('Kms');

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
        Schema::dropIfExists('request_filter_canceled');
    }
}
