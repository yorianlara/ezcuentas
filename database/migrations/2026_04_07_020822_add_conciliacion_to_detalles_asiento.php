<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('detalles_asiento', function (Blueprint $table) {
            $table->boolean('conciliado')->default(false)->after('base_imponible');
            $table->index(['conciliado', 'cuenta_contable_id']);
        });
    }

    public function down()
    {
        Schema::table('detalles_asiento', function (Blueprint $table) {
            $table->dropIndex(['conciliado', 'cuenta_contable_id']);
            $table->dropColumn('conciliado');
        });
    }
};
