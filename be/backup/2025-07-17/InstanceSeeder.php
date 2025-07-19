<?php

namespace Database\Seeders;

use App\Models\Instance;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InstanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $instances = [
            ['id' => 1, 'name' => 'First Instance', 'slug' => 'first-instance'],
            ['id' => 2, 'name' => 'Second Instance', 'slug' => 'second-instance'],
        ];

        foreach ($instances as $instance) {
            Instance::create($instance);
        }
    }
}
