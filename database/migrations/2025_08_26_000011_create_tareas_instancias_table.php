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
        Schema::create('tareas_instancias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tarea_id');
            $table->unsignedBigInteger('tarea_cliente_id')->nullable();
            $table->unsignedBigInteger('cliente_id');
            $table->unsignedBigInteger('contador_id')->nullable();
            $table->unsignedBigInteger('auditor_id')->nullable();
            $table->unsignedBigInteger('representante_id')->nullable();
            $table->string('estado', 50)->default('PENDIENTE');
            $table->datetime('fecha_vencimiento')->nullable();
            $table->datetime('fecha_realizacion')->nullable();
            $table->text('notas')->nullable();
            $table->text('datos_snapshot')->nullable(); // JSON serializado opcional
            $table->timestamps();
            $table->softDeletes();
            
            // Foreign keys
            $table->foreign('tarea_id')->references('id')->on('tareas')->onDelete('cascade');
            $table->foreign('tarea_cliente_id')->references('id')->on('tareas_clientes')->onDelete('set null');
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
            $table->foreign('contador_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('auditor_id')->references('id')->on('auditores')->onDelete('set null');
            $table->foreign('representante_id')->references('id')->on('representantes')->onDelete('set null');
            
            // Indices
            $table->index('cliente_id');
            $table->index('fecha_vencimiento');
            $table->index('estado');
            $table->index('contador_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tareas_instancias');
    }
};