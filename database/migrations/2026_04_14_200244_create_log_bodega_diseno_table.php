<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogBodegaDisenoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_bodega_diseno', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('codigo_producto');
            $table->enum('tipo_movimiento', ['INGRESO', 'EGRESO']);
            $table->integer('cantidad');
            $table->string('motivo');
            $table->string('referencia')->nullable();
            $table->unsignedBigInteger('id_usuario');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('log_bodega_diseno');
    }
}
