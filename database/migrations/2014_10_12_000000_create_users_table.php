<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->bigInteger('role_id')->unsigned()->default('2');
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });

        DB::table('users')->insert(
            array(
                'name' => 'damjan',
                'email' => 'damjan@gmail.com',
                'password' => app('hash')->make('krivacevic'),
                'role_id' => '1',
            )
        );
        DB::table('users')->insert(
            array(
                'name' => 'operater',
                'email' => 'operater@gmail.com',
                'password' => app('hash')->make('operater'),
                'role_id' => '2',
            )
        );
        DB::table('users')->insert(
            array(
                'name' => 'prodaja',
                'email' => 'prodaja@gmail.com',
                'password' => app('hash')->make('prodaja'),
                'role_id' => '3',
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
