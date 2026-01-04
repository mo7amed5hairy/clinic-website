<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('clinic_statistics', function (Blueprint $table) {
            $table->foreignId('clinic_id')->nullable()->constrained('clinics')->cascadeOnDelete();
            $table->json('items')->nullable();
            
            $table->dropColumn(['statistics_name', 'statistic_value']);
        });
    }

    public function down(): void
    {
        Schema::table('clinic_statistics', function (Blueprint $table) {
            $table->dropForeign(['clinic_id']);
            $table->dropColumn(['clinic_id', 'items']);
            
            $table->string('statistics_name');
            $table->string('statistic_value');
        });
    }
};
