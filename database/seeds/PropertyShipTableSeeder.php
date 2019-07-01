<?php

use Illuminate\Database\Seeder;

class PropertyShipTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $ship_ids = [1,2,3];
        $z = 0;
        for ($i=1; $i < 4; $i++) { 
            for ($j=0; $j < 3; $j++) { 
                DB::table('property_ship')->insert(
                array(
                    'ship_id' => $i,
                    'property_id' => $z+1,
            )
        );   
        $z++;
            }    
        }
        
    }
}
