<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttachmentsTable extends Migration
{
    public function up()
    {
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('instancia_id')->nullable()->index();
            $table->unsignedBigInteger('cliente_id')->nullable()->index();
            $table->string('tipo', 100)->nullable(); // 'contrato_mt','comprobante_iva', etc.
            $table->string('ruta', 255); // path en storage: attachments/...
            $table->string('nombre_original', 255)->nullable();
            $table->string('mime', 100)->nullable();
            $table->unsignedBigInteger('tamano')->nullable();
            $table->unsignedBigInteger('uploaded_by')->nullable()->index();
            $table->timestamps();

            $table->foreign('instancia_id')->references('id')->on('tareas_instancias')->onDelete('cascade');
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
            $table->foreign('uploaded_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('attachments');
    }
}
