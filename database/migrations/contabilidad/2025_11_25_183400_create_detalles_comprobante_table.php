<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('detalles_comprobante', function (Blueprint $table) {
            $table->id();
            $table->foreignId('comprobante_id')->constrained('comprobantes')->onDelete('cascade');
            $table->foreignId('producto_id')->nullable()->constrained('productos');
            $table->foreignId('cuenta_contable_id')->constrained('cuentas_contables');
            
            // Descripción
            $table->string('descripcion', 500);
            $table->text('observaciones')->nullable();
            
            // Cantidades y precios
            $table->decimal('cantidad', 12, 4)->default(1);
            $table->decimal('precio_unitario', 15, 4)->default(0);
            $table->decimal('descuento_porcentaje', 5, 2)->default(0);
            $table->decimal('descuento_monto', 15, 2)->default(0);
            
            // Subtotal
            $table->decimal('subtotal', 15, 2)->default(0);
            $table->decimal('total_impuestos', 15, 2)->default(0);
            $table->decimal('total_retenciones', 15, 2)->default(0);
            $table->decimal('total', 15, 2)->default(0);
            
            // Para contabilidad
            $table->foreignId('detalle_asiento_id')->nullable()->constrained('detalles_asiento');
            $table->boolean('afecta_inventario')->default(false);
            
            $table->timestamps();
            
            // Índices
            $table->index(['comprobante_id', 'cuenta_contable_id']);
            $table->index(['producto_id', 'afecta_inventario']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('detalles_comprobante');
    }
};