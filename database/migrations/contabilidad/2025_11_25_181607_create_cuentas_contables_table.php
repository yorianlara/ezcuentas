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
        Schema::create('cuentas_contables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipo_cuenta_id')->constrained('tipos_cuenta');
            $table->foreignId('cuenta_padre_id')->nullable()->constrained('cuentas_contables');
            
            $table->string('codigo', 50);
            $table->string('nombre', 200);
            $table->text('descripcion')->nullable();
            $table->integer('nivel')->default(1);
            $table->boolean('es_cuenta_hoja')->default(true);
            $table->boolean('acepta_movimientos')->default(false);
            $table->boolean('activo')->default(true);
            
            // Campos para análisis
            $table->boolean('es_banco')->default(false);
            $table->boolean('es_efectivo')->default(false);
            $table->boolean('es_tercero')->default(false);
            
            $table->decimal('saldo_inicial', 15, 2)->default(0);
            $table->date('fecha_saldo_inicial');
            
            $table->timestamps();
            $table->softDeletes();
            
            // Índices críticos para performance
            $table->index(['cuenta_padre_id', 'activo']);
            $table->index(['es_cuenta_hoja', 'acepta_movimientos']);
            $table->index(['nivel', 'codigo']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cuentas_contables');
    }
};
