<?php

use App\Models\Employee;
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
        Schema::create('mobiles', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Employee::class, 'employee_no');
            $table->string('m_name_ar')->nullable();
            $table->string('m_national_id')->nullable();
            $table->string('m_address')->nullable();
            $table->string('m_location')->nullable();
            $table->string('mobile_no')->nullable();
            $table->enum('mobile_type', ['voice', 'data'])->nullable();
            $table->enum('status', ['active', 'inactive', 'suspended', 'disconnected'])->nullable();
            $table->string('rate_plan')->nullable();
            $table->integer('bouquet_value')->nullable();
            $table->string('notes')->nullable();
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
        Schema::dropIfExists('mobiles');
    }
};