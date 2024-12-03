<?php

use App\Models\Device;
use App\Models\Employee;
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
        Schema::create('device_ownership_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Device::class, 'device_id');
            $table->foreignIdFor(Employee::class, 'employee_no');
            $table->dateTime('assigned_date');
            $table->dateTime('returned_date')->nullable();
            $table->string('reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laptop_ownership_histories');
    }
};