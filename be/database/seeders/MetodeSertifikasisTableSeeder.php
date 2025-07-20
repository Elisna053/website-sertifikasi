<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MetodeSertifikasisTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('metode_sertifikasis')->delete();
        
        \DB::table('metode_sertifikasis')->insert(array (
            0 => 
            array (
                'id' => 1,
                'nama_metode' => 'metodesss update uhuy',
                'file' => 'file/metode_sertifikasi/1752959718.pdf',
                'file_path' => 'http://localhost:8000/file/metode_sertifikasi/1752959718.pdf',
                'deleted_at' => NULL,
                'created_at' => '2025-07-19 17:32:18',
                'updated_at' => '2025-07-19 21:15:18',
            ),
            1 => 
            array (
                'id' => 2,
                'nama_metode' => 'metode',
                'file' => 'file/metode_sertifikasi/1752959709.pdf',
                'file_path' => 'http://localhost:8000/file/metode_sertifikasi/1752959709.pdf',
                'deleted_at' => NULL,
                'created_at' => '2025-07-19 17:48:34',
                'updated_at' => '2025-07-19 21:15:09',
            ),
            2 => 
            array (
                'id' => 3,
                'nama_metode' => 'sss',
                'file' => 'file/metode_sertifikasi/1752959725.pdf',
                'file_path' => 'http://localhost:8000/file/metode_sertifikasi/1752959725.pdf',
                'deleted_at' => NULL,
                'created_at' => '2025-07-19 17:55:21',
                'updated_at' => '2025-07-19 21:15:25',
            ),
        ));
        
        
    }
}