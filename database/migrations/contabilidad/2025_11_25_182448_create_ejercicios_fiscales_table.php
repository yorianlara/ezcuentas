<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ejercicios_fiscales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresas');
            $table->string('nombre', 100);
            $table->integer('anio');
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->boolean('activo')->default(false);
            $table->boolean('cerrado')->default(false);
            $table->date('fecha_cierre')->nullable();
            $table->text('observaciones_cierre')->nullable();
            
            // Auditoría
            $table->foreignId('cerrado_por')->nullable()->constrained('users');
            $table->timestamps();
            $table->softDeletes();
            
            // Índices
            $table->unique(['empresa_id', 'anio']);
            $table->index(['fecha_inicio', 'fecha_fin']);
            $table->index(['activo', 'cerrado']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('ejercicios_fiscales');
    }
};