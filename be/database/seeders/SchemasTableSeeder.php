<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SchemasTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('schemas')->delete();
        
        \DB::table('schemas')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'skema 1',
                'type' => 'tipe skema',
                'image_url' => 'img/schemas/1752959656.png',
                'created_at' => '2025-07-19 14:46:47',
                'updated_at' => '2025-07-19 21:14:16',
            ),
        ));
        
        
    }
}