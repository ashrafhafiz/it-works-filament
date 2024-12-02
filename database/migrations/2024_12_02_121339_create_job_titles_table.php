<?php

use App\Models\User;
use App\Models\JobCategory;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('job_titles', function (Blueprint $table) {
            $table->id();
            $table->integer('job_title_id')->unique();
            $table->string('job_title_name_ar');
            $table->string('job_title_name_en')->nullable();
            $table->foreignIdFor(JobCategory::class, 'job_category_id')->nullable();
            $table->string('job_code')->nullable();
            $table->enum('job_class', ["White Collars", "Blue Collars"])->nullable();
            $table->foreignIdFor(User::class, 'created_by')->nullable();
            $table->foreignIdFor(User::class, 'updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_titles');
    }
};