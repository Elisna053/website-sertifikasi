<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class InstancesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('instances')->delete();
        
        \DB::table('instances')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'simrs_umc_prod',
                'slug' => 'simrs-umc-prod',
                'created_at' => '2025-07-19 21:14:51',
                'updated_at' => '2025-07-19 21:14:51',
            ),
        ));
        
        
    }
}