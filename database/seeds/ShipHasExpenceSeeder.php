<?php

use Illuminate\Database\Seeder;

class ShipHasExpenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1; $i<4 ; $i++) {
            for ($j=1; $j < 4; $j++) { 
                DB::table('ship_has_expences')->insert(
                    array(
                        'ship_id' => $i,
                        'expence_id' => $j,
                        'expence_amount' => rand(50, 90),
                        'active' => true,
                    )
            );    
                
            } 
        }
    }
}
