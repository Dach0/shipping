<?php

use Illuminate\Database\Seeder;

class ExpencesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
     public function run()
     {
        // factory(App\Property::class, 6)->create();
        
        $expences=['avg_paycheck', 'fuel_price', 'food_price'];

        foreach ($expences as $key => $value) {
            DB::table('expences')->insert(
                    array(
                        'expence_name' => $value,
                    )
            );
        }           
    }
}
