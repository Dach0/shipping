<?php

use Illuminate\Database\Seeder;

class ExpenceShipTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $z = 3;
        for ($i=1; $i < 4; $i++) { 
            for ($j=0; $j < 3; $j++) { 
                DB::table('expence_ship')->insert(
                array(
                    'ship_id' => $i,
                    'expence_id' => $z+1,
            )
        );   
        $z++;
            }    
        }
    }
}
