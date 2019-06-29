<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertyShipTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_ship', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('ship_id')->unsigned();
            $table->bigInteger('property_id')->unsigned();

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
        Schema::dropIfExists('property_ship');
    }
}
