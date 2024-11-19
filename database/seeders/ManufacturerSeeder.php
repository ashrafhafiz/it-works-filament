<?php

namespace Database\Seeders;

use App\Models\Manufacturer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ManufacturerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $manufacturers = ["Dell", "HP", "Lenovo", "Canon", "Xerox", "WD", "Epson"];

        // Use the following instead for mysql
        // DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        //
        // for SQL: as in https://github.com/laravel/framework/issues/35401
        // DB::table('manufacturers')->delete();
        //
        // Use the following instead for sqlite
        DB::statement('PRAGMA foreign_keys = OFF;');
        DB::table('manufacturers')->truncate();

        foreach ($manufacturers as $manufacturer) {
            Manufacturer::create([
                'name' => $manufacturer
            ]);
        }

        // Use the following instead for mysql
        // DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        //
        // Use the following instead for sqlite
        DB::statement('PRAGMA foreign_keys = ON;');
        // Manufacturer::factory()->count(5)->create();
    }
}
