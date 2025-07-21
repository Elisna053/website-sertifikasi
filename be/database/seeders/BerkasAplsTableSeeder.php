<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BerkasAplsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('berkas_apls')->delete();
        
        \DB::table('berkas_apls')->insert(array (
            0 => 
            array (
                'id' => 40,
                'assessee_id' => 1,
                'schema_id' => 1,
                'schema_unit_id' => 1,
                'user_id' => 1,
                'file' => 'apl_Admin_unit_1_20250720184636.pdf',
                'file_path' => 'file/apl_Admin_unit_1_20250720184636.pdf',
                'type' => 'unit',
                'deleted_at' => NULL,
                'created_at' => '2025-07-20 18:46:36',
                'updated_at' => '2025-07-20 18:46:36',
            ),
            1 => 
            array (
                'id' => 41,
                'assessee_id' => 1,
                'schema_id' => 1,
                'schema_unit_id' => 2,
                'user_id' => 1,
                'file' => 'apl_Admin_unit_2_20250720184731.pdf',
                'file_path' => 'file/apl_Admin_unit_2_20250720184731.pdf',
                'type' => 'unit',
                'deleted_at' => NULL,
                'created_at' => '2025-07-20 18:46:37',
                'updated_at' => '2025-07-20 18:47:31',
            ),
            2 => 
            array (
                'id' => 42,
                'assessee_id' => 1,
                'schema_id' => 1,
                'schema_unit_id' => NULL,
                'user_id' => 1,
                'file' => 'apl_Admin_unit__20250720184638.pdf',
                'file_path' => 'file/apl_Admin_unit__20250720184638.pdf',
                'type' => 'additional',
                'deleted_at' => NULL,
                'created_at' => '2025-07-20 18:46:38',
                'updated_at' => '2025-07-20 18:46:38',
            ),
        ));
        
        
    }
}