<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateConfiguracionSucursalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configuracion_sucursal', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('clave')->unique();
            $table->string('valor')->nullable();
            $table->timestamps();
        });

        // Insertar el valor inicial
        DB::table('configuracion_sucursal')->insert([
            'clave' => 'limite_activo_egresos',
            'valor' => '1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('configuracion_sucursal');
    }
}
