<?php

use App\Models\Employee;
use App\Models\TextSms;
use App\Models\User;
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
        Schema::create('text_sms', function (Blueprint $table) {
            $table->id();
            $table->string('message');
            $table->text('response')->nullable();
            $table->foreignIdFor(User::class, 'sent_from');
            $table->foreignIdFor(Employee::class, 'sent_to');
            $table->enum('status', TextSms::STATUS)->default(TextSms::STATUS['PENDING']);
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('text_sms');
    }
};
