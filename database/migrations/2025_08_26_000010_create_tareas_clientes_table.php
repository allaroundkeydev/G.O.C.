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
        Schema::create('tareas_clientes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tarea_id');
            $table->unsignedBigInteger('cliente_id');
            $table->unsignedBigInteger('contador_id')->nullable();
            $table->unsignedBigInteger('auditor_id')->nullable();
            $table->unsignedBigInteger('representante_id')->nullable();
            $table->unsignedBigInteger('institucion_id')->nullable();
            $table->text('recurrence_rule')->nullable(); // almacenar RRULE o JSON de recurrencia
            $table->integer('alerta_dias_antes')->default(7);
            $table->boolean('activo')->default(true);
            $table->timestamps();
            $table->softDeletes();

            // Unique constraint
            $table->unique(['tarea_id', 'cliente_id']);
            
            // Foreign keys
            $table->foreign('tarea_id')->references('id')->on('tareas')->onDelete('cascade');
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
            $table->foreign('contador_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('auditor_id')->references('id')->on('auditores')->onDelete('set null');
            $table->foreign('representante_id')->references('id')->on('representantes')->onDelete('set null');
            $table->foreign('institucion_id')->references('id')->on('instituciones')->onDelete('set null');
            
            // Indices
            $table->index('cliente_id');
            $table->index('tarea_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tareas_clientes');
    }
};