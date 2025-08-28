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
        Schema::create('hacienda_presentaciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cliente_id');
            $table->string('tipo_presentacion', 50); // 'ISR','PAGO_A_CUENTA','F211', etc.
            $table->date('fecha_presentacion')->nullable();
            $table->decimal('monto', 18, 2)->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamp('created_at')->nullable();
            
            // Foreign key
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
            
            // Indices
            $table->index('cliente_id');
            $table->index('tipo_presentacion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hacienda_presentaciones');
    }
};