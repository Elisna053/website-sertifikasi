<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SchemaUnitsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('schema_units')->delete();
        
        \DB::table('schema_units')->insert(array (
            0 => 
            array (
                'id' => 1,
                'schema_id' => 1,
                'code' => 'unit',
                'name' => 'uniiiiit',
                'created_at' => '2025-07-19 14:50:21',
                'updated_at' => '2025-07-19 14:50:21',
            ),
            1 => 
            array (
                'id' => 2,
                'schema_id' => 1,
                'code' => 'unit 2',
                'name' => 'unit ke 2',
                'created_at' => '2025-07-19 21:14:27',
                'updated_at' => '2025-07-19 21:14:27',
            ),
        ));
        
        
    }
}