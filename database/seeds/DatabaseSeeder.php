<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(DestinationsTableSeeder::class);
        $this->call(ShipsTableSeeder::class);
        $this->call(PropertiesTableSeeder::class);
        $this->call(PropertyShipTableSeeder::class);
        $this->call(ExpencesTableSeeder::class);
        $this->call(ExpenceShipTableSeeder::class);
    }
}
