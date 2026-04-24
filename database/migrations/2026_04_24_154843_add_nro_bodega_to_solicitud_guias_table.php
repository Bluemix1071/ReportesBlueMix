<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNroBodegaToSolicitudGuiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('solicitud_guias', function (Blueprint $table) {
            $table->bigInteger('nro_bodega')->nullable()->after('estado')->comment('Correlativo de salida_de_bodega');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('solicitud_guias', function (Blueprint $table) {
            $table->dropColumn('nro_bodega');
        });
    }
}
