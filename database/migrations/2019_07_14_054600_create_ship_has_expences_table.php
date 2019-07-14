<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShipHasExpencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ship_has_expences', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('ship_id')->unsigned();
            $table->bigInteger('expence_id')->unsigned();
            $table->float('expence_amount');
            $table->boolean('active');
            $table->timestamps();

            $table->foreign('ship_id')->references('id')->on('ships');
            $table->foreign('expence_id')->references('id')->on('expences');
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
