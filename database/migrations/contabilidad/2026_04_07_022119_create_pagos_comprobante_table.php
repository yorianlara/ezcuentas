<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pagos_comprobante', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresas');
            $table->foreignId('comprobante_id')->constrained('comprobantes');
            
            $table->date('fecha');
            $table->decimal('monto', 15, 2);
            $table->string('metodo_pago', 50)->default('BANCO'); // CAJA, BANCO, TARJETA
            $table->string('referencia', 100)->nullable();
            
            // Contabilidad
            $table->foreignId('cuenta_contable_id')->constrained('cuentas_contables'); // Cuenta de origen (Caja/Banco)
            $table->foreignId('asiento_contable_id')->nullable()->constrained('asientos_contables');
            
            $table->foreignId('creado_por')->constrained('users');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pagos_comprobante');
    }
};
