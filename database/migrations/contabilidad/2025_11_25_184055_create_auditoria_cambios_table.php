<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('auditoria_cambios', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('tabla_afectada', 100);
            $table->unsignedBigInteger('registro_id');
            $table->string('accion', 10); // CREATE, UPDATE, DELETE
            $table->json('valores_anteriores')->nullable();
            $table->json('valores_nuevos')->nullable();
            $table->text('observaciones')->nullable();
            
            // Contexto
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();
            $table->string('url', 500)->nullable();
            
            // Auditoría
            $table->foreignId('usuario_id')->nullable()->constrained('users');
            $table->timestamps();
            
            // Índices
            $table->index(['tabla_afectada', 'registro_id']);
            $table->index(['usuario_id', 'created_at']);
            $table->index('accion');
        });
    }

    public function down()
    {
        Schema::dropIfExists('auditoria_cambios');
    }
};