<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable(); // guardamos JSON/text
            $table->string('type', 50)->default('string');
            $table->string('descripcion')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
        });

        // Insertar algunos valores por defecto útiles
        DB::table('settings')->insert([
            ['key'=>'alerta_umbral_default','value'=>json_encode(['dias'=>30]),'type'=>'json','descripcion'=>'Días por defecto para alertas','created_at'=>now(),'updated_at'=>now()],
            ['key'=>'notificacion_plan','value'=>json_encode(['email'=>true,'sms'=>false]),'type'=>'json','descripcion'=>'Canales por defecto para notificaciones','created_at'=>now(),'updated_at'=>now()],
            ['key'=>'iva_history_keep','value'=>'6','type'=>'int','descripcion'=>'Número de declaraciones IVA a conservar por cliente','created_at'=>now(),'updated_at'=>now()],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
