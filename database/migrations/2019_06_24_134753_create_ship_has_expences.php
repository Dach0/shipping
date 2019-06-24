<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShipHasExpences extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ship_has_expences', function (Blueprint $table) {
            $table->bigInteger('ship_id')->unsigned();
            $table->bigInteger('expences_id')->unsigned();

            $table->foreign('ship_id')->references('id')->on('ships');
            $table->foreign('expences_id')->references('id')->on('expenses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ship_has_expences');
    }
}
