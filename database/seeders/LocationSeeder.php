<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        $locations = [
            [
                'name' => 'Head Office',
                'address' => '6 Ibn Malek St., Nahda Sq.',
                'city' => 'Giza',
                'postal_code' => '12311',
                'country' => 'Egypt'
            ],
            [
                'name' => 'LV Factory',
                'address' => 'Industrial Zone',
                'city' => '6th of October',
                'postal_code' => 'NA',
                'country' => 'Egypt'
            ],
            [
                'name' => 'MV/HV Factory',
                'address' => 'Industrial Zone',
                'city' => '6th of October',
                'postal_code' => 'NA',
                'country' => 'Egypt'
            ]
        ];

        // Use the following instead for mysql
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        //
        // for SQL: as in https://github.com/laravel/framework/issues/35401
        // DB::table('locations')->delete();
        //
        // Use the following instead for sqlite
        // DB::statement('PRAGMA foreign_keys = OFF;');
        DB::table('locations')->truncate();

        foreach ($locations as $location) {
            Location::create($location);
        }

        // Use the following instead for mysql
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        //
        // Use the following instead for sqlite
        // DB::statement('PRAGMA foreign_keys = ON;');

        // Location::factory()->count(5)->create();
    }
}
