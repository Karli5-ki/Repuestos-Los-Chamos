<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('numero_factura', 20)->unique();
            $table->foreignId('customer_id')->nullable()
                  ->constrained()->nullOnDelete();
            $table->foreignId('user_id')->constrained()->restrictOnDelete();

            // Si nació de una cotización
            $table->foreignId('quote_id')->nullable()
                  ->constrained()->nullOnDelete();

            $table->date('fecha');

            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('iva', 12, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);

            // Multi-moneda
            $table->decimal('tasa_bcv', 14, 4)->nullable();
            $table->decimal('total_bs', 14, 2)->nullable();

            // Formas de pago: efectivo_usd, efectivo_bs, transferencia, pago_movil, mixto
            $table->enum('tipo_pago', [
                'efectivo_usd', 'efectivo_bs', 'transferencia',
                'pago_movil', 'punto_venta', 'mixto'
            ])->default('efectivo_usd');

            $table->decimal('monto_pagado_usd', 12, 2)->default(0);
            $table->decimal('monto_pagado_bs', 14, 2)->default(0);

            $table->enum('estado', ['activa', 'anulada'])->default('activa');
            $table->text('motivo_anulacion')->nullable();
            $table->foreignId('anulada_por')->nullable()
                  ->constrained('users')->nullOnDelete();
            $table->timestamp('anulada_en')->nullable();

            $table->text('observaciones')->nullable();
            $table->timestamps();

            $table->index('fecha');
            $table->index('estado');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};