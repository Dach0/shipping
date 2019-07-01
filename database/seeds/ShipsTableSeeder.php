<?php

use Illuminate\Database\Seeder;

class ShipsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // factory(App\Ship::class, 3)->create();
        $boat_names = ['Barakuda', 'Kapetan kuka', 'Jegulja'];

        foreach ($boat_names as $key => $value) {
            DB::table('ships')->insert(
                array(
                    'boat_name' => $value
                     )
        );}
    }
}
