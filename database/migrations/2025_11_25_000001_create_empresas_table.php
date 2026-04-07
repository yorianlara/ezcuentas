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
        Schema::create('empresas', function (Blueprint $table) {
            $table->id();
            
            // Información básica
            $table->string('codigo', 50)->unique();
            $table->string('nombre', 150);
            $table->string('razon_social', 200);
            
            // Documento fiscal (multi-país)
            $table->foreignId('tipo_documento_fiscal_id')->nullable()->constrained('tipos_documento_fiscal');
            $table->string('numero_documento', 30);
            $table->string('pais', 3)->default('VEN'); // ISO 3166-1 alpha-3
            
            // Información de contacto
            $table->string('direccion')->nullable();
            $table->string('telefono', 50)->nullable();
            $table->string('email', 100)->nullable();

            $table->string('esquema')->unique();
            $table->boolean('activo')->default(true);
            $table->timestamps();
            $table->softDeletes();

            // Índices
            $table->index(['codigo', 'activo']);
            $table->index(['pais', 'activo']);
            $table->index('numero_documento');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empresas');
    }
};
