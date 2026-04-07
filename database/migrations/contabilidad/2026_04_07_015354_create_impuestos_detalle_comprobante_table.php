<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('impuestos_detalle_comprobante', function (Blueprint $table) {
            $table->id();
            $table->foreignId('detalle_comprobante_id')
                ->constrained('detalles_comprobante')
                ->onDelete('cascade')
                ->name('id_detalle_comprobante_fk');
                
            $table->foreignId('tasa_impuesto_id')
                ->constrained('tasas_impuesto');
                
            $table->decimal('base_imponible', 15, 2);
            $table->decimal('monto_impuesto', 15, 2);
            $table->timestamps();
            
            $table->index(['detalle_comprobante_id', 'tasa_impuesto_id'], 'idx_impuestos_det_comp');
        });
    }

    public function down()
    {
        Schema::dropIfExists('impuestos_detalle_comprobante');
    }
};
