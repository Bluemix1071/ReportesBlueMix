<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSolicitudGuiasTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Tabla Cabecera
        if (!Schema::hasTable('solicitud_guias')) {
            Schema::create('solicitud_guias', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('folio_dte')->nullable()->comment('Folio oficial de la Guía de Despacho');
                $table->timestamp('fecha_solicitud')->useCurrent();
                $table->timestamp('fecha_despacho')->nullable();
                $table->timestamp('fecha_recepcion')->nullable();
                $table->string('usuario');
                $table->integer('estado')->default(0)->comment('0: Pendiente, 1: Despachada, 2: Recibida');
                $table->string('sucursal_destino')->default('Isabel Riquelme');
                $table->timestamps();
            });
        }

        // Tabla Detalle
        if (!Schema::hasTable('dsolicitud_guias')) {
            Schema::create('dsolicitud_guias', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('id_solicitud');
                $table->string('articulo');
                $table->string('detalle');
                $table->string('marca')->nullable();
                $table->integer('cantidad');
                $table->timestamps();

                $table->foreign('id_solicitud')->references('id')->on('solicitud_guias')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dsolicitud_guias');
        Schema::dropIfExists('solicitud_guias');
    }
}
