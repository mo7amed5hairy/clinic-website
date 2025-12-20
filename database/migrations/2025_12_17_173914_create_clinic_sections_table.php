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
        Schema::create('clinic_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('clinic_id')->constrained()->onDelete('cascade');

            $table->string('key');
            // social, contact, about, overview, vision, mission, why_us

            $table->json('title')->nullable(); // translation ready
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['clinic_id', 'key']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clinic_sections');
    }
};
