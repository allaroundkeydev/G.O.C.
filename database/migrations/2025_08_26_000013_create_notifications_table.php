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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('instancia_id')->nullable();
            $table->string('tipo', 50); // 'email','sms','push'
            $table->string('destinatario', 250);
            $table->integer('umbral_days_before')->nullable();
            $table->boolean('enviado')->default(false);
            $table->datetime('enviado_at')->nullable();
            $table->text('payload')->nullable();
            $table->timestamps();
            
            // Foreign key
            $table->foreign('instancia_id')->references('id')->on('tareas_instancias')->onDelete('cascade');
            
            // Indices
            $table->index('instancia_id');
            $table->index('destinatario');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};