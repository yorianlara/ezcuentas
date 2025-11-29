<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('comprobantes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipo_comprobante_id')->constrained('tipos_comprobante');
            $table->foreignId('empresa_id')->constrained('empresas');
            $table->foreignId('tercero_id')->nullable()->constrained('terceros');
            $table->foreignId('asiento_contable_id')->nullable()->constrained('asientos_contables');
            
            // Numeración
            $table->string('prefijo', 10);
            $table->integer('numero');
            $table->string('numero_completo', 50)->unique();
            
            // Fechas
            $table->date('fecha_emision');
            $table->date('fecha_vencimiento')->nullable();
            $table->date('fecha_recepcion')->nullable();
            
            // Montos
            $table->decimal('subtotal', 15, 2)->default(0);
            $table->decimal('total_impuestos', 15, 2)->default(0);
            $table->decimal('total_retenciones', 15, 2)->default(0);
            $table->decimal('total', 15, 2)->default(0);
            $table->decimal('total_pagado', 15, 2)->default(0);
            $table->decimal('saldo_pendiente', 15, 2)->default(0);
            
            // Estados
            $table->enum('estado', ['BORRADOR', 'PENDIENTE', 'APROBADO', 'ANULADO', 'PAGADO_PARCIAL', 'PAGADO'])->default('BORRADOR');
            $table->enum('estado_pago', ['PENDIENTE', 'PARCIAL', 'PAGADO'])->default('PENDIENTE');
            
            // Información adicional
            $table->text('concepto');
            $table->text('observaciones')->nullable();
            $table->string('referencia_externa')->nullable();
            $table->string('documento_soporte')->nullable();
            
            // Auditoría
            $table->foreignId('creado_por')->constrained('users');
            $table->foreignId('aprobado_por')->nullable()->constrained('users');
            $table->timestamp('fecha_aprobacion')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            // Índices
            $table->unique(['empresa_id', 'prefijo', 'numero']);
            $table->index(['tipo_comprobante_id', 'fecha_emision']);
            $table->index(['tercero_id', 'estado']);
            $table->index(['estado_pago', 'fecha_vencimiento']);
            $table->index('numero_completo');
        });
    }

    public function down()
    {
        Schema::dropIfExists('comprobantes');
    }
};