<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class StruktursTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('strukturs')->delete();
        
        \DB::table('strukturs')->insert(array (
            0 => 
            array (
                'id' => 1,
                'struktur_name' => 'ddd',
                'struktur_posis' => 'ddd',
                'image_url' => 'img/struktur/1752730820.png',
                'image' => 'C:\\xampp\\tmp\\php885A.tmp',
                'deleted_at' => NULL,
                'created_at' => '2025-07-17 05:40:20',
                'updated_at' => '2025-07-17 05:40:20',
            ),
        ));
        
        
    }
}