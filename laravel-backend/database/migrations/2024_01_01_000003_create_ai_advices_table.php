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
        Schema::create('ai_advices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('current_level'); // Level keuangan saat ini
            $table->integer('target_level'); // Level target berikutnya
            $table->longText('advice_text'); // Teks saran AI
            $table->json('financial_data'); // Data keuangan yang digunakan untuk saran
            $table->enum('status', ['active', 'archived'])->default('active');
            $table->timestamp('generated_at'); // Kapan saran dibuat
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_advices');
    }
};
