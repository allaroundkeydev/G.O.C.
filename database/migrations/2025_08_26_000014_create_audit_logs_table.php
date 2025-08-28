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
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->string('entidad', 100);
            $table->unsignedBigInteger('entidad_id')->nullable();
            $table->string('accion', 100);
            $table->unsignedBigInteger('usuario_id')->nullable();
            $table->text('detalles')->nullable(); // JSON
            $table->timestamp('created_at')->nullable();
            
            // Foreign key
            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};