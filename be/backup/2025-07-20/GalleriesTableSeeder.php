<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class GalleriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('galleries')->delete();
        
        \DB::table('galleries')->insert(array (
            0 => 
            array (
                'id' => 1,
                'image_url' => 'img/galleries/1752944914.png',
                'created_at' => '2025-07-19 17:08:34',
                'updated_at' => '2025-07-19 17:08:34',
            ),
        ));
        
        
    }
}