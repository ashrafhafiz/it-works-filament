<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Mobile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;

class MobileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = database_path('csvs/mobiles_v2.csv');
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);

        $records = $csv->getRecords();

        // Use the following instead for mysql
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        //
        // for SQL: as in https://github.com/laravel/framework/issues/35401
        // DB::table('mobiles')->delete();
        //
        // Use the following instead for sqlite
        // DB::statement('PRAGMA foreign_keys = OFF;');
        DB::table('mobiles')->truncate();

        foreach ($records as $record) {
            Mobile::create([
                'employee_no' => $record['employee_no'],
                'mobile_no' => $record['mobile_no'],
                'm_name_ar' => $record['m_name_ar'],
                'm_national_id' => $record['m_national_id'],
                'm_address' => $record['m_address'],
                'm_location' => $record['m_location'],
                'mobile_type' => 'voice',
                'rate_plan' => $record['rate_plan'],
                'bouquet_value' => $record['bouquet_value'],
                'status' => $record['status'],
            ]);
        }

        // Use the following instead for mysql
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        //
        // Use the following instead for sqlite
        // DB::statement('PRAGMA foreign_keys = ON;');
        // Mobile::factory()->count(5)->create();
    }
}