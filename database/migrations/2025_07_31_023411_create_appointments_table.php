<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('patient_name');
            $table->string('patient_email');
            $table->string('patient_contact');
            $table->text('purpose');
            $table->text('remarks')->nullable();
            $table->time('schedule_time');
            $table->date('schedule_date');
            $table->enum('status', ['pending', 'active', 'past_due', 'cancelled'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
