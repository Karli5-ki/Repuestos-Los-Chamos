<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quote_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quote_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->restrictOnDelete();

            // Snapshot por si el producto cambia después
            $table->string('codigo_snapshot', 100);
            $table->string('descripcion_snapshot', 500);
            $table->string('unidad_snapshot', 20)->nullable();
            $table->string('marca_snapshot', 50)->nullable();

            $table->decimal('cantidad', 10, 2);              // admite 1.5, 2.5...
            $table->decimal('precio_unitario', 12, 2);
            $table->decimal('subtotal', 12, 2);
            $table->boolean('aplica_iva')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quote_items');
    }
};