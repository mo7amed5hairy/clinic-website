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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_id');
            $table->foreign('tenant_id')
                ->references('id')
                ->on('tenants')
                ->onDelete('cascade');
            $table->foreignId('clinic_id')->constrained('clinics')->cascadeOnDelete();
            
            // Toggle columns for each module
            $table->boolean('doctors_enabled')->default(true);
            $table->boolean('clinic_news_enabled')->default(true);
            $table->boolean('units_enabled')->default(true);
            $table->boolean('why_us_enabled')->default(true);
            $table->boolean('media_center_videos_enabled')->default(true);
            $table->boolean('clinic_statistics_enabled')->default(true);
            $table->boolean('insurance_companies_enabled')->default(true);
            $table->boolean('installment_methods_enabled')->default(true);
            $table->boolean('contact_info_enabled')->default(true);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
