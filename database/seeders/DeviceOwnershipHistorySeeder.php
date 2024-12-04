<?php

namespace Database\Seeders;

use Carbon\Carbon;
use League\Csv\Reader;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\DeviceOwnershipHistory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DeviceOwnershipHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = database_path('csvs/devices_v2.csv');
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);

        $records = $csv->getRecords();

        // Use the following instead for mysql
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        //
        // for SQL: as in https://github.com/laravel/framework/issues/35401
        // DB::table('device_ownership_histories')->delete();
        //
        // Use the following instead for sqlite
        // DB::statement('PRAGMA foreign_keys = OFF;');
        DB::table('device_ownership_histories')->truncate();

        foreach ($records as $record) {
            DeviceOwnershipHistory::create([
                'service_tag' => $record['service_tag'],
                'employee_no' => $record['employee_no'],
                'assigned_date' => Carbon::createFromDate('2024', '1', '1'),
            ]);
        }

        // Use the following instead for mysql
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        //
        // Use the following instead for sqlite
        // DB::statement('PRAGMA foreign_keys = ON;');
        // DeviceOwnershipHistorySeeder::factory()->count(5)->create();
    }
}