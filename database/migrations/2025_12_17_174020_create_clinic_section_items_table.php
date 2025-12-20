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

        Schema::create('clinic_section_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('clinic_section_id')
                ->constrained()
                ->onDelete('cascade');

            $table->json('title')->nullable();        // translation ready
            $table->json('description')->nullable();  // translation ready
            $table->string('image')->nullable();
            $table->string('value')->nullable();      // link / phone / email
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clinic_section_items');
    }
};
