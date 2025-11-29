<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('impuestos_detalle_asiento', function (Blueprint $table) {
            $table->id();
            $table->foreignId('detalle_asiento_id')->constrained('detalles_asiento')->onDelete('cascade');
            $table->foreignId('tipo_impuesto_id')->constrained('tipos_impuesto');
            $table->foreignId('tasa_impuesto_id')->constrained('tasas_impuesto'); // Tasa histórica
            
            // Cálculos
            $table->decimal('base_imponible', 15, 2);
            $table->decimal('tasa_aplicada', 8, 4);
            $table->decimal('monto_impuesto', 15, 2);
            $table->decimal('monto_retencion', 15, 2)->default(0);
            
            // Naturaleza
            $table->enum('naturaleza', ['CREDITO', 'DEBITO', 'RETENCION']);
            $table->boolean('es_retencion')->default(false);
            
            // Cuentas afectadas
            $table->foreignId('cuenta_impuesto_id')->constrained('cuentas_contables');
            $table->foreignId('cuenta_retencion_id')->nullable()->constrained('cuentas_contables');
            
            $table->text('concepto')->nullable();
            $table->timestamps();
            
            // Índices
            $table->index(['detalle_asiento_id', 'tipo_impuesto_id']);
            $table->index(['tasa_impuesto_id', 'created_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('impuestos_detalle_asiento');
    }
};