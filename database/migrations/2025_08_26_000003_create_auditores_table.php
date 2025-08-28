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
        Schema::create('auditores', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 200);
            $table->string('telefono', 50)->nullable();
            $table->string('correo_electronico', 200)->nullable();
            $table->string('empresa', 200)->nullable();
            $table->string('num_vpcpa', 100)->nullable();
            $table->boolean('nombrado')->default(false);
            $table->timestamps();
            $table->softDeletes();
            
            // Indices
            $table->index('num_vpcpa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auditores');
    }
};