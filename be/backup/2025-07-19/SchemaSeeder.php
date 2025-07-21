<?php

namespace Database\Seeders;

use App\Models\Schema;
use App\Models\SchemaUnit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SchemaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $schemas = [
            ['id' => 1, 'name' => 'Sekretaris Yunior'],
            ['id' => 2, 'name' => 'Administrasi Perkantoran'],
            ['id' => 3, 'name' => 'Sekretaris Korporat'],
            ['id' => 4, 'name' => 'Administrasi Perkantoran'],
        ];

        foreach ($schemas as $schema) {
            Schema::create($schema);
        }

        $units = [
            ['id' => 1, 'schema_id' => 1, 'code' => 'N.82ADM00.001.3', 'name' => 'Menangani Penerimaan dan Pengiriman Dokumen'],
            ['id' => 2, 'schema_id' => 1, 'code' => 'N.82ADM00.002.3', 'name' => 'Mengatur Penggandaan dan Pengumpulan Dokumen'],
            ['id' => 3, 'schema_id' => 1, 'code' => 'N.82ADM00.003.3', 'name' => 'Menciptakan Surat dan Lembar Kerja Sederhana'],
            ['id' => 4, 'schema_id' => 1, 'code' => 'N.82ADM00.004.3', 'name' => 'Memproduksi Dokumen'],
            ['id' => 5, 'schema_id' => 1, 'code' => 'N.82ADM00.028.3', 'name' => 'Mengaplikasikan Keterampilan Dasar Komunikasi'],
            ['id' => 6, 'schema_id' => 2, 'code' => 'N.82ADM00.029.3', 'name' => 'Melakukan Komunikasi melalui Telepon'],
            ['id' => 7, 'schema_id' => 2, 'code' => 'N.82ADM00.030.3', 'name' => 'Melakukan Komunikasi Lisan dengan Kolega dan Pelanggan'],
            ['id' => 8, 'schema_id' => 2, 'code' => 'N.82ADM00.049.3', 'name' => 'Memenuhi Kebutuhan Pelanggan'],
            ['id' => 9, 'schema_id' => 2, 'code' => 'N.82ADM00.054.2', 'name' => 'Menggunakan Peralatan Komunikasi'],
            ['id' => 10, 'schema_id' => 2, 'code' => 'N.82ADM00.057.3', 'name' => 'Mengoperasikan Aplikasi Perangkat Lunak'],
            ['id' => 11, 'schema_id' => 2, 'code' => 'N.82ADM00.058.3', 'name' => 'Mengakses Data di Alat Pengolah Data dan Angka'],
            ['id' => 12, 'schema_id' => 3, 'code' => 'N.82ADM00.059.3', 'name' => 'Menggunakan Peralatan dan Sumber daya Kerja'],
            ['id' => 13, 'schema_id' => 3, 'code' => 'N.82ADM00.075.3', 'name' => 'Menerapkan Prosedur Keselamatan dan Kesehatan Kerja Perkantoran'],
            ['id' => 14, 'schema_id' => 3, 'code' => 'N.82ADM00.076.3', 'name' => 'Meminimalisasi Pencurian'],
            ['id' => 15, 'schema_id' => 3, 'code' => 'N.82ADM00.032.3', 'name' => 'Melakukan Komunikasi Lisan dalam Bahasa Inggris Pada Tingkat Operasional Dasar'],
            ['id' => 16, 'schema_id' => 4, 'code' => 'N.82ADM00.033.3', 'name' => 'Membaca Dalam Bahasa Inggris pada Tingkat Operasional Dasar'],
            ['id' => 17, 'schema_id' => 4, 'code' => 'N.82ADM00.045.3', 'name' => 'Memberikan Pelayanan Kepada Pelanggan'],
            ['id' => 18, 'schema_id' => 4, 'code' => 'N.82ADM00.051.2', 'name' => 'Menerapkan Etika Profesi'],
            ['id' => 19, 'schema_id' => 4, 'code' => 'N.82ADM00.056.3', 'name' => 'Memelihara Data atau File di Alat Pengolah Data dan Angka'],
            ['id' => 20, 'schema_id' => 4, 'code' => 'N.82ADM00.073.3', 'name' => 'Mengelola Arsip']   
        ];

        foreach ($units as $unit) {
            SchemaUnit::create($unit);
        }
    }
}
