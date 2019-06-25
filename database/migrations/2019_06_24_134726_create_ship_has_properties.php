<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShipHasProperties extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ship_has_properties', function (Blueprint $table) {
            $table->bigInteger('ship_id')->unsigned();
            $table->bigInteger('properties_id')->unsigned();

            $table->foreign('ship_id')->references('id')->on('ships');
            $table->foreign('properties_id')->references('id')->on('properties');
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
