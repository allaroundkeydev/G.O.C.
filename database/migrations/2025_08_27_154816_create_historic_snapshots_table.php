<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoricSnapshotsTable extends Migration
{
    public function up()
    {
        Schema::create('historic_snapshots', function (Blueprint $table) {
            $table->id();
            $table->string('entity', 150); // ej. 'tareas_instancias'
            $table->unsignedBigInteger('entity_id')->nullable();
            $table->json('snapshot')->nullable();
            $table->unsignedBigInteger('created_by')->nullable()->index();
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->index(['entity', 'entity_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('historic_snapshots');
    }
}
