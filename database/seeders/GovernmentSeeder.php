<?php

namespace Database\Seeders;

use App\Models\Government;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GovernmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $governments = [
            ['government_name_ar' => 'القاهرة', 'government_name_en' => 'Cairo',],
            ['government_name_ar' => 'الجيزة', 'government_name_en' => 'Giza',],
            ['government_name_ar' => 'بنى سويف', 'government_name_en' => 'Beni Suef',],
            ['government_name_ar' => 'المنيا', 'government_name_en' => 'Minya',],
            ['government_name_ar' => 'اسيوط', 'government_name_en' => 'Assiut',],
            ['government_name_ar' => 'سوهاج', 'government_name_en' => 'Sohag',],
            ['government_name_ar' => 'قنا', 'government_name_en' => 'Qena',],
            ['government_name_ar' => 'الاقصر', 'government_name_en' => 'Luxor',],
            ['government_name_ar' => 'اسوان', 'government_name_en' => 'Aswan',],
            ['government_name_ar' => 'البحر الاحمر', 'government_name_en' => 'Red Sea',],
            ['government_name_ar' => 'الوادى الجديد', 'government_name_en' => 'New Valley',],
            ['government_name_ar' => 'السويس', 'government_name_en' => 'Suez',],
            ['government_name_ar' => 'الاسماعيلية', 'government_name_en' => 'Ismailia',],
            ['government_name_ar' => 'بورسعيد', 'government_name_en' => 'Port Said',],
            ['government_name_ar' => 'شمال سيناء', 'government_name_en' => 'North Sinai',],
            ['government_name_ar' => 'جنوب سيناء', 'government_name_en' => 'South Sinai',],
            ['government_name_ar' => 'الفيوم', 'government_name_en' => 'Fayoum',],
            ['government_name_ar' => 'القليوبية', 'government_name_en' => 'Qalyubia',],
            ['government_name_ar' => 'الشرقية', 'government_name_en' => 'Sharqia',],
            ['government_name_ar' => 'الغربية', 'government_name_en' => 'Gharbia',],
            ['government_name_ar' => 'المنوفية', 'government_name_en' => 'Monofia',],
            ['government_name_ar' => 'الدقهلية', 'government_name_en' => 'Dakahlia',],
            ['government_name_ar' => 'دمياط', 'government_name_en' => 'Damietta',],
            ['government_name_ar' => 'الاسكندرية', 'government_name_en' => 'Alexandria',],
            ['government_name_ar' => 'مرسى مطروح', 'government_name_en' => 'Marsa Matrouh',],
            ['government_name_ar' => 'كفر الشيخ', 'government_name_en' => 'Kafr El Sheikh',],
            ['government_name_ar' => 'البحيرة', 'government_name_en' => 'Beheira',],
        ];

        // Use the following instead for mysql
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        //
        // for SQL: as in https://github.com/laravel/framework/issues/35401
        // DB::table('governments')->delete();
        //
        // Use the following instead for sqlite
        // DB::statement('PRAGMA foreign_keys = OFF;');
        DB::table('governments')->truncate();

        foreach ($governments as $government) {
            Government::create($government);
        }

        // Use the following instead for mysql
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        //
        // Use the following instead for sqlite
        // DB::statement('PRAGMA foreign_keys = ON;');

        // Government::factory()->count(5)->create();
    }
}
