<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SystemSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            NationalitySeeder::class,
            ReligionSeeder::class,
            GovernmentSeeder::class,
            GraduationSeeder::class,
            DivisionSeeder::class,
            JobCategorySeeder::class,
            JobTitleSeeder::class,
        ]);
    }
}
