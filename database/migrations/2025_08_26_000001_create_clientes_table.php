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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('razon_social', 250);
            $table->string('dui', 50)->unique()->nullable();
            $table->string('nit', 50)->unique()->nullable();
            $table->string('nrc', 50)->nullable();
            $table->date('fecha_constitucion')->nullable();
            $table->date('fecha_inscripcion')->nullable();
            $table->string('tipo_gobierno', 100)->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            // Indices
            $table->index('nit');
            $table->index('dui');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};