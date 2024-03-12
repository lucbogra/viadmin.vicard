<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MerchantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('merchants')->truncate();

        DB::table('merchants')->insert([
            ['id' => Str::uuid(), 'name' => 'Meta', 'icon' => 'logos:meta-icon'],
            ['id' => Str::uuid(), 'name' => 'Instagram', 'icon' => 'skill-icons:instagram'],
            ['id' => Str::uuid(), 'name' => 'Tiktok', 'icon' => 'logos:tiktok-icon'],
            ['id' => Str::uuid(), 'name' => 'Snapchat', 'icon' => 'uil:snapchat-square'],
            ['id' => Str::uuid(), 'name' => 'Linkedin', 'icon' => 'devicon:linkedin'],
        ]);
    }
}
