<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run() : void
    {
        $this->call(UsersTableSeeder::class);
        $this->call(AssessorsTableSeeder::class);
        $this->call(BerkasAplsTableSeeder::class);
        $this->call(GalleriesTableSeeder::class);
        $this->call(JadwalsTableSeeder::class);
        $this->call(NewsTableSeeder::class);
        $this->call(PartnershipsTableSeeder::class);
        $this->call(TuksTableSeeder::class);
        $this->call(SchemasTableSeeder::class);
        $this->call(SchemaUnitsTableSeeder::class);
        $this->call(StruktursTableSeeder::class);
        $this->call(MetodeSertifikasisTableSeeder::class);
        $this->call(AssesseesTableSeeder::class);
        $this->call(InstancesTableSeeder::class);
    }
}
