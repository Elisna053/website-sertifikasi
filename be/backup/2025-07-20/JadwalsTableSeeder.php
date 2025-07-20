<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class JadwalsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('jadwals')->delete();
        
        \DB::table('jadwals')->insert(array (
            0 => 
            array (
                'id' => 1,
                'instance_id' => 1,
                'date' => '2025-07-25',
                'deleted_at' => NULL,
                'created_at' => '2025-07-19 14:46:58',
                'updated_at' => '2025-07-19 14:46:58',
            ),
            1 => 
            array (
                'id' => 2,
                'instance_id' => 2,
                'date' => '2025-07-31',
                'deleted_at' => NULL,
                'created_at' => '2025-07-19 18:10:17',
                'updated_at' => '2025-07-19 18:10:17',
            ),
        ));
        
        
    }
}