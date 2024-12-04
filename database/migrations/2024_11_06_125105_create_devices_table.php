<?php

use App\Models\DeviceType;
use App\Models\Employee;
use App\Models\Manufacturer;
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
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->string('service_tag')->unique();
            $table->foreignIdFor(DeviceType::class, 'device_type_id');
            $table->foreignIdFor(Manufacturer::class, 'manufacturer_id');
            $table->string('model');
            $table->enum('status', ["active", "available", "reserved", "retired", "repair"]);
            $table->string('processor_type');
            $table->string('memory_size');
            $table->json('storage_size');
            $table->string('graphics');
            $table->string('sound');
            $table->string('ethernet');
            $table->string('wireless');
            $table->string('display');
            $table->date('shipping_date');
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();
            // $table->string('storage1_size');
            // $table->string('storage2_size');
            // $table->string('graphics_1');
            // $table->string('graphics_2');
            // $table->foreignIdFor(Employee::class, 'employee_no');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};