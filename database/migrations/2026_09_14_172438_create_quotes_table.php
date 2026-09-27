<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->string('numero', 20)->unique();         // 0000-0539
            $table->foreignId('customer_id')->nullable()
                  ->constrained()->nullOnDelete();
            $table->foreignId('user_id')->constrained()->restrictOnDelete();

            $table->date('fecha_emision');
            $table->date('fecha_vencimiento')->nullable();

            // Totales congelados al momento de emitir
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('iva', 12, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);
            $table->decimal('tasa_bcv', 14, 4)->nullable();  // tasa del día

            // borrador | enviada | aprobada | rechazada | vencida | convertida
            $table->enum('estado', [
                'borrador', 'enviada', 'aprobada',
                'rechazada', 'vencida', 'convertida'
            ])->default('borrador');

            $table->text('observaciones')->nullable();
            $table->timestamps();

            $table->index('fecha_emision');
            $table->index('estado');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quotes');
    }
};