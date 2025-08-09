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
        Schema::create('financial_goals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title'); // Judul target keuangan
            $table->text('description')->nullable(); // Deskripsi target
            $table->decimal('target_amount', 15, 2); // Jumlah target
            $table->decimal('current_amount', 15, 2)->default(0); // Jumlah saat ini
            $table->date('target_date'); // Tanggal target
            $table->enum('status', ['active', 'completed', 'paused'])->default('active');
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_goals');
    }
};
