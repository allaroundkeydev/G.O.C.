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
        Schema::create('cliente_actividad', function (Blueprint $table) {
            $table->unsignedBigInteger('cliente_id');
            $table->unsignedBigInteger('actividad_id');
            $table->timestamp('created_at')->nullable();
            
            // Primary key
            $table->primary(['cliente_id', 'actividad_id']);
            
            // Foreign keys
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
            $table->foreign('actividad_id')->references('id')->on('actividad_economica')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cliente_actividad');
    }
};