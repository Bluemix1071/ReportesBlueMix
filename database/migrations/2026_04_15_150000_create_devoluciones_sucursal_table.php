<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevolucionesSucursalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Tabla Cabecera
        if (!Schema::hasTable('devoluciones_sucursal')) {
            Schema::create('devoluciones_sucursal', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->timestamp('fecha_solicitud')->useCurrent();
                $table->timestamp('fecha_recepcion')->nullable()->comment('Cuando la Matriz confirma la recepción');
                $table->string('usuario')->comment('Usuario de sucursal que crea la devolución');
                $table->string('motivo')->comment('Motivo de la devolución: Defectuoso, Sobrante, Error, etc.');
                $table->text('observacion')->nullable()->comment('Notas adicionales');
                $table->integer('estado')->default(0)->comment('0: Pendiente, 1: En Tránsito, 2: Recibida en Matriz, 4: Anulada');
                $table->timestamps();
            });
        }

        // Tabla Detalle
        if (!Schema::hasTable('devoluciones_sucursal_detalle')) {
            Schema::create('devoluciones_sucursal_detalle', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('id_devolucion');
                $table->string('articulo');
                $table->string('detalle');
                $table->string('marca')->nullable();
                $table->integer('cantidad');
                $table->timestamps();

                $table->foreign('id_devolucion')
                      ->references('id')
                      ->on('devoluciones_sucursal')
                      ->onDelete('cascade');
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
        Schema::dropIfExists('devoluciones_sucursal_detalle');
        Schema::dropIfExists('devoluciones_sucursal');
    }
}
