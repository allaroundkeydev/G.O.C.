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
        Schema::create('tareas_instancia_valores', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('instancia_id');
            $table->unsignedBigInteger('campo_id');
            $table->text('valor_text')->nullable();
            $table->decimal('valor_num', 18, 2)->nullable();
            $table->date('valor_fecha')->nullable();
            $table->boolean('valor_bool')->nullable();
            $table->string('valor_entity_type', 100)->nullable();
            $table->unsignedBigInteger('valor_entity_id')->nullable();
            $table->timestamps();
            
            // Unique constraint
            $table->unique(['instancia_id', 'campo_id']);
            
            // Foreign keys
            $table->foreign('instancia_id')->references('id')->on('tareas_instancias')->onDelete('cascade');
            $table->foreign('campo_id')->references('id')->on('tareas_campos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tareas_instancia_valores');
    }
};