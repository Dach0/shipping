<?php

use Illuminate\Database\Seeder;

class PropertiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // factory(App\Property::class, 6)->create();
        
        $properties=['consumption', 'crew_number', 'max_speed'];


            foreach ($properties as $key => $value) {
                DB::table('properties')->insert(
                    array(
                        'property_name' => $value,
                    )
            );    
            }
    }
}

