<?php

namespace Database\Seeders;

use App\Models\Sector;
use League\Csv\Reader;
use App\Models\Employee;
use App\Models\Location;
use App\Models\Department;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = database_path('csvs/employees_v2.csv');
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);

        $records = $csv->getRecords();

        // Use the following instead for mysql
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        //
        // for SQL: as in https://github.com/laravel/framework/issues/35401
        // DB::table('employees')->delete();
        //
        // Use the following instead for sqlite
        // DB::statement('PRAGMA foreign_keys = OFF;');
        DB::table('employees')->truncate();

        foreach ($records as $record) {
            // $location_id = Location::where('name', $record['location'])->get()->first()->id;
            // $sector_id = Sector::where('name', $record['sector'])->get()->first()->id;
            // $department_id = Department::where('name', $record['department'])->get()->first()->id;

            Employee::create([
                'employee_no' => $record['employee_no'],
                'name_ar' => $record['name_ar'],
                'name_en' => $record['name_en'],
                'email' => $record['email'],
                'password' => Hash::make('password'),
                'hiring_date' => $record['hiring_date'],
                'birth_date' => $record['birth_date'],
                'status' => $record['status'],
                // 'company' => $record['company'],
                'government_id' => empty($record['government_id']) ? null : $record['government_id'],
                'graduation_id' => empty($record['graduation_id']) ? null : $record['graduation_id'],
                'division_id' => empty($record['division_id']) ? null : $record['division_id'],
                'parent_division_id' => empty($record['parent_division_id']) ? null : $record['parent_division_id'],
                'job_title_id' => empty($record['job_title_id']) ? null : $record['job_title_id'],
                'nationality_id' => empty($record['nationality_id']) ? null : $record['nationality_id'],
                'religion_id' => empty($record['religion_id']) ? null : $record['religion_id'],
                'mobile_1' => $record['mobile_1'],
                'national_id' => $record['national_id'],
                'address' => $record['address'],
                'gender' => empty($record['gender']) ? null : $record['gender'],
                'class' => empty($record['class']) ? null : $record['class'],
                // 'report_to' => $record['report_to'],
                'report_to' => 0,
                'created_by' => 'System',
                // 'location_id' => $location_id,
                // 'sector_id' => $sector_id,
                // 'department_id' => $department_id,
            ]);
        }

        // Use the following instead for mysql
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        //
        // Use the following instead for sqlite
        // DB::statement('PRAGMA foreign_keys = ON;');
        // Employee::factory()->count(5)->create();
    }
}