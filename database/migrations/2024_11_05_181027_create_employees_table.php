<?php

use App\Models\Department;
use App\Models\Employee;
use App\Models\Location;
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
            $table->string('name_ar')->unique();
            $table->string('name_en')->nullable();
            $table->string('email')->nullable();
            $table->enum('status', ["active", "inactive", "terminated"])->default('active');
            $table->string('company')->default('Giza Cable Industries');
            $table->string('job_title');
            $table->enum('class', ["White Collars", "Blue Collars"])->default('White Collars');
            $table->string('national_id');
            $table->string('employee_no');
            $table->foreignIdFor(Employee::class, 'report_to')->nullable();
            $table->foreignIdFor(Location::class);
            $table->foreignIdFor(Sector::class);
            $table->foreignIdFor(Department::class)->nullable();
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
