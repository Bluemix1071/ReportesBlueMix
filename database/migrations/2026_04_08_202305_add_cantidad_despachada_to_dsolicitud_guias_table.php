<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCantidadDespachadaToDsolicitudGuiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dsolicitud_guias', function (Blueprint $table) {
            $table->integer('cantidad_despachada')->nullable()->after('cantidad');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dsolicitud_guias', function (Blueprint $table) {
            $table->dropColumn('cantidad_despachada');
        });
    }
}
