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
                'id' => 1,
                'assessee_id' => 1,
                'schema_id' => 1,
                'schema_unit_id' => 1,
                'user_id' => 2,
                'file' => 'apl_User_unit_1_20250719145033.pdf',
                'file_path' => 'file/apl_User_unit_1_20250719145033.pdf',
                'deleted_at' => NULL,
                'created_at' => '2025-07-19 14:50:33',
                'updated_at' => '2025-07-19 14:50:33',
            ),
        ));
        
        
    }
}