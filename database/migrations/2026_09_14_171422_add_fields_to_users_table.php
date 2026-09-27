<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->unique()->after('name');
            $table->string('cedula')->nullable()->after('username');
            $table->string('telefono')->nullable()->after('cedula');
            $table->boolean('activo')->default(true)->after('password');
            $table->timestamp('ultimo_acceso')->nullable()->after('activo');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['username', 'cedula', 'telefono', 'activo', 'ultimo_acceso']);
        });
    }
};