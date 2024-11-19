<?php

namespace Database\Seeders;

use App\Models\DeviceType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeviceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = ["Laptop", "Desktop", "Printer", "Scanner", "Photocopier", "Server", "Storage"];

        // Use the following instead for mysql
        // DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        //
        // for SQL: as in https://github.com/laravel/framework/issues/35401
        // DB::table('device_types')->delete();
        //
        // Use the following instead for sqlite
        DB::statement('PRAGMA foreign_keys = OFF;');
        DB::table('device_types')->truncate();

        foreach ($types as $type) {
            DeviceType::create([
                'type' => $type
            ]);
        }

        // Use the following instead for mysql
        // DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        //
        // Use the following instead for sqlite
        DB::statement('PRAGMA foreign_keys = ON;');
        // DeviceType::factory()->count(5)->create();
    }
}
