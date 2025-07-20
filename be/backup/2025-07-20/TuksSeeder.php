<?php

namespace Database\Seeders;

use App\Models\Tuks;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TuksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void

    {
        $tuks = [
            ['id' => 1, 'name' => 'BPKH', 'image_url' => null, 'address' => 'Jl. Imam Bonjol', 'phone' => '081234567890', 'type' => 'Sewaktu'],
            ['id' => 2, 'name' => 'P2KPTK2 Jakarta', 'image_url' => null, 'address' => 'Jl. Imam Bonjol', 'phone' => '081234567890', 'type' => 'Sewaktu'],
            ['id' => 3, 'name' => 'Balai Besar Keramik', 'image_url' => null, 'address' => 'Jl. Imam Bonjol', 'phone' => '081234567890', 'type' => 'Sewaktu'],
            ['id' => 4, 'name' => 'Piksi Megatama Bandung', 'image_url' => null, 'address' => 'Jl. Imam Bonjol', 'phone' => '081234567890', 'type' => 'Sewaktu'],
            ['id' => 5, 'name' => 'Bexpert Indoprima', 'image_url' => null, 'address' => 'Jl. Imam Bonjol', 'phone' => '081234567890', 'type' => 'Sewaktu'],
            ['id' => 6, 'name' => 'Politeknik Negeri Pontianak', 'image_url' => null, 'address' => 'Jl. Imam Bonjol', 'phone' => '081234567890', 'type' => 'Sewaktu'],
            ['id' => 7, 'name' => 'California Hotel Bandung', 'image_url' => null, 'address' => 'Jl. Imam Bonjol', 'phone' => '081234567890', 'type' => 'Sewaktu'],
            ['id' => 8, 'name' => 'SMKN 1 TASIK', 'image_url' => null, 'address' => 'Jl. Imam Bonjol', 'phone' => '081234567890', 'type' => 'Sewaktu'],
            ['id' => 9, 'name' => 'Graha Kadin Bandung', 'image_url' => null, 'address' => 'Jl. Imam Bonjol', 'phone' => '081234567890', 'type' => 'Sewaktu'],
            ['id' => 10, 'name' => 'SMKS PGRI 31 Legok Kab. Tangerang', 'image_url' => null, 'address' => 'Jl. Imam Bonjol', 'phone' => '081234567890', 'type' => 'Sewaktu'],
            ['id' => 11, 'name' => 'Grand Tebu Hotel Bandung', 'image_url' => null, 'address' => 'Jl. Imam Bonjol', 'phone' => '081234567890', 'type' => 'Sewaktu'],
            ['id' => 12, 'name' => 'ST3 Bandung', 'image_url' => null, 'address' => 'Jl. Imam Bonjol', 'phone' => '081234567890', 'type' => 'Sewaktu'],
            ['id' => 13, 'name' => 'Hotel Cordela', 'image_url' => null, 'address' => 'Jl. Imam Bonjol', 'phone' => '081234567890', 'type' => 'Sewaktu'],
            ['id' => 14, 'name' => 'STIE Ekuitas Bandung', 'image_url' => null, 'address' => 'Jl. Imam Bonjol', 'phone' => '081234567890', 'type' => 'Sewaktu'],
            ['id' => 15, 'name' => 'IDE LPKIA', 'image_url' => null, 'address' => 'Jl. Imam Bonjol', 'phone' => '081234567890', 'type' => 'Sewaktu'],
            ['id' => 16, 'name' => 'Setwan Jabar', 'image_url' => null, 'address' => 'Jl. Imam Bonjol', 'phone' => '081234567890', 'type' => 'Sewaktu'],
            ['id' => 17, 'name' => 'LPK Pelita Cahaya Bangsa', 'image_url' => null, 'address' => 'Jl. Imam Bonjol', 'phone' => '081234567890', 'type' => 'Sewaktu'],
            ['id' => 18, 'name' => 'TIRTA GANGGA', 'image_url' => null, 'address' => 'Jl. Imam Bonjol', 'phone' => '081234567890', 'type' => 'Sewaktu'],
        ];

        foreach ($tuks as $tuks) {
            Tuks::create($tuks);
        }
    }
}
