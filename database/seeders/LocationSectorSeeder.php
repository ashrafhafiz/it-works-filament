<?php

namespace Database\Seeders;

use App\Models\Sector;
use App\Models\Location;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LocationSectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'Head Office' => ['Business Excellence', 'Commercial', 'Finance & Legal', 'Supply Chain'],
            'LV Factory' => ['Business Excellence', 'Commercial', 'Finance & Legal', 'Operations', 'Supply Chain'],
            'MV/HV Factory' => ['Business Excellence', 'Commercial', 'Operations'],
        ];
        // Use the following instead for mysql
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        //
        // for SQL: as in https://github.com/laravel/framework/issues/35401
        // DB::table('location_sector')->delete();
        //
        // Use the following instead for sqlite
        // DB::statement('PRAGMA foreign_keys = OFF;');
        DB::table('location_sector')->truncate();

        foreach ($data as $location => $sectors) {
            foreach ($sectors as $sector) {
                DB::table('location_sector')->insert([
                    'location_id' => Location::where('name', $location)->get()->first()->id,
                    'sector_id' => Sector::where('name', $sector)->get()->first()->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'created_by' => Sector::getDefaultAdminId(),
                ]);
            }
        }

        // Use the following instead for mysql
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        //
        // Use the following instead for sqlite
        // DB::statement('PRAGMA foreign_keys = ON;');
    }
}
