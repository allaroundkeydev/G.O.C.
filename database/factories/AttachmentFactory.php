<?php
namespace Database\Factories;

use App\Models\Attachment;
use App\Models\Cliente;
use App\Models\TareaInstancia;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttachmentFactory extends Factory
{
    protected $model = Attachment::class;

    public function definition()
    {
        $inst = TareaInstancia::inRandomOrder()->first();
        return [
            'instancia_id' => $inst?->id,
            'cliente_id' => Cliente::inRandomOrder()->first()?->id,
            'tipo' => $this->faker->randomElement(['contrato_mt','comprobante_iva','documento_general']),
            'ruta' => 'attachments/' . $this->faker->uuid . '.pdf',
            'nombre_original' => $this->faker->word . '.pdf',
            'mime' => 'application/pdf',
            'tamano' => $this->faker->numberBetween(1024, 5000000),
            'uploaded_by' => User::inRandomOrder()->first()?->id,
        ];
    }
}
