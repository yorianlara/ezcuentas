<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tipos_impuesto', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 20)->unique();
            $table->string('nombre', 100);
            $table->enum('naturaleza', ['CREDITO', 'DEBITO', 'RETENCION']);
            $table->enum('tipo_calculo', ['PORCENTAJE', 'MONTO_FIJO']);
            $table->string('descripcion')->nullable();
            $table->boolean('activo')->default(true);
            $table->json('configuracion')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['codigo', 'activo']);
            $table->index('naturaleza');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipos_impuestos');
    }
};
