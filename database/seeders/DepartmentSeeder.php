<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Sector;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $filePath = database_path('csvs/departments.csv');
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);

        $records = $csv->getRecords();

        // Use the following instead for mysql
        // DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        //
        // for SQL: as in https://github.com/laravel/framework/issues/35401
        // DB::table('locations')->delete();
        //
        // Use the following instead for sqlite
        DB::statement('PRAGMA foreign_keys = OFF;');
        DB::table('departments')->truncate();

        foreach ($records as $record) {
            $sector_id = Sector::where('name', $record['sector'])->get()->first()->id;
            $department_name = $record['department'];
            Department::create([
                'sector_id' => $sector_id,
                'name' => $department_name
            ]);

            // DB::table('departments')->insert($record);
            // echo $record['Sector'] . PHP_EOL;
        }

        // Use the following instead for mysql
        // DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        //
        // Use the following instead for sqlite
        DB::statement('PRAGMA foreign_keys = ON;');

        // Department::factory()->count(5)->create();
    }
}
