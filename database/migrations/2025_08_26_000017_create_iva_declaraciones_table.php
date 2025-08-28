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
        Schema::create('iva_declaraciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cliente_id');
            $table->date('periodo_inicio');
            $table->date('periodo_fin');
            $table->date('fecha_presentacion')->nullable();
            $table->decimal('monto_a_pagar', 18, 2)->nullable();
            $table->boolean('plazo')->default(false);
            $table->integer('cantidad_cuotas')->default(0);
            $table->integer('dia_pago')->nullable();
            $table->timestamp('created_at')->nullable();
            
            // Foreign key
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
            
            // Indices
            $table->index('cliente_id');
            $table->index('fecha_presentacion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('iva_declaraciones');
    }
};