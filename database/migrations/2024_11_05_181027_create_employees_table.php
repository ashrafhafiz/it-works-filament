<?php

use App\Models\Department;
use App\Models\Division;
use App\Models\Employee;
use App\Models\Government;
use App\Models\Graduation;
use App\Models\JobTitle;
use App\Models\Location;
use App\Models\Nationality;
use App\Models\Religion;
use App\Models\Sector;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            // $table->integer('id');
            $table->integer('employee_no')->unique();
            $table->string('name_ar')->unique();
            $table->string('name_en')->nullable();
            $table->string('email')->nullable();
            $table->string('password');
            $table->date('hiring_date');
            $table->date('birth_date');
            $table->enum('status', ["active", "inactive", "terminated"])->default('active');
            $table->string('company')->default('Giza Cable Industries');
            $table->foreignIdFor(Government::class, 'government_id')->nullable();
            $table->foreignIdFor(Graduation::class, 'graduation_id')->nullable();
            $table->foreignIdFor(Division::class, 'division_id')->nullable();
            $table->foreignIdFor(Division::class, 'parent_division_id')->nullable();
            $table->foreignIdFor(JobTitle::class, 'job_title_id')->nullable();
            $table->foreignIdFor(Nationality::class, 'nationality_id')->nullable();
            $table->foreignIdFor(Religion::class, 'religion_id')->nullable();
            $table->string('mobile_1')->nullable();
            $table->string('national_id')->nullable();
            $table->string('address')->nullable();
            $table->enum('gender', ["Male", "Female"])->nullable();
            $table->enum('class', ["White Collars", "Blue Collars"])->nullable();
            // $table->integer('employee_no');
            // $table->primary(['id', 'employee_no']);
            $table->foreignIdFor(Employee::class, 'report_to')->nullable();
            $table->foreignIdFor(Location::class)->nullable();
            $table->foreignIdFor(Sector::class)->nullable();
            $table->foreignIdFor(Department::class)->nullable();
            $table->timestamp('last_login_timestamp')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};