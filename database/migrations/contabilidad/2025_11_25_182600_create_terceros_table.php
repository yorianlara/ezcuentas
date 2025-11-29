<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('terceros', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresas');
            
            // Tipo de tercero
            $table->enum('tipo', ['CLIENTE', 'PROVEEDOR', 'EMPLEADO', 'OTRO'])->default('CLIENTE');
            $table->string('codigo', 50)->unique();
            
            // Información básica
            $table->string('razon_social', 200);
            $table->string('nombre_comercial', 200)->nullable();
            $table->string('tipo_documento', 3)->default('RIF'); // RIF, CI, PAS, etc.
            $table->string('numero_documento', 20);
            $table->string('email', 100)->nullable();
            $table->string('telefono', 50)->nullable();
            $table->string('direccion')->nullable();
            
            // Información fiscal
            $table->boolean('contribuyente')->default(true);
            $table->string('condicion_iva', 50)->nullable();
            
            // Estados
            $table->boolean('activo')->default(true);
            $table->boolean('bloqueado')->default(false);
            
            // Auditoría
            $table->timestamps();
            $table->softDeletes();
            
            // Índices
            $table->unique(['empresa_id', 'numero_documento']);
            $table->index(['tipo', 'activo']);
            $table->index('codigo');
            $table->index('razon_social');
        });
    }

    public function down()
    {
        Schema::dropIfExists('terceros');
    }
};