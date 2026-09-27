<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->string('numero_factura')->nullable();    // número del proveedor
            $table->foreignId('supplier_id')->constrained()->restrictOnDelete();
            $table->foreignId('user_id')->constrained()->restrictOnDelete(); // quién la registró

            $table->date('fecha');
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('iva', 12, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);

            // Estado: activa / anulada
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
        Schema::dropIfExists('purchases');
    }
};