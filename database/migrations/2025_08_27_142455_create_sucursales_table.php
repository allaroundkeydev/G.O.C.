<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSucursalesTable extends Migration
{
    public function up()
    {
        Schema::create('sucursales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cliente_id')->index();
            $table->string('referencia', 50)->nullable();
            $table->string('direccion')->nullable();
            $table->string('telefono', 50)->nullable();
            $table->string('codigo_hacienda', 100)->nullable();
            $table->timestamps();

            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('sucursales');
    }
}
