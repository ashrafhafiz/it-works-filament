<?php

namespace Database\Seeders;

use App\Models\Device;
use League\Csv\Reader;
use App\Models\DeviceType;
use App\Models\Manufacturer;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeviceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = database_path('csvs/devices.csv');
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);

        $records = $csv->getRecords();

        // Use the following instead for mysql
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        //
        // for SQL: as in https://github.com/laravel/framework/issues/35401
        // DB::table('devices')->delete();
        //
        // Use the following instead for sqlite
        // DB::statement('PRAGMA foreign_keys = OFF;');
        DB::table('devices')->truncate();

        foreach ($records as $record) {
            $manufacturer_id = Manufacturer::where('name', $record['manufacturer'])->get()->first()->id;
            $device_type_id = DeviceType::where('type', $record['device_type'])->get()->first()->id;

            Device::create([
                'model' => $record['model'],
                'service_tag' => $record['service_tag'],
                'processor_type' => $record['processor_type'],
                'memory_size' => $record['memory_size'],
                'storage1_size' => $record['storage1_size'],
                'storage2_size' => $record['storage2_size'],
                'graphics_1' => $record['graphics_1'],
                'graphics_2' => $record['graphics_2'],
                'sound' => $record['sound'],
                'ethernet' => $record['ethernet'],
                'wireless' => $record['wireless'],
                'display' => $record['display'],
                'shipping_date' => Carbon::today(),
                'status' => $record['status'],
                'employee_no' => $record['employee_no'],
                'manufacturer_id' => $manufacturer_id,
                'device_type_id' => $device_type_id,
            ]);
        }

        // Use the following instead for mysql
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        //
        // Use the following instead for sqlite
        // DB::statement('PRAGMA foreign_keys = ON;');
        // Device::factory()->count(5)->create();
    }
}
