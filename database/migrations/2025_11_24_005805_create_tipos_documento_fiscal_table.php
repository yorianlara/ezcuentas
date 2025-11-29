<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tipos_documento_fiscal', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 10)->unique(); 
            $table->string('nombre', 100);
            $table->string('pais', 3)->default('VEN'); 
            $table->string('formato')->nullable(); 
            $table->text('descripcion')->nullable();
            $table->boolean('activo')->default(true);
            $table->integer('longitud')->nullable(); 
            $table->json('configuracion')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['pais', 'activo']);
            $table->index('codigo');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tipos_documento_fiscal');
    }
};