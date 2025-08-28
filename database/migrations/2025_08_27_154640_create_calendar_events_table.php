<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalendarEventsTable extends Migration
{
    public function up()
    {
        Schema::create('calendar_events', function (Blueprint $table) {
            $table->id();
            $table->string('title', 250);
            $table->dateTime('start_at')->nullable();
            $table->dateTime('end_at')->nullable();
            $table->boolean('all_day')->default(false);
            $table->text('description')->nullable();
            $table->string('related_type')->nullable(); // polymorphic
            $table->unsignedBigInteger('related_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable()->index();
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            // Nota: no creamos FK para related_*, es polymorphic
        });
    }

    public function down()
    {
        Schema::dropIfExists('calendar_events');
    }
}
