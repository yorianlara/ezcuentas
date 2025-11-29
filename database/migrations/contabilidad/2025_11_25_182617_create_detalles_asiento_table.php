<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('detalles_asiento', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asiento_contable_id')->constrained('asientos_contables')->onDelete('cascade');
            $table->foreignId('cuenta_contable_id')->constrained('cuentas_contables');
            $table->foreignId('tercero_id')->nullable()->constrained('terceros');
            
            // Montos
            $table->decimal('debe', 15, 2)->default(0);
            $table->decimal('haber', 15, 2)->default(0);
            $table->decimal('tipo_cambio', 10, 4)->default(1);
            
            // Concepto específico
            $table->text('concepto');
            $table->string('referencia')->nullable();
            
            // Para análisis
            $table->enum('tipo_movimiento', ['NORMAL', 'AJUSTE', 'CIERRE'])->default('NORMAL');
            $table->boolean('afecta_base_impuesto')->default(false);
            $table->decimal('base_imponible', 15, 2)->default(0);
            
            $table->timestamps();
            
            // Índices
            $table->index(['asiento_contable_id', 'cuenta_contable_id']);
            $table->index(['cuenta_contable_id', 'created_at']);
            $table->index('tercero_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('detalles_asiento');
    }
};