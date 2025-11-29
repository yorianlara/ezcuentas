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
        Schema::create('tasas_impuesto', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipo_impuesto_id')->constrained('tipos_impuesto');
            $table->decimal('tasa', 8, 4); // Hasta 9999.9999%
            $table->date('fecha_vigencia_inicio');
            $table->date('fecha_vigencia_fin')->nullable();
            $table->text('observaciones')->nullable();
            $table->boolean('activo')->default(true);
            
            // Auditoría de creación
            $table->foreignId('creado_por')->nullable()->constrained('users');
            $table->timestamps();
            
            // Índices para búsqueda por vigencia
            $table->index(['tipo_impuesto_id', 'fecha_vigencia_inicio', 'fecha_vigencia_fin']);
            $table->index(['fecha_vigencia_inicio', 'activo']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasas_impuestos');
    }
};
