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
        
        
        
    }
}