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

        Schema::create('cuenta_impuesto', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cuenta_contable_id')->constrained('cuentas_contables');
            $table->foreignId('tipo_impuesto_id')->constrained('tipos_impuesto');
            $table->boolean('aplicable_debito')->default(true);
            $table->boolean('aplicable_credito')->default(false);
            $table->boolean('activo')->default(true);
            $table->timestamps();
            
            // Una cuenta no puede tener el mismo impuesto duplicado
            $table->unique(['cuenta_contable_id', 'tipo_impuesto_id']);
            $table->index(['activo', 'cuenta_contable_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cuenta_impuesto');
    }
};
