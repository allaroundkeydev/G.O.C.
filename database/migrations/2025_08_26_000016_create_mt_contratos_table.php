<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mt_contratos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cliente_id');
            $table->date('fecha_contrato');
            $table->text('descripcion')->nullable();
            $table->string('archivo_referencia', 255)->nullable();
            $table->timestamp('created_at')->nullable();
            
            // Foreign key
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
            
            // Indices
            $table->index('cliente_id');
            $table->index('fecha_contrato');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mt_contratos');
    }
};