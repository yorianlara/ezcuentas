<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tipos_comprobante', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 20)->unique();
            $table->string('nombre', 100);
            $table->string('abreviatura', 10);
            $table->enum('naturaleza', ['INGRESO', 'EGRESO', 'TRANSFERENCIA', 'DIARIO', 'APERTURA', 'CIERRE']);
            $table->boolean('afecta_caja')->default(false);
            $table->boolean('afecta_banco')->default(false);
            $table->boolean('requiere_tercero')->default(true);
            $table->boolean('activo')->default(true);
            $table->json('configuracion')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['codigo', 'activo']);
            $table->index('naturaleza');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tipos_comprobante');
    }
};