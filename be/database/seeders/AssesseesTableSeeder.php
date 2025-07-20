<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AssesseesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('assessees')->delete();
        
        \DB::table('assessees')->insert(array (
            0 => 
            array (
                'id' => 1,
                'user_id' => 1,
                'instance_id' => 1,
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'phone_number' => '85161145097',
                'address' => 'Kp. Kaliwangi 02/03
Desa Jatisari Kec. Sindangbarang',
                'identity_number' => '2222222222222222',
                'birth_date' => '2025-07-30 00:00:00',
                'birth_place' => '3232323',
                'last_education_level' => 'S2',
                'schema_id' => 1,
                'method' => NULL,
                'metode_sertifikasi_id' => NULL,
                'assessment_date' => '2025-07-31 00:00:00',
                'last_education_certificate_path' => 'img/assessees/1752959784_last_education_certificate.pdf',
                'identity_card_path' => 'img/assessees/1752959784_identity_card.pdf',
                'family_card_path' => 'img/assessees/1752959784_family_card.pdf',
                'self_photo_path' => 'img/assessees/1752959784_self_photo.png',
                'apl01_path' => 'img/assessees/1752959784_apl01.pdf',
                'apl02_path' => NULL,
                'supporting_documents_path' => NULL,
                'assessment_result' => NULL,
                'assessment_status' => 'approved',
                'created_at' => '2025-07-19 21:16:24',
                'updated_at' => '2025-07-19 21:16:30',
            ),
        ));
        
        
    }
}