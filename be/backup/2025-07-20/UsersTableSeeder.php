<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'email_verified_at' => NULL,
                'phone_number' => NULL,
                'address' => NULL,
                'password' => '$2y$12$TmgNV2Swgl1oCh9INO5W9eXxP4eLGngrBMt6n3QEAwgRfnS2SzWW2',
                'role' => 'admin',
                'remember_token' => NULL,
                'created_at' => '2025-07-17 05:39:18',
                'updated_at' => '2025-07-17 05:39:18',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'User',
                'email' => 'user@gmail.com',
                'email_verified_at' => NULL,
                'phone_number' => NULL,
                'address' => NULL,
                'password' => '$2y$12$aOjvf.mtixGlrncab0888.yADumUblyjHrdVU4kne4w2DVtlxVD12',
                'role' => 'user',
                'remember_token' => NULL,
                'created_at' => '2025-07-17 05:39:18',
                'updated_at' => '2025-07-17 05:39:18',
            ),
        ));
        
        
    }
}