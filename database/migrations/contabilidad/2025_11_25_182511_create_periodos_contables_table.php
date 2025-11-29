<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('periodos_contables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ejercicio_fiscal_id')->constrained('ejercicios_fiscales');
            $table->string('nombre', 50); // Enero 2024, Febrero 2024, etc.
            $table->integer('mes'); // 1-12
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->boolean('activo')->default(false);
            $table->boolean('cerrado')->default(false);
            $table->date('fecha_cierre')->nullable();
            $table->text('observaciones_cierre')->nullable();
            
            // Estados de aprobación
            $table->enum('estado', ['BORRADOR', 'APROBADO', 'CERRADO'])->default('BORRADOR');
            
            // Auditoría
            $table->foreignId('cerrado_por')->nullable()->constrained('users');
            $table->timestamps();
            $table->softDeletes();
            
            // Índices
            $table->unique(['ejercicio_fiscal_id', 'mes']);
            $table->index(['fecha_inicio', 'fecha_fin']);
            $table->index(['activo', 'cerrado', 'estado']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('periodos_contables');
    }
};