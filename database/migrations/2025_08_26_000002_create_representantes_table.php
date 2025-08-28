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
        Schema::create('representantes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cliente_id');
            $table->string('nombre', 200);
            $table->date('fecha_nacimiento')->nullable();
            $table->string('telefono', 50)->nullable();
            $table->string('correo_electronico', 200)->nullable();
            $table->string('dui', 50)->nullable();
            $table->date('fecha_nombramiento')->nullable();
            $table->integer('duracion_meses')->nullable();
            $table->date('fecha_fin_nombramiento')->nullable();
            $table->string('numero_acta', 100)->nullable();
            $table->string('numero_acuerdo', 100)->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            // Foreign key
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
            
            // Indices
            $table->index('cliente_id');
            $table->index('dui');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('representantes');
    }
};