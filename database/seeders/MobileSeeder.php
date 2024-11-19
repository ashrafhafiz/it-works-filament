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
        $filePath = database_path('csvs/mobiles.csv');
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);

        $records = $csv->getRecords();

        // Use the following instead for mysql
        // DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        //
        // for SQL: as in https://github.com/laravel/framework/issues/35401
        // DB::table('mobiles')->delete();
        //
        // Use the following instead for sqlite
        DB::statement('PRAGMA foreign_keys = OFF;');
        DB::table('mobiles')->truncate();

        foreach ($records as $record) {

            $employee_id = Employee::where('name_ar', $record['name_ar'])->get()->first()->id;

            Mobile::create([
                'employee_no' => $employee_id,
                'mobile_no' => $record['mobile_no'],
            ]);
        }

        // Use the following instead for mysql
        // DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        //
        // Use the following instead for sqlite
        DB::statement('PRAGMA foreign_keys = ON;');
        // Mobile::factory()->count(5)->create();
    }
}
