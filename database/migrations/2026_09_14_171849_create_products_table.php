<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();               // 0103B1-1688-227710
            $table->string('descripcion', 500);               // BUJE TENSOR TORONTA...
            $table->foreignId('brand_id')->nullable()
                  ->constrained('brands')->nullOnDelete();
            $table->foreignId('unit_id')->nullable()
                  ->constrained('units')->nullOnDelete();
            $table->foreignId('category_id')->nullable()
                  ->constrained('categories')->nullOnDelete();

            // Precios
            $table->decimal('precio_compra', 12, 2)->default(0);
            $table->decimal('margen_porcentaje', 5, 2)->default(62.00);
            $table->decimal('precio_venta', 12, 2)->default(0);
            $table->boolean('aplica_iva')->default(true);

            // Stock
            $table->integer('stock')->default(0);
            $table->integer('stock_minimo')->default(0);

            // Estado
            $table->boolean('activo')->default(true);
            $table->text('observaciones')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index('descripcion');
            $table->index('activo');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};