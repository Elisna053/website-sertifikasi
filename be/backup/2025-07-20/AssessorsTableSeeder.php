<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AssessorsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('assessors')->delete();
        
        \DB::table('assessors')->insert(array (
            0 => 
            array (
                'id' => 1,
                'assessor_name' => 'aaa',
                'posisi_assessor' => 'ddd',
                'image_url' => 'img/assessor/1752731898.png',
                'image' => 'C:\\xampp\\tmp\\phpFC84.tmp',
                'deleted_at' => NULL,
                'created_at' => '2025-07-17 05:58:18',
                'updated_at' => '2025-07-17 05:58:18',
            ),
            1 => 
            array (
                'id' => 2,
                'assessor_name' => 'ddffff',
                'posisi_assessor' => 'fffff',
                'image_url' => 'img/assessor/1752732414.jpg',
                'image' => 'C:\\xampp\\tmp\\phpDC44.tmp',
                'deleted_at' => NULL,
                'created_at' => '2025-07-17 06:06:54',
                'updated_at' => '2025-07-17 06:06:54',
            ),
            2 => 
            array (
                'id' => 3,
                'assessor_name' => 'momok',
                'posisi_assessor' => 'momok',
                'image_url' => 'img/assessor/1752732521.jpg',
                'image' => 'C:\\xampp\\tmp\\php7C49.tmp',
                'deleted_at' => NULL,
                'created_at' => '2025-07-17 06:08:41',
                'updated_at' => '2025-07-17 06:08:41',
            ),
            3 => 
            array (
                'id' => 4,
                'assessor_name' => 'hhhhh',
                'posisi_assessor' => 'hhhhh',
                'image_url' => 'img/assessor/1752732543.png',
                'image' => 'C:\\xampp\\tmp\\phpD363.tmp',
                'deleted_at' => NULL,
                'created_at' => '2025-07-17 06:09:03',
                'updated_at' => '2025-07-17 06:09:03',
            ),
            4 => 
            array (
                'id' => 5,
                'assessor_name' => 'kimtul',
                'posisi_assessor' => 'khontool',
                'image_url' => 'img/assessor/1752732596.png',
                'image' => 'C:\\xampp\\tmp\\phpA153.tmp',
                'deleted_at' => NULL,
                'created_at' => '2025-07-17 06:09:56',
                'updated_at' => '2025-07-17 06:09:56',
            ),
        ));
        
        
    }
}