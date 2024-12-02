<?php

namespace Database\Seeders;

use App\Models\Graduation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GraduationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $graduations = [
            ['graduation_name_ar' => 'ليسانس حقوق', 'graduation_name_en' => 'Bachelor of Law', 'created_by' => 1,],
            ['graduation_name_ar' => 'ليسانس اداب', 'graduation_name_en' => 'Bachelor of Arts', 'created_by' => 1,],
            ['graduation_name_ar' => 'بكالوريوس هندسة', 'graduation_name_en' => 'Bachelor of Engineering', 'created_by' => 1,],
            ['graduation_name_ar' => 'بكالوريوس تجارة', 'graduation_name_en' => 'Bachelor of Commerce', 'created_by' => 1,],
            ['graduation_name_ar' => 'بكالوريوس حاسبات ومعلومات', 'graduation_name_en' => 'Bachelor of Computers and Information', 'created_by' => 1,],
            ['graduation_name_ar' => 'بكالوريوس علوم', 'graduation_name_en' => 'Bachelor of Science', 'created_by' => 1,],
            ['graduation_name_ar' => 'دبلوم صناعى', 'graduation_name_en' => 'Industrial Diploma', 'created_by' => 1,],
            ['graduation_name_ar' => 'معهد فنى صناعى', 'graduation_name_en' => 'Industrial Technical Institute', 'created_by' => 1,],
            ['graduation_name_ar' => 'دبلوم تجارة', 'graduation_name_en' => 'Commerce Diploma', 'created_by' => 1,],
            ['graduation_name_ar' => 'معهد فنى تجارى', 'graduation_name_en' => 'Commercial Technical Institute', 'created_by' => 1,],
            ['graduation_name_ar' => 'دبلوم زراعى', 'graduation_name_en' => 'Agricultural Diploma', 'created_by' => 1,],
            ['graduation_name_ar' => 'معهد صحافة', 'graduation_name_en' => 'Journalism Institute', 'created_by' => 1,],
            ['graduation_name_ar' => 'ليسانس السن', 'graduation_name_en' => 'Bachelor of Age', 'created_by' => 1,],
            ['graduation_name_ar' => 'محو امية', 'graduation_name_en' => 'Illiteracy', 'created_by' => 1,],
            ['graduation_name_ar' => 'ابتدائية', 'graduation_name_en' => 'Primary', 'created_by' => 1,],
            ['graduation_name_ar' => 'اعدادية', 'graduation_name_en' => 'Preparatory', 'created_by' => 1,],
            ['graduation_name_ar' => 'ثانوية عامة', 'graduation_name_en' => 'General Secondary', 'created_by' => 1,],
            ['graduation_name_ar' => 'ثانوية ازهرية', 'graduation_name_en' => 'Azhar Secondary', 'created_by' => 1,],
            ['graduation_name_ar' => 'بكالوريوس رقابة جودة', 'graduation_name_en' => 'Bachelor of Quality Control', 'created_by' => 1,],
            ['graduation_name_ar' => 'بكالوريوس خدمة اجتماعية', 'graduation_name_en' => 'Bachelor of Social Service', 'created_by' => 1,],
            ['graduation_name_ar' => 'دبلوم سياحة وفنادق', 'graduation_name_en' => 'Diploma of Tourism and Hotels', 'created_by' => 1,],
            ['graduation_name_ar' => 'لم يحدد بعد', 'graduation_name_en' => 'Not yet determined', 'created_by' => 1,],
            ['graduation_name_ar' => 'بكالوريوس اعلام', 'graduation_name_en' => 'Bachelor of Media', 'created_by' => 1,],
            ['graduation_name_ar' => 'بكالوريوس علوم الحاسب', 'graduation_name_en' => 'Bachelor of Computer Science', 'created_by' => 1,],
            ['graduation_name_ar' => 'ماجستير ادارة جودة', 'graduation_name_en' => 'Master of Quality Management', 'created_by' => 1,],
            ['graduation_name_ar' => 'بكالوريوس كفاية انتاجية', 'graduation_name_en' => 'Bachelor of Productivity Efficiency', 'created_by' => 1,],
            ['graduation_name_ar' => 'دبلوم فوق متوسط', 'graduation_name_en' => 'Above Intermediate Diploma', 'created_by' => 1,],
            ['graduation_name_ar' => 'دبلوم تدريب مهنى', 'graduation_name_en' => 'Vocational Training Diploma', 'created_by' => 1,],
            ['graduation_name_ar' => 'بكالوريوس تربية صناعية', 'graduation_name_en' => 'Bachelor of Industrial Education', 'created_by' => 1,],
            ['graduation_name_ar' => 'بدون مؤهل', 'graduation_name_en' => 'Without Qualification', 'created_by' => 1,],
            ['graduation_name_ar' => 'معهد فنى قوات مسلحة', 'graduation_name_en' => 'Armed Forces Technical Institute', 'created_by' => 1,],
            ['graduation_name_ar' => 'دبلوم شئون أفراد ق.م', 'graduation_name_en' => 'Diploma of Personnel Affairs Q.M', 'created_by' => 1,],
            ['graduation_name_ar' => 'بكالوريوس إدارة أعمال', 'graduation_name_en' => 'Bachelor of Business Administration', 'created_by' => 1,],
            ['graduation_name_ar' => 'بكالوريوس حاسب ألى', 'graduation_name_en' => 'Bachelor of Computer', 'created_by' => 1,],
            ['graduation_name_ar' => 'بكالوريوس شريعة اسلامية', 'graduation_name_en' => 'Bachelor of Islamic Law', 'created_by' => 1,],
            ['graduation_name_ar' => 'دراسات عليا العلوم البيئية', 'graduation_name_en' => 'Postgraduate Studies Environmental Sciences', 'created_by' => 1,],
            ['graduation_name_ar' => 'بكالوريوس نظم ومعلومات إدارية', 'graduation_name_en' => 'Bachelor of Administrative Systems and Information', 'created_by' => 1,],
            ['graduation_name_ar' => 'بكالوريوس تجارة خارجية', 'graduation_name_en' => 'Bachelor of Foreign Trade', 'created_by' => 1,],
            ['graduation_name_ar' => 'بكالوريوس إدارة صناعية', 'graduation_name_en' => 'Bachelor of Industrial Management', 'created_by' => 1,],
            ['graduation_name_ar' => 'ماجستير إدارة أعمال', 'graduation_name_en' => 'Master of Management Business', 'created_by' => 1,],
            ['graduation_name_ar' => 'بكالوريوس العلوم العسكرية', 'graduation_name_en' => 'Bachelor of Military Science', 'created_by' => 1,],
            ['graduation_name_ar' => 'ليسانس لغة عربية', 'graduation_name_en' => 'Bachelor of Arabic Language', 'created_by' => 1,],
            ['graduation_name_ar' => 'دبلوم فنى قوات مسلحة', 'graduation_name_en' => 'Technical Diploma Armed Forces', 'created_by' => 1,],
            ['graduation_name_ar' => 'بكالوريوس سياحة وفنادق', 'graduation_name_en' => 'Bachelor of Tourism and Hotels', 'created_by' => 1,],
            ['graduation_name_ar' => 'بكالوريوس تربية رياضية', 'graduation_name_en' => 'Bachelor of Physical Education', 'created_by' => 1,],
            ['graduation_name_ar' => 'ليسانس دراسات اسلامية', 'graduation_name_en' => 'Bachelor of Islamic Studies', 'created_by' => 1,],
            ['graduation_name_ar' => 'بكالوريوس نظم ومعلومات', 'graduation_name_en' => 'Bachelor of Systems and Information', 'created_by' => 1,],
            ['graduation_name_ar' => 'دراسات عليا إدارة أعمال', 'graduation_name_en' => 'Postgraduate Business Administration', 'created_by' => 1,],
            ['graduation_name_ar' => 'بكالوريوس علوم ادارية', 'graduation_name_en' => 'Bachelor of Administrative Sciences', 'created_by' => 1,],
            ['graduation_name_ar' => 'بكالوريوس أقتصاد', 'graduation_name_en' => 'Bachelor of Economics', 'created_by' => 1,],
        ];

        // Use the following instead for mysql
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        //
        // for SQL: as in https://github.com/laravel/framework/issues/35401
        // DB::table('graduations')->delete();
        //
        // Use the following instead for sqlite
        // DB::statement('PRAGMA foreign_keys = OFF;');
        DB::table('graduations')->truncate();

        foreach ($graduations as $graduation) {
            Graduation::create($graduation);
        }

        // Use the following instead for mysql
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        //
        // Use the following instead for sqlite
        // DB::statement('PRAGMA foreign_keys = ON;');

        // Graduation::factory()->count(5)->create();

    }
}