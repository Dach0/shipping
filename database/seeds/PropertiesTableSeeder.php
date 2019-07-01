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
        
        $boat_names=['consumption', 'crew_number', 'max_speed'];


        for ($i=0; $i < 3 ; $i++) { 
            foreach ($boat_names as $key => $value) {
                DB::table('properties')->insert(
                    array(
                        'property_name' => $value,
                        'property_amount' => rand(15, 50) 
                    )
            );    
            }
        }            
    }
}

