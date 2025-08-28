<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsSeeder extends Seeder
{
    public function run()
    {
        // Inserciones básicas (si no existen)
        if (Setting::where('key', 'alerta_umbral_default')->doesntExist()) {
            \DB::table('settings')->insert([
                'key'=>'alerta_umbral_default',
                'value'=>json_encode(['dias'=>30]),
                'type'=>'json',
                'descripcion'=>'Días por defecto para alertas',
                'created_at'=>now(),'updated_at'=>now()
            ]);
        }

        if (Setting::where('key', 'notificacion_plan')->doesntExist()) {
            \DB::table('settings')->insert([
                'key'=>'notificacion_plan',
                'value'=>json_encode(['email'=>true,'sms'=>false]),
                'type'=>'json',
                'descripcion'=>'Canales por defecto',
                'created_at'=>now(),'updated_at'=>now()
            ]);
        }
    }
}
