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
        Schema::create('tareas_campos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tarea_id');
            $table->string('nombre', 150); // identificador interno
            $table->string('etiqueta', 200)->nullable();
            $table->text('descripcion')->nullable();
            $table->string('tipo', 50); // 'numerico','texto','fecha','booleano','entidad','lista','moneda'
            $table->boolean('obligatorio')->default(false);
            $table->text('opciones')->nullable(); // JSON text para listas
            $table->integer('orden')->default(0);
            $table->text('meta')->nullable(); // JSON text
            $table->timestamps();
            
            // Foreign key
            $table->foreign('tarea_id')->references('id')->on('tareas')->onDelete('cascade');
            
            // Indices
            $table->index('tarea_id');
            $table->index('nombre');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tareas_campos');
    }
};