<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->restrictOnDelete();

            // entrada | salida | ajuste
            $table->enum('tipo', ['entrada', 'salida', 'ajuste']);

            $table->integer('cantidad');                        // cantidad del movimiento
            $table->integer('stock_anterior');
            $table->integer('stock_nuevo');

            // Motivo legible
            $table->string('motivo', 50);                       // compra, venta, ajuste, anulacion_compra, anulacion_venta, devolucion

            // Referencia polimórfica al documento origen
            $table->nullableMorphs('referencia');               // referencia_type, referencia_id

            $table->text('observaciones')->nullable();
            $table->timestamps();

            $table->index(['product_id', 'created_at']);
            $table->index('tipo');
            $table->index('motivo');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};