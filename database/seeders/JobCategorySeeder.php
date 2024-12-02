<?php

namespace Database\Seeders;

use App\Models\JobCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class JobCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $job_categories = [
            ['job_category_name_ar' => 'نظم ومعلومات', 'job_category_name_en' => 'Systems & Information', 'job_category_prefix' => 'IS', 'created_by' => 1,],
            ['job_category_name_ar' => 'تكنولوجيا المعلومات', 'job_category_name_en' => 'Information Technology', 'job_category_prefix' => 'IT', 'created_by' => 1,],
            ['job_category_name_ar' => 'الصيانة', 'job_category_name_en' => 'Maintenance', 'job_category_prefix' => 'MAI', 'created_by' => 1,],
            ['job_category_name_ar' => 'الصيانة الكهربائية', 'job_category_name_en' => 'Electrical Maintenance', 'job_category_prefix' => 'MAE', 'created_by' => 1,],
            ['job_category_name_ar' => 'الصيانة الميكانيكية', 'job_category_name_en' => 'Mechanical Maintenance', 'job_category_prefix' => 'MAM', 'created_by' => 1,],
            ['job_category_name_ar' => 'الفوركلفت وصيانة معدات الحركة والنقل', 'job_category_name_en' => 'Forklift & Movement & Transport Equipment Maintenance', 'job_category_prefix' => 'MAF', 'created_by' => 1,],
            ['job_category_name_ar' => 'الامن', 'job_category_name_en' => 'Security', 'job_category_prefix' => 'SEC', 'created_by' => 1,],
            ['job_category_name_ar' => 'التخطيط', 'job_category_name_en' => 'Planning', 'job_category_prefix' => 'PLA', 'created_by' => 1,],
            ['job_category_name_ar' => 'الجودة', 'job_category_name_en' => 'Quality', 'job_category_prefix' => 'QC', 'created_by' => 1,],
            ['job_category_name_ar' => 'السلامة والصحة المهنية', 'job_category_name_en' => 'Occupational Safety & Health', 'job_category_prefix' => 'HSE', 'created_by' => 1,],
            ['job_category_name_ar' => 'الموارد البشرية', 'job_category_name_en' => 'Human Resources', 'job_category_prefix' => 'HR', 'created_by' => 1,],
            ['job_category_name_ar' => 'التدريب', 'job_category_name_en' => 'Training', 'job_category_prefix' => 'HRT', 'created_by' => 1,],
            ['job_category_name_ar' => 'الادارية', 'job_category_name_en' => 'Administrative', 'job_category_prefix' => 'HRA', 'created_by' => 1,],
            ['job_category_name_ar' => 'القانونية', 'job_category_name_en' => 'Legal', 'job_category_prefix' => 'LEG', 'created_by' => 1,],
            ['job_category_name_ar' => 'المالية', 'job_category_name_en' => 'Finance', 'job_category_prefix' => 'FIN', 'created_by' => 1,],
            ['job_category_name_ar' => 'التكاليف', 'job_category_name_en' => 'Costs', 'job_category_prefix' => 'COT', 'created_by' => 1,],
            ['job_category_name_ar' => 'توكيد الجودة', 'job_category_name_en' => 'Quality Assurance', 'job_category_prefix' => 'QA', 'created_by' => 1,],
            ['job_category_name_ar' => 'خدمة العملاء', 'job_category_name_en' => 'Customer Service', 'job_category_prefix' => 'CST', 'created_by' => 1,],
            ['job_category_name_ar' => 'المواصفات الفنية', 'job_category_name_en' => 'Technical Specifications', 'job_category_prefix' => 'TEC', 'created_by' => 1,],
            ['job_category_name_ar' => 'المبيعات', 'job_category_name_en' => 'Sales', 'job_category_prefix' => 'SAL', 'created_by' => 1,],
            ['job_category_name_ar' => 'التسويق', 'job_category_name_en' => 'Marketing', 'job_category_prefix' => 'MAK', 'created_by' => 1,],
            ['job_category_name_ar' => 'سلسلة الامدادات', 'job_category_name_en' => 'Supply Chain', 'job_category_prefix' => 'SUP', 'created_by' => 1,],
            ['job_category_name_ar' => 'العمليات', 'job_category_name_en' => 'Operations', 'job_category_prefix' => 'OPE', 'created_by' => 1,],
            ['job_category_name_ar' => 'الانتاج', 'job_category_name_en' => 'Production', 'job_category_prefix' => 'PD', 'created_by' => 1,],
        ];

        // Use the following instead for mysql
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        //
        // for SQL: as in https://github.com/laravel/framework/issues/35401
        // DB::table('job_categories')->delete();
        //
        // Use the following instead for sqlite
        // DB::statement('PRAGMA foreign_keys = OFF;');
        DB::table('job_categories')->truncate();

        foreach ($job_categories as $job_category) {
            JobCategory::create($job_category);
        }

        // Use the following instead for mysql
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        //
        // Use the following instead for sqlite
        // DB::statement('PRAGMA foreign_keys = ON;');

        // JobCategory::factory()->count(5)->create();
    }
}