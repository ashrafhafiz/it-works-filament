<?php

namespace Database\Seeders;

use App\Models\Location;
use App\Models\Sector;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sectors = [
            ['name' => 'Business Excellence'],
            ['name' => 'Commercial'],
            ['name' => 'Finance & Legal'],
            ['name' => 'Operations'],
            ['name' => 'Supply Chain'],
        ];

        // Use the following instead for mysql
        // DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        //
        // for SQL: as in https://github.com/laravel/framework/issues/35401
        // DB::table('sectors')->delete();
        //
        // Use the following instead for sqlite
        DB::statement('PRAGMA foreign_keys = OFF;');
        DB::table('sectors')->truncate();

        foreach ($sectors as $sector) {

            Sector::create($sector);
        }

        // Use the following instead for mysql
        // DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        //
        // Use the following instead for sqlite
        DB::statement('PRAGMA foreign_keys = ON;');

        // Sector::factory()->count(5)->create();
    }
}
