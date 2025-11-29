<?php
// database/migrations/2024_01_01_000002_create_empresa_user_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('empresa_user', function (Blueprint $table) {
            $table->id();
            
            // Claves foráneas
            $table->foreignId('user_id')
                  ->constrained()
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
                  
            $table->foreignId('empresa_id')
                  ->constrained()
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            
            // Campos adicionales del pivote
            //$table->enum('rol', ['admin', 'contador', 'auditor', 'lector'])>default('lector');
                  
            $table->boolean('activo')->default(true);
            $table->timestamp('fecha_inicio')->useCurrent();
            $table->timestamp('fecha_fin')->nullable();
            
            // Índices únicos y compuestos
            $table->unique(['user_id', 'empresa_id']);
            //$table->index('rol');
            $table->index('activo');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('empresa_user');
    }
};