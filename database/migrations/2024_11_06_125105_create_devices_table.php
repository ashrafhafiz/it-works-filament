<?php

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
            $table->string('model');
            $table->string('service_tag');
            $table->string('processor_type');
            $table->string('memory_size');
            $table->string('storage1_size');
            $table->string('storage2_size');
            $table->string('graphics_1');
            $table->string('graphics_2');
            $table->string('sound');
            $table->string('ethernet');
            $table->string('wireless');
            $table->string('display');
            $table->date('shipping_date');
            $table->enum('status', ["active","ready","reserved","retired","repair"]);
            $table->foreignId('employee_id');
            $table->foreignId('manufacturer_id');
            $table->foreignId('device_type_id');
            $table->timestamps();
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
