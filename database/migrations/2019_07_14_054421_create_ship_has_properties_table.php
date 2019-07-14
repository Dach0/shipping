<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShipHasPropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ship_has_properties', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('ship_id')->unsigned();
            $table->bigInteger('property_id')->unsigned();
            $table->float('property_amount');
            $table->boolean('active');
            $table->timestamps();

            $table->foreign('ship_id')->references('id')->on('ships');
            $table->foreign('property_id')->references('id')->on('properties');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ship_has_properties');
    }
}
