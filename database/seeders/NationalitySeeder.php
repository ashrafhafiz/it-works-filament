<?php

namespace Database\Seeders;

use App\Models\Nationality;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class NationalitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $nationalities = [
            [
                'nationality_name_ar' => 'مصرى',
                'nationality_name_en' => 'egyptian',
            ],
            [
                'nationality_name_ar' => 'سوداني',
                'nationality_name_en' => 'Sudanese',
            ],
            [
                'nationality_name_ar' => 'بريطاني',
                'nationality_name_en' => 'British',
            ],
        ];

        // Use the following instead for mysql
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        //
        // for SQL: as in https://github.com/laravel/framework/issues/35401
        // DB::table('nationalities')->delete();
        //
        // Use the following instead for sqlite
        // DB::statement('PRAGMA foreign_keys = OFF;');
        DB::table('nationalities')->truncate();

        foreach ($nationalities as $nationality) {
            Nationality::create($nationality);
        }

        // Use the following instead for mysql
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        //
        // Use the following instead for sqlite
        // DB::statement('PRAGMA foreign_keys = ON;');

        // Nationality::factory()->count(5)->create();
    }
}
