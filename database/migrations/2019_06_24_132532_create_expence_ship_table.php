<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpenceShipTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expence_ship', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('ship_id')->unsigned();
            $table->bigInteger('expence_id')->unsigned();

            $table->foreign('ship_id')->references('id')->on('ships')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('expence_id')->references('id')->on('expences')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expence_ship');
    }
}
