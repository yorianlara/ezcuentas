<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1. Cuentas Bancarias Reales
        Schema::create('cuentas_bancarias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresas');
            $table->foreignId('cuenta_contable_id')->constrained('cuentas_contables');
            
            $table->string('nombre_banco', 100);
            $table->string('numero_cuenta', 50);
            $table->enum('tipo_cuenta', ['AHORRO', 'CORRIENTE', 'TARJETA_CREDITO', 'OTRA'])->default('CORRIENTE');
            $table->string('moneda', 3)->default('USD');
            $table->boolean('activo')->default(true);
            $table->timestamps();
            
            $table->unique(['empresa_id', 'numero_cuenta']);
        });

        // 2. Extractos Bancarios (Encabezado)
        Schema::create('extractos_bancarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cuenta_bancaria_id')->constrained('cuentas_bancarias');
            $table->date('fecha_desde');
            $table->date('fecha_hasta');
            $table->decimal('saldo_inicial', 15, 2)->default(0);
            $table->decimal('saldo_final', 15, 2)->default(0);
            $table->enum('estado', ['BORRADOR', 'CONCILIADO', 'CERRADO'])->default('BORRADOR');
            $table->timestamps();
            
            $table->index(['fecha_desde', 'fecha_hasta']);
        });

        // 3. Detalles de Extracto (Movimientos)
        Schema::create('detalles_extracto', function (Blueprint $table) {
            $table->id();
            $table->foreignId('extracto_id')->constrained('extractos_bancarios')->onDelete('cascade');
            // Referencia a contabilidad si se ha conciliado
            $table->foreignId('detalle_asiento_id')->nullable()->constrained('detalles_asiento');
            
            $table->date('fecha');
            $table->string('descripcion', 500);
            $table->string('referencia', 100)->nullable();
            $table->decimal('monto', 15, 2); // Positivo Entrada, Negativo Salida
            $table->boolean('conciliado')->default(false);
            $table->timestamps();
            
            $table->index(['fecha', 'conciliado']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('detalles_extracto');
        Schema::dropIfExists('extractos_bancarios');
        Schema::dropIfExists('cuentas_bancarias');
    }
};
