<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exchange_rates', function (Blueprint $table) {
            $table->id();
            $table->date('fecha')->unique();
            $table->decimal('bcv', 14, 4);       // 771.0700
            $table->decimal('bina', 14, 4)->nullable(); // 880.0000
            $table->foreignId('user_id')->nullable()
                  ->constrained()->nullOnDelete();
            $table->timestamps();

            $table->index('fecha');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exchange_rates');
    }
};