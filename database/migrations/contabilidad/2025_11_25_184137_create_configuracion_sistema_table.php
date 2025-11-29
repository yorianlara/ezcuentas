<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('configuracion_sistema', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->nullable()->constrained('empresas');
            
            $table->string('clave', 100);
            $table->text('valor')->nullable();
            $table->string('tipo', 50)->default('string'); // string, integer, boolean, json, decimal
            $table->string('categoria', 100)->default('general');
            $table->text('descripcion')->nullable();
            $table->json('opciones')->nullable(); // Para select, radio, etc.
            $table->boolean('editable')->default(true);
            $table->boolean('requerido')->default(false);
            
            $table->timestamps();
            
            // Índices
            $table->unique(['empresa_id', 'clave']);
            $table->index(['categoria', 'editable']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('configuracion_sistema');
    }
};