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
        Schema::create('financial_forms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('savings', 15, 2); // Total tabungan
            $table->decimal('debt', 15, 2); // Total hutang
            $table->decimal('monthly_income', 15, 2); // Gaji bulanan bersih
            $table->decimal('house_expense', 15, 2); // Pengeluaran rumah tangga
            $table->decimal('entertainment_expense', 15, 2); // Pengeluaran hiburan
            $table->decimal('food_expense', 15, 2)->nullable(); // Pengeluaran makanan
            $table->decimal('transportation_expense', 15, 2)->nullable(); // Pengeluaran transportasi
            $table->decimal('healthcare_expense', 15, 2)->nullable(); // Pengeluaran kesehatan
            $table->decimal('education_expense', 15, 2)->nullable(); // Pengeluaran pendidikan
            $table->decimal('child_expense', 15, 2)->nullable(); // Pengeluaran anak
            $table->boolean('has_children')->default(false); // Memiliki anak
            $table->decimal('total_investment', 15, 2)->nullable(); // Total investasi yang paling dominan
            $table->string('investment_type')->nullable(); // Bentuk investasi yang paling dominan
            $table->text('financial_goals')->nullable(); // Tujuan keuangan
            $table->enum('risk_tolerance', ['low', 'medium', 'high'])->default('medium'); // Toleransi risiko
            $table->integer('calculated_level')->default(0); // Level keuangan yang dihitung
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_forms');
    }
};
