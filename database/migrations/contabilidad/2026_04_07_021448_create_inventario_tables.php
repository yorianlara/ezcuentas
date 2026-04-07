<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1. Categorías de Producto
        Schema::create('categorias_producto', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresas');
            $table->string('nombre', 100);
            $table->string('descripcion', 255)->nullable();
            $table->foreignId('parent_id')->nullable()->constrained('categorias_producto');
            $table->boolean('activo')->default(true);
            $table->timestamps();
            
            $table->unique(['empresa_id', 'nombre']);
        });

        // 2. Productos
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresas');
            $table->foreignId('categoria_id')->nullable()->constrained('categorias_producto');
            
            $table->string('nombre', 200);
            $table->string('sku', 50)->nullable();
            $table->string('codigo_barras', 100)->nullable();
            $table->text('descripcion')->nullable();
            
            // Inventario
            $table->string('unidad_medida', 20)->default('UNIDAD');
            $table->decimal('stock_actual', 15, 4)->default(0);
            $table->decimal('stock_minimo', 15, 4)->default(0);
            $table->decimal('costo_promedio', 15, 4)->default(0);
            
            // Precios
            $table->decimal('precio_venta', 15, 4)->default(0);
            
            $table->boolean('es_servicio')->default(false);
            $table->boolean('activo')->default(true);
            $table->timestamps();
            
            $table->unique(['empresa_id', 'sku']);
        });

        // 3. Movimientos de Inventario
        Schema::create('movimientos_inventario', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresas');
            $table->foreignId('producto_id')->constrained('productos');
            
            $table->date('fecha');
            $table->enum('tipo_movimiento', ['ENTRADA', 'SALIDA', 'AJUSTE_POSITIVO', 'AJUSTE_NEGATIVO'])->default('ENTRADA');
            $table->string('descripcion', 255);
            
            // Cantidades y costos
            $table->decimal('cantidad', 15, 4);
            $table->decimal('costo_unitario', 15, 4)->default(0);
            $table->decimal('stock_antes', 15, 4)->default(0);
            $table->decimal('stock_despues', 15, 4)->default(0);
            
            // Referencias
            $table->string('referencia_tipo', 50)->nullable(); // Ej: COMPROBANTE
            $table->unsignedBigInteger('referencia_id')->nullable();
            
            $table->foreignId('creado_por')->constrained('users');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('movimientos_inventario');
        Schema::dropIfExists('productos');
        Schema::dropIfExists('categorias_producto');
    }
};
