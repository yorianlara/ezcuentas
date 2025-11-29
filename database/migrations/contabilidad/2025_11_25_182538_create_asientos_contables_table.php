<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('asientos_contables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('periodo_contable_id')->constrained('periodos_contables');
            $table->foreignId('empresa_id')->constrained('empresas');
            
            // Numeración automática
            $table->string('numero_asiento', 50)->unique();
            $table->date('fecha_asiento');
            $table->text('concepto');
            $table->text('glosa')->nullable();
            
            // Totales con validación
            $table->decimal('total_debe', 15, 2)->default(0);
            $table->decimal('total_haber', 15, 2)->default(0);
            $table->decimal('diferencia', 15, 2)->default(0);
            
            // Estados
            $table->enum('estado', ['BORRADOR', 'PENDIENTE', 'APROBADO', 'ANULADO'])->default('BORRADOR');
            $table->enum('origen', ['MANUAL', 'SISTEMA', 'COMPROBANTE'])->default('MANUAL');
            
            // Referencias
            $table->string('referencia')->nullable();
            $table->string('documento_soporte')->nullable();
            
            // Auditoría
            $table->foreignId('creado_por')->constrained('users');
            $table->foreignId('aprobado_por')->nullable()->constrained('users');
            $table->timestamp('fecha_aprobacion')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            // Índices críticos
            $table->index(['periodo_contable_id', 'fecha_asiento']);
            $table->index(['empresa_id', 'estado']);
            $table->index(['fecha_asiento', 'origen']);
            $table->index('numero_asiento');
        });
    }

    public function down()
    {
        Schema::dropIfExists('asientos_contables');
    }
};