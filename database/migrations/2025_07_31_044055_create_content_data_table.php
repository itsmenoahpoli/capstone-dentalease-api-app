<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('content_data', function (Blueprint $table) {
            $table->id();
            $table->enum('category', [
                'clinic_information',
                'clinic_announcements',
                'latest_developments',
                'owner_information',
                'our_team'
            ]);
            $table->string('title');
            $table->text('content');
            $table->json('metadata')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique('category');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('content_data');
    }
};
